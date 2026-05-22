<?php
namespace App\Http\Controllers\MassEmail;

use App\Http\Controllers\Controller;
use App\Models\MailCampaign;
use App\Models\EmailTemplate;
use App\Models\Country;
use App\Models\Lead;
use Illuminate\Http\Request;

class MailCampaignController extends Controller
{
    public function index()
    {
        $schedules = MailCampaign::with('template')->get();
        $templates = EmailTemplate::get();
        return view('admin.mass-email.campaign.index', compact('schedules','templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:email_templates,id',
            'schedule_date' => 'required|date',
            'status' => 'required|in:active,inactive'
        ]);

        $campaign = MailCampaign::create([
            'template_id' => $request->template_id,
            'schedule_date' => $request->schedule_date,
            'status' => $request->status
        ]);

        log_activity('MailCampaign', 'create', "New mail campaign created with template ID: {$campaign->template_id}");

        return redirect()->back()->with('success', 'Mail campaign created successfully');
    }

    public function update(Request $request)
    {
        $campaign = MailCampaign::findOrFail($request->id);
        

        $request->validate([
            'template_id' => 'required|exists:email_templates,id',
            'start_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
        ]);

        // Combine date and time for validation
        $scheduledDateTime = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
        if ($scheduledDateTime->isPast()) {
            return response()->json([
                'error' => 'Please select a future date and time.'
            ], 422);
        }

        $campaign->update([
            'template_id' => $request->template_id,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'status' => 'pending'
        ]);

        log_activity('MailCampaign', 'update', "Mail campaign updated: ID {$campaign->id}");

        return redirect()->back()->with('success', 'Mail campaign updated successfully');

    }

    public function destroy($id)
    {
        $campaign = MailCampaign::findOrFail($id);
        $campaign->delete();

        log_activity('MailCampaign', 'delete', "Mail campaign deleted: ID {$id}");

        return redirect()->back()->with('success', 'Mail campaign deleted successfully');
    }

    // Handle AJAX campaign creation from modal
    public function ajaxCreate(Request $request)
    {
        try {
            $request->validate([
                'template_id' => 'required|exists:email_templates,id',
                'start_date' => 'required|date|after_or_equal:today',
                'start_time' => 'required|date_format:H:i',
                'selected_emails' => 'required|string', // JSON array of emails
                'total_person' => 'required|integer|min:1',
                'status' => 'required|in:pending,running,complete',
            ]);

            $selectedEmails = json_decode($request->selected_emails, true);
            if (!is_array($selectedEmails) || empty($selectedEmails)) {
                return redirect()->back()->with('error', 'No recipients selected.');
            }

            $campaign = MailCampaign::create([
                'template_id'     => $request->template_id,
                'start_date'      => $request->start_date,
                'start_time'      => $request->start_time,
                'selected_emails' => json_encode($selectedEmails),
                'total_person'    => $request->total_person,
                'status'          => $request->status,
            ]);

            // Log activity
            log_activity('MailCampaign', 'create', "Campaign created");

            return redirect()->back()->with('success', 'Mail campaign created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the campaign.');
        }
    }

    public function show($id)
    {
        $campaign = MailCampaign::with(['template', 'emailLogs.client.lead'])->findOrFail($id);
        $emailLogs = $campaign->emailLogs;
        
        return view('admin.mass-email.campaign.view', compact('campaign', 'emailLogs'));
    }

    public function edit($id)
    {
        $campaign = MailCampaign::with('template')->findOrFail($id);
        
        // Check if campaign is pending
        if ($campaign->status !== 'pending') {
            return response()->json([
                'error' => 'Only pending campaigns can be edited.'
            ], 403);
        }

        // Format the response data
        $response = [
            'id' => $campaign->id,
            'template_id' => $campaign->template_id,
            'template_name' => $campaign->template->template_name,
            'start_date' => $campaign->start_date,
            'start_time' => $campaign->start_time,
            'status' => $campaign->status
        ];

        return response()->json($response);
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
        $templates = EmailTemplate::all();
        
        return view('admin.mass-email.advertisement.index', compact('clients', 'countries', 'templates'));
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
            $campaign = MailCampaign::create([
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