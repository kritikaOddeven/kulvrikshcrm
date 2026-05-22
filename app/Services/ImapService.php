<?php

namespace App\Services;

use App\Models\EmailMessage;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Webklex\IMAP\Facades\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImapService
{
    protected $user;
    protected $config;
    protected $client;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->config = $user->getImapConfig();
    }

    /**
     * Connect to IMAP server
     */
    public function connect()
    {
        if (!$this->config) {
            throw new \Exception('IMAP configuration not found for user');
        }

        try {
            // Create a temporary account configuration
            $accountConfig = [
                'host' => $this->config['host'],
                'port' => $this->config['port'],
                'encryption' => $this->config['encryption'],
                'validate_cert' => false,
                'username' => $this->config['username'],
                'password' => $this->config['password'],
                'protocol' => 'imap'
            ];

            // Create client with temporary config
            $this->client = Client::make($accountConfig);
            $this->client->connect();

            return $this->client;
        } catch (\Exception $e) {
            throw new \Exception('Failed to connect to IMAP server: ' . $e->getMessage());
        }
    }

    /**
     * Disconnect from IMAP server
     */
    public function disconnect()
    {
        if ($this->client) {
            $this->client->disconnect();
        }
    }

    /**
     * Get list of folders
     */
    public function getFolders()
    {
        $this->connect();
        
        try {
            $folders = $this->client->getFolders();
            $folderNames = [];
            
            foreach ($folders as $folder) {
                $folderNames[] = $folder->name;
            }
            
            return $folderNames;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get folders: ' . $e->getMessage());
        } finally {
            $this->disconnect();
        }
    }

    /**
     * Fetch emails from a specific folder
     */
    public function fetchEmails($folder = 'INBOX', $limit = 50, $page = 1)   
    {
        $this->connect();

        try {
            $folderObj = $this->client->getFolder($folder);
            if (!$folderObj) {
                throw new \Exception('Folder not found: ' . $folder);
            }

            // Use the package's paginator
            $messages = $folderObj->messages()->all()->paginate($limit, $page);

            $emailMessages = [];
            foreach ($messages as $message) {
                try {
                    $emailMessage = $this->processMessage($message, $folder);
                    if ($emailMessage) {
                        $emailMessages[] = $emailMessage;
                    }
                } catch (\Exception $e) {
                    Log::error("Error processing message: " . $e->getMessage());
                    continue;
                }
            }

            return $emailMessages;
        } catch (\Exception $e) {
            throw new \Exception('Failed to fetch emails: ' . $e->getMessage());
        } finally {
            $this->disconnect();
        }
    }

    /**
     * Process a single message
     */
    protected function processMessage($message, $folder)
    {
        try {
            $messageId = $message->getUid() ?? uniqid();
            
            // Check if message already exists
            $existingMessage = EmailMessage::where('user_id', $this->user->id)
                ->where('message_id', $messageId)
                ->where('folder', strtoupper($folder))
                ->first();
                
            if ($existingMessage) {
                Log::info("Email already exists in database: {$messageId} in {$folder}");
                return $existingMessage;
            }

            // Get message details
            $from = $message->getFrom();
            $to = $message->getTo();
            $cc = $message->getCc();
            $bcc = $message->getBcc();
            
            // Parse email addresses
            $fromEmail = $from ? $from->first()->mail : '';
            $fromName = $from ? $from->first()->personal : '';
            $toEmail = $to ? $to->first()->mail : '';
            $toName = $to ? $to->first()->personal : '';

            // Parse CC and BCC
            $ccEmails = '';
            if ($cc) {
                if (is_array($cc)) {
                    $ccEmails = implode(', ', array_map(function($addr) { 
                        return is_object($addr) ? $addr->mail : $addr; 
                    }, $cc));
                } elseif (is_object($cc) && method_exists($cc, 'map')) {
                    $ccList = $cc->map(function($addr) { return $addr->mail; });
                    $ccEmails = implode(', ', (array)$ccList);
                } else {
                    $ccArray = is_object($cc) ? (array) $cc : $cc;
                    if (is_array($ccArray)) {
                        $ccEmails = implode(', ', array_map(function($addr) { 
                            return is_object($addr) ? $addr->mail : $addr; 
                        }, $ccArray));
                    }
                }
            }
            
            $bccEmails = '';
            if ($bcc) {
                if (is_array($bcc)) {
                    $bccEmails = implode(', ', array_map(function($addr) { 
                        return is_object($addr) ? $addr->mail : $addr; 
                    }, $bcc));
                } elseif (is_object($bcc) && method_exists($bcc, 'map')) {
                    $bccList = $bcc->map(function($addr) { return $addr->mail; });
                    $bccEmails = implode(', ', (array)$bccList);
                } else {
                    $bccArray = is_object($bcc) ? (array) $bcc : $bcc;
                    if (is_array($bccArray)) {
                        $bccEmails = implode(', ', array_map(function($addr) { 
                            return is_object($addr) ? $addr->mail : $addr; 
                        }, $bccArray));
                    }
                }
            }

            // Check for attachments
            $attachments = $message->getAttachments();
            $hasAttachments = $attachments->count() > 0;
            $attachmentInfo = [];
            
            foreach ($attachments as $attachment) {
                $attachmentInfo[] = [
                    'name' => $attachment->getName(),
                    'type' => $attachment->getMimeType(),
                    'size' => $attachment->getSize(),
                ];
            }

            // Prepare email data
            $emailData = [
                'user_id' => $this->user->id,
                'message_id' => $messageId,
                'folder' => strtoupper($folder),
                'from_email' => $fromEmail,
                'from_name' => $fromName,
                'to_email' => $toEmail,
                'to_name' => $toName,
                'cc' => $ccEmails,
                'bcc' => $bccEmails,
                'subject' => $message->getSubject() ?? 'No Subject',
                'body' => $message->getTextBody() ?: $message->getHTMLBody() ?: '',
                'body_plain' => $message->getTextBody(),
                'body_html' => $message->getHTMLBody(),
                'date_received' => $message->getDate() ?? now(),
                'is_read' => false,
                'is_starred' => false,
                'has_attachments' => $hasAttachments,
                'attachments' => $attachmentInfo,
            ];

            Log::info("Creating email in database: {$messageId} - Subject: {$emailData['subject']} - From: {$fromEmail}");

            // Create email message
            $emailMessage = EmailMessage::create($emailData);

            if ($emailMessage) {
                Log::info("Successfully created email in database with ID: {$emailMessage->id}");
                return $emailMessage;
            } else {
                Log::error("Failed to create email in database: {$messageId}");
                return null;
            }

        } catch (\Exception $e) {
            Log::error("Error processing message in {$folder}: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return null;
        }
    }

    /**
     * Mark message as read
     */
    public function markAsRead($messageId)
    {
        $message = EmailMessage::where('user_id', $this->user->id)
            ->where('id', $messageId)
            ->first();
            
        if ($message) {
            $message->update(['is_read' => true]);
        }
    }

    /**
     * Toggle star status
     */
    public function toggleStar($messageId)
    {
        $message = EmailMessage::where('user_id', $this->user->id)
            ->where('id', $messageId)
            ->first();
            
        if ($message) {
            $message->update(['is_starred' => !$message->is_starred]);
        }
    }

    /**
     * Delete message
     */
    public function deleteMessage($messageId)
    {
        $message = EmailMessage::where('user_id', $this->user->id)
            ->where('id', $messageId)
            ->first();
            
        if ($message) {
            $message->delete();
        }
    }

    /**
     * Test connection
     */
    public function testConnection()
    {
        try {
            $this->connect();
            $folders = $this->getFolders();
            $this->disconnect();
            
            return [
                'success' => true,
                'folders' => $folders,
                'message' => 'Connection successful! Found ' . count($folders) . ' folders.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ];
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

    /**
     * Fetch emails from the last 1 day for all folders (limited to 50 per folder)
     */
    public function fetchEmailsFromLastDay()
    {
        set_time_limit(3000000);
        $totalFetched = 0;
        $results = [];
        $limitPerFolder = 50; // Limit to 50 emails per folder 500-10
        
        // First, get all available folders
        try {
            $this->connect();
            $availableFolders = $this->getFolders();
            $this->disconnect();
            
            Log::info("Available folders for user {$this->user->id}: " . implode(', ', $availableFolders));
        } catch (\Exception $e) {
            Log::error("Failed to get folders for user {$this->user->id}: " . $e->getMessage());
            return [
                'total_fetched' => 0,
                'folders' => ['error' => ['success' => false, 'message' => 'Failed to get folders: ' . $e->getMessage(), 'count' => 0]]
            ];
        }

        // Define folder patterns to look for
        $folderPatterns = [
            'INBOX' => ['INBOX', 'INBOX/INBOX'],
            'SENT' => ['SENT', 'Sent', 'Sent Items', 'INBOX/Sent', 'INBOX/Sent Items', 'Sent Mail', 'INBOX/Sent Mail'],
            'DRAFTS' => ['DRAFTS', 'Drafts', 'INBOX/Drafts', 'Draft', 'INBOX/Draft'],
            'TRASH' => ['TRASH', 'Trash', 'INBOX/Trash', 'Deleted Items', 'INBOX/Deleted Items', 'Bin', 'INBOX/Bin']
        ];

        // Find actual available folders for each type
        $foldersToProcess = [];
        foreach ($folderPatterns as $folderType => $possibleNames) {
            foreach ($possibleNames as $folderName) {
                if (in_array($folderName, $availableFolders)) {
                    $foldersToProcess[$folderType] = $folderName;
                    Log::info("Found {$folderType} folder: {$folderName} for user {$this->user->id}");
                    break;
                }
            }
        }

        // If no sent folder found, try to find any folder that might contain sent emails
        if (!isset($foldersToProcess['SENT'])) {
            foreach ($availableFolders as $folder) {
                if (stripos($folder, 'sent') !== false || stripos($folder, 'outbox') !== false) {
                    $foldersToProcess['SENT'] = $folder;
                    Log::info("Found potential sent folder: {$folder} for user {$this->user->id}");
                    break;
                }
            }
        }

        // Process each found folder
        foreach ($foldersToProcess as $folderType => $folderName) {
            try {
                $this->connect();
                $folderObj = $this->client->getFolder($folderName);
                
                if (!$folderObj) {
                    $results[$folderType] = ['success' => false, 'message' => 'Folder not found', 'count' => 0];
                    Log::warning("Folder {$folderName} not found for user {$this->user->id}");
                    continue;
                }

                // Get messages from the last 1 day
                $oneDayAgo = now()->subDay();
                Log::info("Fetching emails from {$folderName} ({$folderType}) for user {$this->user->id} since {$oneDayAgo}");
                
                try {
                    // Try to use the since() method if available, with limit
                    if (method_exists($folderObj->messages(), 'since')) {
                        $messages = $folderObj->messages()->since($oneDayAgo)->limit($limitPerFolder)->get();
                        Log::info("Using since() method for {$folderName}, found " . $messages->count() . " messages");
                    } else {
                        // Fallback: get all messages and filter by date, then limit
                        $messages = $folderObj->messages()->all()->limit($limitPerFolder)->get();
                        Log::info("Using fallback method for {$folderName}, found " . $messages->count() . " messages");
                    }
                } catch (\Exception $e) {
                    // If since() method fails, try to get limited messages and filter by date
                    Log::warning("Since method failed for {$folderName}, trying alternative approach: " . $e->getMessage());
                    $messages = $folderObj->messages()->all()->limit($limitPerFolder)->get();
                    Log::info("Using alternative method for {$folderName}, found " . $messages->count() . " messages");
                }
                
                $fetchedCount = 0;
                $processedCount = 0;
                
                foreach ($messages as $message) {
                    try {
                        $processedCount++;
                        
                        // Check if message is from the last 1 day
                        $messageDate = $message->getDate();
                        if ($messageDate && $messageDate < $oneDayAgo) {
                            Log::info("Skipping message in {$folderName} - too old: {$messageDate}");
                            continue; // Skip messages older than 1 day
                        }
                        
                        Log::info("Processing message {$processedCount} in {$folderName} - Date: {$messageDate}");
                        
                        $emailMessage = $this->processMessage($message, $folderType);
                        if ($emailMessage) {
                            $fetchedCount++;
                            Log::info("Successfully stored email {$fetchedCount} in {$folderName} - Subject: " . ($emailMessage->subject ?? 'No Subject'));
                        } else {
                            Log::info("Email already exists or failed to process in {$folderName}");
                        }
                        
                        // Stop if we've reached the limit
                        if ($fetchedCount >= $limitPerFolder) {
                            Log::info("Reached limit of {$limitPerFolder} emails for {$folderName}");
                            break;
                        }
                    } catch (\Exception $e) {
                        Log::error("Error processing message {$processedCount} in {$folderName}: " . $e->getMessage());
                        continue;
                    }
                }

                $totalFetched += $fetchedCount;
                $results[$folderType] = [
                    'success' => true, 
                    'message' => "Fetched {$fetchedCount} emails from {$folderName} (processed {$processedCount} total)", 
                    'count' => $fetchedCount,
                    'processed' => $processedCount,
                    'folder_name' => $folderName
                ];
                Log::info("Successfully fetched {$fetchedCount} emails from {$folderName} for user {$this->user->id} (processed {$processedCount} total)");
                
            } catch (\Exception $e) {
                $results[$folderType] = ['success' => false, 'message' => $e->getMessage(), 'count' => 0];
                Log::error("Error fetching emails from {$folderName} for user {$this->user->id}: " . $e->getMessage());
            } finally {
                $this->disconnect();
            }
        }

        // Handle STARRED folder (it's a filter, not a physical folder)
        try {
            $starredCount = EmailMessage::where('user_id', $this->user->id)
                ->where('is_starred', true)
                ->where('date_received', '>=', now()->subDay())
                ->limit($limitPerFolder)
                ->count();
            
            $results['STARRED'] = [
                'success' => true, 
                'message' => "Found {$starredCount} starred emails from last day", 
                'count' => $starredCount
            ];
            Log::info("Found {$starredCount} starred emails from last day for user {$this->user->id}");
        } catch (\Exception $e) {
            $results['STARRED'] = ['success' => false, 'message' => $e->getMessage(), 'count' => 0];
            Log::error("Error processing starred emails for user {$this->user->id}: " . $e->getMessage());
        }

        Log::info("Email fetch completed for user {$this->user->id}: {$totalFetched} total emails fetched");

        return [
            'total_fetched' => $totalFetched,
            'folders' => $results,
            'available_folders' => $availableFolders
        ];
    }

    /**
     * Fetch emails from the last 7 days for all folders (keeping for backward compatibility)
     */
    public function fetchEmailsFromLast7Days()
    {
        return $this->fetchEmailsFromLastDay();
    }

    public function fetchEmailsSENT()
    {
        set_time_limit(300); // 5 minutes max execution time
        $user = Auth::user();
        
        try {
            \Log::info('Starting fetchEmailsSENT function for user: ' . $user->id);
            \Log::debug('User details: ', ['user' => $user->toArray()]);
            $this->connect();
            
            // Get the IMAP account creation date
            $startDate = $user->imapSetting->created_at;
            
            // Get all available folders
            $availableFolders = $this->getFolders();
            
            // Define sent folder patterns for different email providers
            $sentFolderPatterns = [
                'SENT', 'Sent', 'Sent Items', 'INBOX/Sent', 'INBOX/Sent Items', 
                'Sent Mail', 'INBOX/Sent Mail', '[Gmail]/Sent Mail', 'Outbox'
            ];
            
            // Find the actual sent folder
            $sentFolderName = null;
            foreach ($sentFolderPatterns as $pattern) {
                if (in_array($pattern, $availableFolders)) {
                    $sentFolderName = $pattern;
                    Log::info("Found sent folder: {$sentFolderName} for user {$user->id}");
                    break;
                }
            }
            
            // If no exact match found, try to find any folder that might contain sent emails
            if (!$sentFolderName) {
                foreach ($availableFolders as $folder) {
                    if (stripos($folder, 'sent') !== false || stripos($folder, 'outbox') !== false) {
                        $sentFolderName = $folder;
                        Log::info("Found potential sent folder: {$folder} for user {$user->id}");
                        break;
                    }
                }
            }
            
            if (!$sentFolderName) {
                throw new \Exception('No sent folder found. Available folders: ' . implode(', ', $availableFolders));
            }
            
            // Get the sent folder
            $sentFolder = $this->client->getFolder($sentFolderName);
            
            if (!$sentFolder) {
                throw new \Exception("Sent folder '{$sentFolderName}' not accessible");
            }
            
            // Get messages from activation date till now
            $messages = $sentFolder->query()
                ->since($startDate)
                ->limit(10) // Adjust limit as needed
                ->get();
            
            $totalFetched = 0;
            $processedEmails = [];
            
            foreach ($messages as $message) {
                try {
                    // Process and store each sent email (same as your inbox processing)
                    $emailMessage = $this->processMessage($message, 'SENT');
                    
                    if ($emailMessage) {
                        $totalFetched++;
                        $processedEmails[] = [
                            'id' => $emailMessage->id,
                            'subject' => $emailMessage->subject,
                            'date' => $emailMessage->date_received
                        ];
                    }
                } catch (\Exception $e) {
                    Log::error("Error processing sent email: " . $e->getMessage());
                    continue;
                }
            }
            
            // Get updated counts for response
            $emailCounts = [
                'SENT' => $user->emailMessages()->inFolder('SENT')->count()
            ];
            
            Log::info("Successfully fetched {$totalFetched} sent emails from {$sentFolderName} for user {$user->id}");
            
            return [
                'success' => true,
                'message' => "Fetched {$totalFetched} sent emails since activation from {$sentFolderName}",
                'total_fetched' => $totalFetched,
                'processed_emails' => $processedEmails,
                'email_counts' => $emailCounts,
                'sent_folder' => $sentFolderName,
                'date_range' => [
                    'from' => $startDate->format('Y-m-d H:i:s'),
                    'to' => now()->format('Y-m-d H:i:s')
                ]
            ];
            
        } catch (\Exception $e) {
            Log::error("Sent emails fetch failed: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch sent emails: ' . $e->getMessage()
            ];
        } finally {
            $this->disconnect();
        }
    }

} 