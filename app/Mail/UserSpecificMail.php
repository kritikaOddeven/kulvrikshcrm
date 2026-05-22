<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserSpecificMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $data = [])
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'] ?? 'User Specific Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->data['view'] ?? 'emails.user-specific',
            with: $this->data,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Set user-specific SMTP configuration
        if ($this->user->hasSmtpConfigured()) {
            $smtpConfig = $this->user->getSmtpConfig();
            
            config([
                'mail.mailers.smtp.host' => $smtpConfig['host'],
                'mail.mailers.smtp.port' => $smtpConfig['port'],
                'mail.mailers.smtp.username' => $smtpConfig['username'],
                'mail.mailers.smtp.password' => $smtpConfig['password'],
                'mail.mailers.smtp.encryption' => $smtpConfig['encryption'],
                'mail.from.address' => $smtpConfig['from_address'],
                'mail.from.name' => $smtpConfig['from_name'],
            ]);
        }

        return $this->view($this->data['view'] ?? 'emails.user-specific')
                    ->subject($this->data['subject'] ?? 'User Specific Email');
    }
}
