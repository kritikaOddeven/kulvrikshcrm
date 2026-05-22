<?php

namespace App\Http\Controllers\WhatsApp;

use App\Http\Controllers\Controller;
use App\Models\WhatsappCampaign;
use App\Models\WhatsappTemplate;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Country;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = WhatsappCampaign::with('template')->orderBy('created_at', 'desc')->get();
        return view('admin.whatsapp.campaign.index', compact('campaigns'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'template_id' => 'required|exists:whatsapp_templates,id',
                'start_date' => 'required|date',
                'start_time' => 'required',
                'selected_phones' => 'required|json',
            ]);

            $selectedPhones = json_decode($request->selected_phones, true);
            
            if (empty($selectedPhones)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No recipients selected'
                ]);
            }

            // Process and normalize phone numbers with country codes
            $processedPhones = [];
            foreach ($selectedPhones as $phoneData) {
                $phone = $phoneData['phone'] ?? '';
                
                // Ensure phone has country code (starts with +)
                if (!empty($phone) && !str_starts_with($phone, '+')) {
                    // Try to get phone code from the data or use default
                    $phoneCode = $phoneData['phonecode'] ?? $phoneData['phone_code'] ?? '';
                    
                    if (!empty($phoneCode)) {
                        // Clean phone code
                        $phoneCode = preg_replace('/[^0-9+]/', '', $phoneCode);
                        if (!str_starts_with($phoneCode, '+')) {
                            $phoneCode = '+' . ltrim($phoneCode, '0');
                        }
                        // Clean phone number (remove leading zeros)
                        $phone = ltrim($phone, '0');
                        $phone = $phoneCode . $phone;
                    } else {
                        // If no phone code, log warning but keep original
                        \Log::warning('Phone number without country code', [
                            'phone' => $phone,
                            'data' => $phoneData
                        ]);
                    }
                }

                $processedPhones[] = [
                    'id' => $phoneData['id'] ?? '',
                    'phone' => $phone, // Store with country code
                    'name' => $phoneData['name'] ?? '',
                    'type' => $phoneData['type'] ?? '',
                    'relation' => $phoneData['relation'] ?? ''
                ];
            }

            $campaign = WhatsappCampaign::create([
                'template_id' => $request->template_id,
                'start_date' => $request->start_date,
                'start_time' => $request->start_time,
                'selected_phones' => $processedPhones, // Store processed phones with country codes
                'total_person' => count($processedPhones),
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'WhatsApp campaign created successfully',
                'campaign_id' => $campaign->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating campaign: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $campaign = WhatsappCampaign::with(['template', 'messageLogs'])->findOrFail($id);
        return view('admin.whatsapp.campaign.view', compact('campaign'));
    }

    public function edit($id)
    {
        $campaign = WhatsappCampaign::findOrFail($id);
        $templates = WhatsappTemplate::all();
        return view('admin.whatsapp.campaign.edit', compact('campaign', 'templates'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:whatsapp_campaigns,id',
            'template_id' => 'required|exists:whatsapp_templates,id',
            'start_date' => 'required|date',
            'start_time' => 'required',
        ]);

        $campaign = WhatsappCampaign::findOrFail($request->id);
        $campaign->update([
            'template_id' => $request->template_id,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
        ]);

        return redirect()->route('admin.whatsapp.campaign.list')->with('success', 'WhatsApp campaign updated successfully.');
    }

    public function destroy($id)
    {
        $campaign = WhatsappCampaign::findOrFail($id);
        $campaign->delete();

        return redirect()->route('admin.whatsapp.campaign.list')->with('success', 'WhatsApp campaign deleted successfully.');
    }

     public function advertisement(Request $request)
    {
        $query = Lead::isClient();
        
        // Filter by country if provided
        if ($request->has('country') && $request->country) {
            $query->where('country', $request->country);
        }
        
        // Filter by state if provided
        if ($request->has('state') && $request->state) {
            $query->where('state', $request->state);
        }
        
        // Filter by city if provided
        if ($request->has('city') && $request->city) {
            $query->where('city', $request->city);
        }
        
        // Filter by taluka if provided
        if ($request->has('taluka') && $request->taluka) {
            $query->where('taluka', $request->taluka);
        }
        
        // Filter by village if provided
        if ($request->has('village') && $request->village) {
            $query->where('village', $request->village);
        }
        
        // Apply date filter if provided
        if ($request->has('filter_date') && $request->filter_date) {
            // For advertisements, we might want to filter by created_at or a specific date field
            // Adjust this based on your business logic
            $query->whereDate('created_at', $request->filter_date);
        }
        
        // Get clients with their relationships
        $clients = $query->with(['countries', 'states', 'cities'])
                        ->whereNotNull('email') // Only get clients with email addresses
                        ->get();
        
        $countries = Country::all();
        $templates = WhatsappTemplate::all();
        
        return view('admin.whatsapp.advertisement.index', compact('clients', 'countries', 'templates'));
    }

    // Handle advertisement campaign creation
    public function sendAdvertisement(Request $request)
    {
        try {
            $request->validate([
                'template_id' => 'required|exists:email_templates,id',
                'start_date' => 'required|date|after_or_equal:today',
                'start_time' => 'required|date_format:H:i',
                'selected_emails' => 'required|string', // JSON array of emails
            ]);

            $selectedEmails = json_decode($request->selected_emails, true);
            if (!is_array($selectedEmails) || empty($selectedEmails)) {
                return redirect()->back()->with('error', 'No recipients selected.');
            }

            // Limit to 10 emails at once
            $emailBatches = array_chunk($selectedEmails, 10);
            $firstBatch = $emailBatches[0];

            // Create campaign for the first batch
            $campaign = Campaign::create([
                'template_id'     => $request->template_id,
                'start_date'      => $request->start_date,
                'start_time'      => $request->start_time,
                'selected_emails' => json_encode($firstBatch),
                'total_person'    => count($firstBatch),
                'status'          => 'pending',
                'campaign_type'   => 'advertisement'
            ]);

            // Create email logs for tracking
            foreach ($firstBatch as $recipient) {
                \App\Models\CampaignEmailLog::create([
                    'campaign_id' => $campaign->id,
                    'client_id' => $recipient['id'] ?? null,
                    'email' => $recipient['email'],
                    'person_name' => $recipient['name'] ?? '',
                    'person_type' => 'client',
                    'relation' => 'Client',
                    'status' => 'pending'
                ]);
            }

            // Log activity
            log_activity('MailCampaign', 'create', "Advertisement campaign created for " . count($firstBatch) . " recipients");

            // If there are more batches, inform the user
            if (count($emailBatches) > 1) {
                $totalSelected = count($selectedEmails);
                return redirect()->back()->with('success', "Advertisement campaign created successfully for the first 10 recipients out of {$totalSelected} selected. Please create additional campaigns for remaining recipients.");
            }

            return redirect()->back()->with('success', 'Advertisement campaign created successfully for ' . count($firstBatch) . ' recipients.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the campaign: ' . $e->getMessage());
        }
    }
} 