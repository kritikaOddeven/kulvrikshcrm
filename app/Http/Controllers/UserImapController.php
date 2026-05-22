<?php

namespace App\Http\Controllers;

use App\Models\UserImapSetting;
use App\Models\EmailMessage;
use App\Services\ImapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserImapController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $imapSetting = $user->imapSetting;
        $providers = UserImapSetting::getProviderConfigs();
        
        return view('admin.settings.user-imap-configuration', compact('imapSetting', 'providers'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $existingImap = $user->imapSetting;
        
        // Determine password validation rules
        $passwordRules = $existingImap ? 'nullable|string' : 'required|string';
        $validator = Validator::make($request->all(), [
            'provider' => 'required|string',
            'host' => 'required|string',
            'port' => 'required|integer|min:1|max:65535',
            'username' => 'required|email',
            'password' => $passwordRules,
            'encryption' => 'required|in:ssl,tls,notls',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $password = $request->password ?? $user->imapSetting->password;
        if($existingImap && $request->username != $existingImap->username){
            $user->emailMessages()->delete();
        }
        $imapSetting = $user->imapSetting()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'provider' => $request->provider,
                'host' => $request->host,
                'port' => $request->port,
                'username' => $request->username,
                'password' => $password,
                'encryption' => $request->encryption,
                'is_active' => true,
            ]
        );

        log_activity('User IMAP Settings', 'update', "IMAP settings updated for user {$user->name}");

        return redirect()->back()->with('success', 'IMAP settings saved successfully!');
    }

    public function test(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasImapConfigured()) {
            return response()->json(['success' => false, 'message' => 'Please configure IMAP settings first']);
        }

        try {
            $imapService = new ImapService($user);
            $result = $imapService->testConnection();

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to connect: ' . $e->getMessage()]);
        }
    }

    public function toggle(Request $request)
    {
        $user = Auth::user();
        
        if ($user->imapSetting) {
            $user->imapSetting->update(['is_active' => !$user->imapSetting->is_active]);
            $status = $user->imapSetting->is_active ? 'enabled' : 'disabled';
            
            return response()->json(['success' => true, 'message' => "IMAP settings {$status} successfully!"]);
        }
        
        return response()->json(['success' => false, 'message' => 'No IMAP settings found']);
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        
        if ($user->imapSetting) {
            $user->imapSetting->delete();
            return response()->json(['success' => true, 'message' => 'IMAP settings deleted successfully!']);
        }
        
        return response()->json(['success' => false, 'message' => 'No IMAP settings found']);
    }

    public function fetchEmails(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->hasImapConfigured()) {
            return response()->json(['success' => false, 'message' => 'IMAP not configured']);
        }

        try {
            $folder = $request->get('folder', 'INBOX');
            $limit = $request->get('limit', 50);
            $offset = $request->get('offset', 0);

            $imapService = new ImapService($user);
            $messages = $imapService->fetchEmails($folder, $limit, $offset);

            return response()->json([
                'success' => true,
                'message' => 'Emails fetched successfully!',
                'count' => count($messages)
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to fetch emails: ' . $e->getMessage()]);
        }
    }

    public function getEmails(Request $request)
    {
        $user = Auth::user();
        
        $folder = $request->get('folder', 'INBOX');
        $search = $request->get('search', '');
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 50);

        $query = $user->emailMessages()->inFolder($folder);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('from_email', 'like', "%{$search}%")
                  ->orWhere('from_name', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        $messages = $query->orderBy('date_received', 'desc')
                         ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'messages' => $messages->items(),
            'pagination' => [
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'per_page' => $messages->perPage(),
                'total' => $messages->total(),
            ]
        ]);
    }

    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        $messageId = $request->get('message_id');

        try {
            $imapService = new ImapService($user);
            $imapService->markAsRead($messageId);

            return response()->json(['success' => true, 'message' => 'Message marked as read']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to mark as read: ' . $e->getMessage()]);
        }
    }

    public function toggleStar(Request $request)
    {
        $user = Auth::user();
        $messageId = $request->get('message_id');

        try {
            $imapService = new ImapService($user);
            $imapService->toggleStar($messageId);

            return response()->json(['success' => true, 'message' => 'Star status toggled']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to toggle star: ' . $e->getMessage()]);
        }
    }

    public function deleteMessage(Request $request)
    {
        $user = Auth::user();
        $messageId = $request->get('message_id');

        try {
            $imapService = new ImapService($user);
            $imapService->deleteMessage($messageId);

            return response()->json(['success' => true, 'message' => 'Message deleted']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete message: ' . $e->getMessage()]);
        }
    }

    public function getFolders(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->hasImapConfigured()) {
            return response()->json(['success' => false, 'message' => 'IMAP not configured']);
        }

        try {
            $imapService = new ImapService($user);
            $folders = $imapService->getFolders();

            return response()->json([
                'success' => true,
                'folders' => $folders
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to get folders: ' . $e->getMessage()]);
        }
    }

    /**
     * Test IMAP connection and list all available folders with detailed information
     */
    public function testConnectionAndFolders(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->hasImapConfigured()) {
            return response()->json(['success' => false, 'message' => 'IMAP not configured']);
        }

        try {
            $imapService = new ImapService($user);
            $result = $imapService->testConnectionAndFolders();

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to test connection: ' . $e->getMessage()]);
        }
    }
} 