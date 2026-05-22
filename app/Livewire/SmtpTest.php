<?php
namespace App\Livewire;

use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SmtpTest extends Component
{
    public $email;
    public $message = '';
    public $status  = '';

    public function sendTestEmail()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        try {
            // Get settings
            $settings = Setting::pluck('value', 'key')->toArray();

            // Set mail config
            config([
                'mail.mailers.smtp.host'       => $settings['host'] ?? '',
                'mail.mailers.smtp.port'       => $settings['port'] ?? '',
                'mail.mailers.smtp.username'   => $settings['username'] ?? '',
                'mail.mailers.smtp.password'   => $settings['password'] ?? '',
                'mail.mailers.smtp.encryption' => $settings['encryption'] ?? '',
                'mail.from.address'            => $settings['from_address'] ?? 'test@example.com',
                'mail.from.name'               => $settings['from_name'] ?? 'Test',
            ]);

            // Send email
            $status = Mail::raw('This is a test email from your SMTP configuration.', function ($msg) {
                $msg->to($this->email)->subject('SMTP Test Mail');
            });

            $this->message = 'Test email sent successfully.';
            $this->status  = 'success';

        } catch (\Exception $e) {
            $this->message = 'Failed to send test email: ' . $e->getMessage();
            $this->status  = 'error';
        }
    }

    public function render()
    {
        return view('livewire.smtp-test');
    }
}
