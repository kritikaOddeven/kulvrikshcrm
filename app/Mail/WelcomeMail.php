<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $agent;
    public $plainPassword;

    public function __construct(User $agent, $plainPassword)
    {
        $this->agent = $agent;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        return $this->subject('Welcome to Kulvriksh!')->view('emails.agent.welcome-email')->with(['agent' => $this->agent, 'plainPassword' => $this->plainPassword]);
    }

   
    
}
