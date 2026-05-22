<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WhatsappCampaign;
use App\Models\CampaignWhatsappLog;
use App\Models\Lead;
use App\Models\Family;
use Carbon\Carbon;
use Twilio\Rest\Client as TwilioClient;

class ProcessWhatsappCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:process-campaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process pending WhatsApp campaigns and send messages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting WhatsApp campaign processing...');

        // Get pending campaigns that are due to be sent
        $campaigns = WhatsappCampaign::where('status', 'pending')
            ->where('start_date', '<=', now()->toDateString())
            ->where('start_time', '<=', now()->format('H:i:s'))
            ->with('template')
            ->get();

        if ($campaigns->isEmpty()) {
            $this->info('No pending WhatsApp campaigns found.');
            return;
        }

        foreach ($campaigns as $campaign) {
            $this->info("Processing campaign ID: {$campaign->id}");
            
            try {
                // Update campaign status to processing
                $campaign->update(['status' => 'processing']);

                $selectedPhones = $campaign->selected_phones;
                $template = $campaign->template;
                
                if (!$template) {
                    $this->error("Template not found for campaign ID: {$campaign->id}");
                    $campaign->update(['status' => 'failed']);
                    continue;
                }

                $successCount = 0;
                $failureCount = 0;

                foreach ($selectedPhones as $phoneData) {
                    try {
                        // Get person details based on type
                        $personDetails = $this->getPersonDetails($phoneData);
                        
                        if (!$personDetails) {
                            $this->warn("Person details not found for ID: {$phoneData['id']}, Type: {$phoneData['type']}");
                            $failureCount++;
                            continue;
                        }

                        // Replace template variables for logging
                        $messageContent = $this->replaceTemplateVariables($template->message_text, $personDetails);
                        
                        if ($template->template_footer) {
                            $messageContent .= "\n\n" . $template->template_footer;
                        }

                        // Create message log
                        CampaignWhatsappLog::create([
                            'campaign_id' => $campaign->id,
                            'phone' => $phoneData['phone'],
                            'person_name' => $personDetails['name'],
                            'person_type' => $phoneData['type'],
                            'relation' => $phoneData['relation'],
                            'message_content' => $messageContent,
                            'status' => 'pending',
                        ]);

                        // Send WhatsApp message via Twilio (using template if available)
                        $messageResult = $this->sendWhatsappMessage($phoneData['phone'], $template, $personDetails);
                        
                        // Update log status to sent with message details
                        CampaignWhatsappLog::where('campaign_id', $campaign->id)
                            ->where('phone', $phoneData['phone'])
                            ->update([
                                'status' => $messageResult['status'] === 'queued' || $messageResult['status'] === 'sent' ? 'sent' : 'pending',
                                'sent_at' => now(),
                                'error_message' => isset($messageResult['message_sid']) ? 'Message SID: ' . $messageResult['message_sid'] : null
                            ]);

                        $successCount++;
                        $this->info("Message sent to: {$phoneData['phone']} (Status: {$messageResult['status']}, SID: {$messageResult['message_sid']})");

                    } catch (\Exception $e) {
                        $this->error("Error sending message to {$phoneData['phone']}: " . $e->getMessage());
                        
                        // Update log status to failed
                        CampaignWhatsappLog::where('campaign_id', $campaign->id)
                            ->where('phone', $phoneData['phone'])
                            ->update([
                                'status' => 'failed',
                                'error_message' => $e->getMessage()
                            ]);
                        
                        $failureCount++;
                    }
                }

                // Update campaign status
                $finalStatus = $failureCount > 0 ? ($successCount > 0 ? 'completed' : 'failed') : 'completed';
                $campaign->update(['status' => $finalStatus]);

                $this->info("Campaign ID {$campaign->id} completed. Success: {$successCount}, Failed: {$failureCount}");

            } catch (\Exception $e) {
                $this->error("Error processing campaign ID {$campaign->id}: " . $e->getMessage());
                $campaign->update(['status' => 'failed']);
            }
        }

        $this->info('WhatsApp campaign processing completed.');
    }

    /**
     * Get person details based on type and ID
     */
    private function getPersonDetails($phoneData)
    {
        switch ($phoneData['type']) {
            case 'lead':
                $lead = Lead::find($phoneData['id']);
                if ($lead) {
                    return [
                        'name' => $lead->first_name . ' ' . $lead->middle_name . ' ' . $lead->last_name,
                        'first_name' => $lead->first_name,
                        'last_name' => $lead->last_name,
                        'full_name' => $lead->first_name . ' ' . $lead->middle_name . ' ' . $lead->last_name,
                    ];
                }
                break;

            case 'wife':
                $lead = Lead::with('wifeDetail')->find($phoneData['id']);
                if ($lead && $lead->wifeDetail) {
                    return [
                        'name' => $lead->wifeDetail->first_name . ' ' . $lead->wifeDetail->middle_name . ' ' . $lead->wifeDetail->last_name,
                        'first_name' => $lead->wifeDetail->first_name,
                        'last_name' => $lead->wifeDetail->last_name,
                        'full_name' => $lead->wifeDetail->first_name . ' ' . $lead->wifeDetail->middle_name . ' ' . $lead->wifeDetail->last_name,
                    ];
                }
                break;

            case 'family':
                $family = Family::find($phoneData['id']);
                if ($family) {
                    return [
                        'name' => $family->name,
                        'first_name' => $family->name,
                        'last_name' => '',
                        'full_name' => $family->name,
                    ];
                }
                break;
        }

        return null;
    }

    /**
     * Replace template variables with actual values (for plain text messages)
     */
    private function replaceTemplateVariables($template, $personDetails)
    {
        $replacements = [
            '[firstname]' => $personDetails['first_name'] ?? '',
            '[lastname]' => $personDetails['last_name'] ?? '',
            '[fullname]' => $personDetails['full_name'] ?? '',
            '[name]' => $personDetails['name'] ?? '',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    /**
     * Extract template variables for WhatsApp Content API
     * Returns array of variable names/numbers and values
     * 
     * Twilio WhatsApp templates use {{1}}, {{2}}, etc. for numbered variables
     * The contentVariables should be: {"1": "value1", "2": "value2"}
     */
    private function extractTemplateVariables($template, $personDetails)
    {
        $variables = [];
        
        // Check for numbered variables like {{1}}, {{2}} (Twilio WhatsApp format)
        if (preg_match_all('/\{\{(\d+)\}\}/', $template, $matches)) {
            // Numbered variables like {{1}}, {{2}}
            // Map them based on order found in template: 
            // First {{1}} = firstname, {{2}} = lastname, {{3}} = fullname, {{4}} = name
            $varKeys = ['first_name', 'last_name', 'full_name', 'name'];
            $varIndex = 0;
            
            foreach ($matches[1] as $varNum) {
                // Use the variable number as string key (Twilio expects string keys)
                if (isset($varKeys[$varIndex])) {
                    $key = $varKeys[$varIndex];
                    $variables[$varNum] = $personDetails[$key] ?? '';
                }
                $varIndex++;
            }
        } 
        // Check for bracket variables like [firstname], [lastname] (our internal format)
        elseif (preg_match_all('/\[(firstname|lastname|fullname|name)\]/', $template, $matches)) {
            // Named variables like [firstname], [lastname]
            $varMap = [
                'firstname' => 'first_name',
                'lastname' => 'last_name',
                'fullname' => 'full_name',
                'name' => 'name'
            ];
            
            // Convert to numbered format for Twilio (1, 2, 3, etc.)
            $varNum = 1;
            foreach ($matches[1] as $varName) {
                $key = $varMap[$varName] ?? null;
                if ($key && isset($personDetails[$key])) {
                    // Use numbered format for Twilio Content API
                    $variables[(string)$varNum] = $personDetails[$key];
                    $varNum++;
                }
            }
        }
        
        // If no variables found, return empty array (template might not have variables)
        return $variables;
    }

    /**
     * Send WhatsApp message using Twilio API
     * Supports both template-based and plain text messages
     */
    private function sendWhatsappMessage($phone, $template, $personDetails)
    {
        try {
            // Get Twilio credentials from environment
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $authToken = env('TWILIO_AUTH_TOKEN');
            $fromNumber = env('TWILIO_WHATSAPP_FROM');

            // Validate credentials
            if (empty($accountSid) || empty($authToken) || empty($fromNumber)) {
                throw new \Exception('Twilio credentials are not configured. Please check your .env file.');
            }

            // Initialize Twilio client
            $twilio = new TwilioClient($accountSid, $authToken);

            // Format phone number - ensure it has whatsapp: prefix
            $toNumber = $phone;
            if (!str_starts_with($toNumber, 'whatsapp:')) {
                // Remove any existing + or spaces
                $toNumber = preg_replace('/[^0-9+]/', '', $toNumber);
                // Ensure it starts with +
                if (!str_starts_with($toNumber, '+')) {
                    $toNumber = '+' . $toNumber;
                }
                $toNumber = 'whatsapp:' . $toNumber;
            }

            // Ensure from number has whatsapp: prefix
            $fromNumber = trim($fromNumber);
            if (!str_starts_with($fromNumber, 'whatsapp:')) {
                // Remove any existing whatsapp: prefix first to avoid duplication
                $fromNumber = ltrim($fromNumber, 'whatsapp:');
                $fromNumber = 'whatsapp:' . $fromNumber;
            }

            // Check if template has API name (for WhatsApp template messaging)
            $templateApiName = $template->template_api_name ?? null;
            
            if (!empty($templateApiName)) {
                // Use WhatsApp template with Content API
                $this->info("Using WhatsApp template: {$templateApiName}");
                
                // Extract template variables from message_text
                $contentVariables = $this->extractTemplateVariables($template->message_text, $personDetails);
                
                // Build message parameters for template
                $messageParams = [
                    'from' => $fromNumber,
                    'contentSid' => $templateApiName,
                ];
                
                // Add content variables if any
                // Twilio Content API expects contentVariables as a JSON string
                // Format: {"1": "value1", "2": "value2"} for numbered variables {{1}}, {{2}}
                if (!empty($contentVariables)) {
                    $messageParams['contentVariables'] = json_encode($contentVariables);
                    $this->info("Template variables: " . json_encode($contentVariables));
                } else {
                    $this->comment("No template variables found, sending template without variables");
                }
                
                $this->info("Attempting to send WhatsApp template message to: {$toNumber}");
                $messageResponse = $twilio->messages->create($toNumber, $messageParams);
                
            } else {
                // Fallback to plain text message
                $messageContent = $this->replaceTemplateVariables($template->message_text, $personDetails);
                if ($template->template_footer) {
                    $messageContent .= "\n\n" . $template->template_footer;
                }
                
                $this->info("Attempting to send plain WhatsApp message to: {$toNumber} from: {$fromNumber}");
                
                $messageResponse = $twilio->messages->create(
                    $toNumber,
                    [
                        'from' => $fromNumber,
                        'body' => $messageContent
                    ]
                );
            }

            // Log successful send with full details
            \Log::info("WhatsApp message sent successfully", [
                'to' => $toNumber,
                'from' => $fromNumber,
                'message_sid' => $messageResponse->sid,
                'status' => $messageResponse->status,
                'error_code' => $messageResponse->errorCode ?? null,
                'error_message' => $messageResponse->errorMessage ?? null,
                'price' => $messageResponse->price ?? null,
                'price_unit' => $messageResponse->priceUnit ?? null
            ]);

            // Output detailed information
            $this->info("Twilio Response - SID: {$messageResponse->sid}, Status: {$messageResponse->status}");
            
            if ($messageResponse->errorCode) {
                $this->warn("Warning - Error Code: {$messageResponse->errorCode}, Message: {$messageResponse->errorMessage}");
            }
            
            // Important notes about WhatsApp delivery
            if ($messageResponse->status === 'queued') {
                $this->comment("Note: Message is queued. Delivery may take a few moments.");
                $this->comment("If using Twilio WhatsApp Sandbox, recipient must join by sending the join code first.");
                $this->comment("Check message status in Twilio Console: https://console.twilio.com/us1/monitor/logs/sms");
            } elseif ($messageResponse->status === 'failed') {
                $this->error("Message failed to send. Check Twilio console for details.");
            } elseif ($messageResponse->status === 'sent' || $messageResponse->status === 'delivered') {
                $this->info("✓ Message successfully sent/delivered!");
            }

            // Return detailed result
            return [
                'success' => true,
                'message_sid' => $messageResponse->sid,
                'status' => $messageResponse->status,
                'error_code' => $messageResponse->errorCode ?? null,
                'error_message' => $messageResponse->errorMessage ?? null
            ];

        } catch (\Twilio\Exceptions\RestException $e) {
            // Twilio REST API errors (most common)
            $errorMessage = "Twilio REST Error: " . $e->getMessage();
            $errorCode = $e->getCode();
            $statusCode = $e->getStatusCode();
            
            \Log::error("WhatsApp message sending failed (Twilio REST)", [
                'phone' => $phone,
                'error' => $errorMessage,
                'code' => $errorCode,
                'status_code' => $statusCode,
                'more_info' => $e->getMoreInfo() ?? null
            ]);
            
            $this->error("Twilio Error [{$statusCode}]: {$errorMessage}");
            throw new \Exception($errorMessage . " (Code: {$errorCode}, Status: {$statusCode})");
            
        } catch (\Twilio\Exceptions\TwilioException $e) {
            // Other Twilio-specific errors
            $errorMessage = "Twilio Error: " . $e->getMessage();
            \Log::error("WhatsApp message sending failed (Twilio)", [
                'phone' => $phone,
                'error' => $errorMessage,
                'code' => $e->getCode()
            ]);
            $this->error("Twilio Error: {$errorMessage}");
            throw new \Exception($errorMessage);
            
        } catch (\Exception $e) {
            // General errors
            $errorMessage = "Error sending WhatsApp message: " . $e->getMessage();
            \Log::error("WhatsApp message sending failed (General)", [
                'phone' => $phone,
                'error' => $errorMessage,
                'trace' => $e->getTraceAsString()
            ]);
            $this->error("General Error: {$errorMessage}");
            throw new \Exception($errorMessage);
        }
    }
} 