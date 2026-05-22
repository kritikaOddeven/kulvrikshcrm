<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\ImapService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:fetch {--user= : Fetch emails for specific user ID} {--folder=INBOX : Folder to fetch from}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch emails from IMAP servers for configured users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user');
        $folder = $this->option('folder');

        if ($userId) {
            $users = User::where('id', $userId)->get();
        } else {
            $users = User::whereHas('imapSetting', function($query) {
                $query->where('is_active', true);
            })->get();
        }

        if ($users->isEmpty()) {
            $this->error('No users with active IMAP configuration found.');
            return 1;
        }

        $this->info("Starting email fetch for {$users->count()} user(s)...");

        foreach ($users as $user) {
            try {
                $this->info("Fetching emails for user: {$user->name} ({$user->email})");
                
                $imapService = new ImapService($user);
                $messages = $imapService->fetchEmails($folder, 50, 0);
                
                $this->info("Fetched " . count($messages) . " emails from {$folder} folder");
                
                Log::info("Email fetch completed for user {$user->id}: " . count($messages) . " emails fetched");
                
            } catch (\Exception $e) {
                $this->error("Error fetching emails for user {$user->name}: " . $e->getMessage());
                Log::error("Email fetch failed for user {$user->id}: " . $e->getMessage());
            }
        }

        $this->info('Email fetch completed.');
        return 0;
    }
} 