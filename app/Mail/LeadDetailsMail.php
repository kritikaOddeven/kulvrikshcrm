<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadDetailsMail extends Mailable
{
    public $attachmentPaths;
    public $customSubject;
    public $customMessage;

    public function __construct($attachmentPaths = [], $customSubject = null, $customMessage = null)
    {
        $this->attachmentPaths = is_array($attachmentPaths) ? $attachmentPaths : [$attachmentPaths];
        $this->customSubject = $customSubject;
        $this->customMessage = $customMessage;
    }

    public function build()
    {
        $mail = $this->view('emails.lead.preview-mail');
        
        // Set custom subject if provided
        if ($this->customSubject) {
            $mail->subject($this->customSubject);
        } else {
            $mail->subject('Lead Details');
        }
        
        // Attach all files
        foreach ($this->attachmentPaths as $filePath) {
            if (file_exists($filePath)) {
                $mail->attach($filePath);
            }
        }
        
        return $mail;
    }
}