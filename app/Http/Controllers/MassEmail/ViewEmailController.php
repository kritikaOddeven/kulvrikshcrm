<?php

namespace App\Http\Controllers\MassEmail;

use App\Http\Controllers\Controller;
use App\Models\EmailMessage;
use App\Services\ImapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewEmailController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get email counts for different folders
        $emailCounts = [
            'INBOX' => $user->emailMessages()->inFolder('INBOX')->count(),
            'SENT' => $user->emailMessages()->inFolder('SENT')->count(),
            'DRAFTS' => $user->emailMessages()->inFolder('DRAFTS')->count(),
            'STARRED' => $user->emailMessages()->starred()->count(),
            'TRASH' => $user->emailMessages()->inFolder('TRASH')->count(),
        ];

        // Get request parameters
        $folder = request()->get('folder', 'INBOX');
        $search = request()->get('search', '');
        $page = (int) request()->get('page', 1);

        // Build query based on parameters
        $query = $user->emailMessages();

        // Filter by folder
        if ($folder === 'STARRED') {
            $query->starred();
        } else {
            $query->inFolder($folder);
        }

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('from_email', 'like', "%{$search}%")
                  ->orWhere('from_name', 'like', "%{$search}%")
                  ->orWhere('to_email', 'like', "%{$search}%")
                  ->orWhere('to_name', 'like', "%{$search}%")
                  ->orWhere('body_plain', 'like', "%{$search}%");
            });
        }

        // Get paginated emails
        $emails = $query->orderBy('date_received', 'desc')
                       ->paginate(10, ['*'], 'page', $page);

        return view('admin.mass-email.view-email.index', compact('emailCounts', 'emails', 'folder', 'search', 'page'));
    }

    // public function getEmails(Request $request)
    // {
    //     $user = Auth::user();
    //     $folder = $request->get('folder', 'INBOX');
    //     $search = $request->get('search', '');
    //     $page = (int) $request->get('page', 1);
    //     $perPage = 10; // Fixed to 10 records per page

    //     $query = $user->emailMessages();

    //     // Filter by folder
    //     if ($folder === 'STARRED') {
    //         $query->starred();
    //     } else {
    //         $query->inFolder($folder);
    //     }

    //     // Apply search filter
    //     if ($search) {
    //         $query->where(function($q) use ($search) {
    //             $q->where('subject', 'like', "%{$search}%")
    //               ->orWhere('from_email', 'like', "%{$search}%")
    //               ->orWhere('from_name', 'like', "%{$search}%")
    //               ->orWhere('to_email', 'like', "%{$search}%")
    //               ->orWhere('to_name', 'like', "%{$search}%")
    //               ->orWhere('body_plain', 'like', "%{$search}%");
    //         });
    //     }

    //     $messages = $query->orderBy('date_received', 'desc')
    //                      ->paginate($perPage, ['*'], 'page', $page);

    //     return response()->json([
    //         'success' => true,
    //         'messages' => $messages->items(),
    //         'pagination' => [
    //             'current_page' => $messages->currentPage(),
    //             'last_page' => $messages->lastPage(),
    //             'per_page' => $messages->perPage(),
    //             'total' => $messages->total(),
    //             'from' => $messages->firstItem(),
    //             'to' => $messages->lastItem(),
    //             'has_more_pages' => $messages->hasMorePages(),
    //             'has_previous_page' => $messages->previousPageUrl() !== null,
    //         ]
    //     ]);
    // }

    public function getEmailCounts()
    {
        $user = Auth::user();
        
        $counts = [
            'INBOX' => $user->emailMessages()->inFolder('INBOX')->count(),
            'SENT' => $user->emailMessages()->inFolder('SENT')->count(),
            'DRAFTS' => $user->emailMessages()->inFolder('DRAFTS')->count(),
            'STARRED' => $user->emailMessages()->starred()->count(),
            'TRASH' => $user->emailMessages()->inFolder('TRASH')->count(),
        ];

        return response()->json([
            'success' => true,
            'counts' => $counts
        ]);
    }

    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        $messageIds = $request->get('message_ids', []);

        \Log::info('markAsRead called with message_ids:', $messageIds);

        if (empty($messageIds)) {
            return response()->json(['success' => false, 'message' => 'No messages selected']);
        }

        try {
            $updated = $user->emailMessages()
                ->whereIn('id', $messageIds)
                ->update(['is_read' => true]);

            \Log::info("Marked {$updated} messages as read");

            return response()->json(['success' => true, 'message' => 'Messages marked as read']);
        } catch (\Exception $e) {
            \Log::error('Error marking messages as read: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error marking messages as read: ' . $e->getMessage()]);
        }
    }

    public function toggleStar(Request $request)
    {
        $user = Auth::user();
        $messageId = $request->get('message_id');

        $message = $user->emailMessages()->find($messageId);
        
        if (!$message) {
            return response()->json(['success' => false, 'message' => 'Message not found']);
        }

        $message->update(['is_starred' => !$message->is_starred]);

        return response()->json([
            'success' => true, 
            'message' => 'Star status toggled',
            'is_starred' => $message->is_starred
        ]);
    }

   

    public function deleteMessages(Request $request)
    {
        $user = Auth::user();
        $messageIds = $request->get('message_ids', []);

        \Log::info('deleteMessages called with message_ids:', $messageIds);

        if (empty($messageIds)) {
            return response()->json([
                'success' => false,
                'message' => 'No messages selected'
            ]);
        }

        try {
            $updated = $user->emailMessages()
                ->whereIn('id', $messageIds)
                ->update(['folder' => 'trash']); // move to trash

            \Log::info("Moved {$updated} messages to trash");

            return response()->json([
                'success' => true,
                'message' => 'Messages moved to trash successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error moving messages to trash: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error moving messages to trash: ' . $e->getMessage()
            ]);
        }
    }


    public function getEmailDetails(Request $request)
    {
        $user = Auth::user();
        $messageId = $request->get('message_id');

        $message = $user->emailMessages()->find($messageId);
        
        if (!$message) {
            return response()->json(['success' => false, 'message' => 'Message not found']);
        }

        // Mark as read if not already read
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $email = $user->emailMessages()->findOrFail($id);
        
        // Mark as read if not already read
        if (!$email->is_read) {
            $email->update(['is_read' => true]);
        }

        // Get email counts for navigation
        $emailCounts = [
            'INBOX' => $user->emailMessages()->inFolder('INBOX')->count(),
            'SENT' => $user->emailMessages()->inFolder('SENT')->count(),
            'DRAFTS' => $user->emailMessages()->inFolder('DRAFTS')->count(),
            'STARRED' => $user->emailMessages()->starred()->count(),
            'TRASH' => $user->emailMessages()->inFolder('TRASH')->count(),
        ];

        return view('admin.mass-email.view-email.show', compact('email', 'emailCounts'));
    }
 
    // From the  View Email -> Mass Email we are going to get email as well  below method call
    public function refreshEmails(Request $request)
    {
        $user = Auth::user();
         set_time_limit(3000000);
        
        if (!$user->hasImapConfigured()) {
            return response()->json([
                'success' => false, 
                'message' => 'IMAP not configured. Please configure your IMAP settings first.'
            ]);
        }

        try {
            $imapService = new ImapService($user);
            $resultfetchEmailsSENT = $imapService->fetchEmailsSENT();
            
            sleep(50); 
            $result = $imapService->fetchEmailsFromLastDay();

            // Get updated email counts
            $emailCounts = [
                'INBOX' => $user->emailMessages()->inFolder('INBOX')->count(),
                'SENT' => $user->emailMessages()->inFolder('SENT')->count(),
                'DRAFTS' => $user->emailMessages()->inFolder('DRAFTS')->count(),
                'STARRED' => $user->emailMessages()->starred()->count(),
                'TRASH' => $user->emailMessages()->inFolder('TRASH')->count(),
            ];

            return response()->json([
                'success' => true,
                'message' => "Successfully fetched {$result['total_fetched']} emails from the last day",
                'total_fetched' => $result['total_fetched'],
                'folders' => $result['folders'],
                'email_counts' => $emailCounts
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Failed to fetch emails: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Test email fetching and storage
     */
    // public function testEmailFetch(Request $request)
    // {
    //     $user = Auth::user();
       
    //     if (!$user->hasImapConfigured()) {
    //         return response()->json([
    //             'success' => false, 
    //             'message' => 'IMAP not configured. Please configure your IMAP settings first.'
    //         ]);
    //     }

    //     try {
    //         $imapService = new ImapService($user);
    //         $result = $imapService->testFetchAndStore();

    //         return response()->json($result);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false, 
    //             'message' => 'Test failed: ' . $e->getMessage()
    //         ]);
    //     }
    // }
} 