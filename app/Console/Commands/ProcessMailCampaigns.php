<?php

namespace App\Console\Commands;

use App\Models\MailCampaign;
use App\Models\CampaignEmailLog;
use App\Models\Lead;
use App\Models\Family;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessMailCampaigns extends Command
{
    protected $signature = 'campaigns:process';
    protected $description = 'Process pending mail campaigns';

    public function handle()
    {
        $now = Carbon::now();
        
        // Debug current time
        $this->info("Current time: " . $now->format('Y-m-d H:i:s'));
        
        // Get all pending campaigns first to check data
        $allPending = MailCampaign::where('status', 'pending')->get();
        $this->info("Total pending campaigns: " . $allPending->count());
        
        // Debug each pending campaign
        foreach ($allPending as $campaign) {
            $this->info("Campaign ID: {$campaign->id}");
            $this->info("Start Date: {$campaign->start_date}");
            $this->info("Start Time: {$campaign->start_time}");
            $this->info("Status: {$campaign->status}");
            $this->info("-------------------");
        }
        
        // Get campaigns that are pending and scheduled for now or earlier
        $campaigns = MailCampaign::where('status', 'pending')
            ->where(function($query) use ($now) {
                $query->where(function($q) use ($now) {
                    // Check if start_date is today or earlier
                    $q->whereDate('start_date', '<=', $now->toDateString())
                        // If start_date is today, check if start_time is now or earlier
                        ->where(function($timeQuery) use ($now) {
                            $timeQuery->whereDate('start_date', '<', $now->toDateString())
                                ->orWhere(function($todayQuery) use ($now) {
                                    $todayQuery->whereDate('start_date', '=', $now->toDateString())
                                        ->whereTime('start_time', '<=', $now->format('H:i:s'));
                                });
                        });
                });
            })
            ->with('template')
            ->get();

        $this->info('Campaigns to process: ' . $campaigns->count());

        foreach ($campaigns as $campaign) {
            $this->info("Processing campaign ID: {$campaign->id}");
            
            // Update campaign status to running
            $campaign->update(['status' => 'running']);
            
            // Get selected emails from JSON
            $selectedEmails = json_decode($campaign->selected_emails, true);
            
            if (!is_array($selectedEmails)) {
                $this->error("Invalid email data for campaign {$campaign->id}");
                continue;
            }

            // Create email logs for each recipient
            foreach ($selectedEmails as $emailData) {
                CampaignEmailLog::create([
                    'campaign_id' => $campaign->id,
                    'email' => $emailData['email'],
                    'client_id' => $emailData['id'],
                    'status' => 'pending',
                    'person_name' => $emailData['name'] ?? '',
                    'person_type' => $emailData['type'] ?? 'lead',
                    'relation' => $emailData['relation'] ?? ''
                ]);
            }

            // Process each email
            $logs = CampaignEmailLog::where('campaign_id', $campaign->id)
                ->where('status', 'pending')
                ->get();

            foreach ($logs as $log) {
                try {
                    // Get the lead/client data
                    $lead = Lead::isClient()->find($log->client_id);
                    
                    if (!$lead) {
                        $this->error("Lead not found for ID: {$log->client_id}");
                        $log->update([
                            'status' => 'failed',
                            'error_message' => 'Lead not found'
                        ]);
                        continue;
                    }

                    // Get person details based on the stored data
                    $personName = '';
                    $personType = $log->person_type ?? 'lead';
                    
                    // Check if this is a family member or wife
                    if ($personType === 'wife' && $lead->wifeDetail) {
                        $personName = trim($lead->wifeDetail->first_name . ' ' . $lead->wifeDetail->middle_name . ' ' . $lead->wifeDetail->last_name);
                    } elseif ($personType === 'family') {
                        // Find the family member by name
                        $familyMember = Family::where('lead_id', $lead->id)
                            ->where('name', $log->person_name)
                            ->first();
                        
                        if ($familyMember) {
                            $personName = $familyMember->name;
                        }
                    }
                    
                    // If no specific person found, use lead name
                    if (empty($personName)) {
                        $personName = trim($lead->first_name . ' ' . $lead->middle_name . ' ' . $lead->last_name);
                    }

                    // Replace variables in template
                    $subject = $this->replaceVariables($campaign->template->subject, $personName, $personType, $log->relation);
                    $content = $this->replaceVariables($campaign->template->description, $personName, $personType, $log->relation);

                    // Send email
                    Mail::html($content, function($message) use ($log, $subject) {
                        $message->to($log->email)
                            ->subject($subject);
                    });
                    

                    // Update log status
                    $log->update([
                        'status' => 'sent',
                        'sent_at' => now()
                    ]);

                    $this->info("Email sent to: {$log->email} for: {$personName}");
                } catch (\Exception $e) {
                    $log->update([
                        'status' => 'failed',
                        'error_message' => $e->getMessage()
                    ]);
                    $this->error("Failed to send email to {$log->email}: {$e->getMessage()}");
                }
            }

            // Check if all emails are processed
            $pendingCount = CampaignEmailLog::where('campaign_id', $campaign->id)
                ->where('status', 'pending')
                ->count();

            if ($pendingCount === 0) {
                $campaign->update(['status' => 'complete']);
                $this->info("Campaign {$campaign->id} completed");
            }
        }
    }

    private function replaceVariables($content, $fullName, $personType = 'lead', $relation = '')
    {
        $nameParts = explode(' ', $fullName);
        $firstName = $nameParts[0] ?? '';
        $lastName = end($nameParts) ?? '';

        $replacements = [
            '[firstname]' => $firstName,
            '[lastname]' => $lastName,
            '[fullname]' => $fullName,
            '[persontype]' => ucfirst($personType),
            '[relation]' => $relation
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $content);
    }
} 