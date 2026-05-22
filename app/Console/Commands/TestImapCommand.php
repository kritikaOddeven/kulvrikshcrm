<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\ImapService;
use Illuminate\Console\Command;

class TestImapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imap:test {--user= : Test IMAP for specific user ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test IMAP service for configured users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user');

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

        $this->info("Testing IMAP for {$users->count()} user(s)...");

        foreach ($users as $user) {
            $this->info("\nTesting IMAP for user: {$user->name} ({$user->email})");
            
            if (!$user->hasImapConfigured()) {
                $this->warn("User {$user->name} does not have IMAP configured.");
                continue;
            }

            try {
                $imapService = new ImapService($user);
                
                // Test basic connection
                $result = $imapService->testConnection();
                
                if ($result['success']) {
                    $this->info("✅ " . $result['message']);
                    $this->info("📁 Available folders: " . implode(', ', $result['folders']));
                    
                    // Test detailed connection and folders
                    $detailedResult = $imapService->testConnectionAndFolders();
                    if ($detailedResult['success']) {
                        $this->info("📊 Detailed folder analysis:");
                        foreach ($detailedResult['folder_tests'] as $folder => $test) {
                            $status = $test['accessible'] ? '✅' : '❌';
                            $this->info("   {$status} {$folder}: {$test['message_count']} messages");
                            if (!$test['accessible'] && isset($test['error'])) {
                                $this->warn("      Error: {$test['error']}");
                            }
                        }
                        
                        // Check for sent folders
                        $sentFolders = array_filter($detailedResult['folders'], function($folder) {
                            return stripos($folder, 'sent') !== false || stripos($folder, 'outbox') !== false;
                        });
                        
                        if (!empty($sentFolders)) {
                            $this->info("📤 Found potential sent folders: " . implode(', ', $sentFolders));
                        } else {
                            $this->warn("⚠️  No sent folders found. Available folders: " . implode(', ', $detailedResult['folders']));
                        }
                    }
                } else {
                    $this->error("❌ " . $result['message']);
                }
                
            } catch (\Exception $e) {
                $this->error("❌ Error testing IMAP for user {$user->name}: " . $e->getMessage());
            }
        }

        $this->info("\nIMAP test completed.");
        return 0;
    }
} 