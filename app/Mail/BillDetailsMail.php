<?php

namespace App\Mail;

use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BillDetailsMail extends Mailable
{
    public $filePath;
    public $bill;
    public $customSubject;
    public $customBody;

    public function __construct($filePath, Bill $bill, $customSubject = null, $customBody = null)
    {
        $this->filePath = $filePath;
        $this->bill = $bill;
        $this->customSubject = $customSubject;
        $this->customBody = $customBody;
    }

    public function build()
    {
        $mail = $this->view('emails.bill.bill-mail');
        
        // Set custom subject if provided
        if ($this->customSubject) {
            $mail->subject($this->customSubject);
        } else {
            $mail->subject('Invoice #' . $this->bill->invoice_number . ' - Kulvriksh');
        }
        
        // Attach PDF
        $mail->attach($this->filePath, [
            'as' => 'Invoice_' . $this->bill->invoice_number . '.pdf',
            'mime' => 'application/pdf',
        ]);
        
        return $mail;
    }
} 