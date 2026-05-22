<?php
namespace App\Livewire;

use App\Models\Lead;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class SendLeadEmail extends Component
{
    use WithFileUploads;

    public Lead $lead; // typed Lead model property
    public $email;
    public $subject;
    public $inbox;
    public $attachments = [];
    public $showModal = false;

    protected $rules = [
        'email' => 'required|string',
        'subject' => 'required|string|max:255',
        'inbox' => 'required|string',
        'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
    ];

    protected $messages = [
        'email.required' => 'Please enter at least one email address.',
        'subject.required' => 'Please enter a subject for the email.',
        'inbox.required' => 'Please enter a message.',
        'attachments.*.file' => 'The selected file is not valid.',
        'attachments.*.max' => 'Each file must not exceed 10MB.',
    ];

    public function mount(Lead $lead)
    {
        $this->lead = $lead;
    }

    public function prepareEmail()
    {
        $projects    = Project::parent()->status('active')->get();
        $subprojects = Project::subproject()->status('active')->get();
        $data        = Lead::excludeLeadClients()
            ->where('id', $this->lead->id)
            ->with('wifeDetail', 'families', 'siblings', 'children', 'lineages', 'leadNote', 'states', 'cities', 'countries', 'districts')
            ->first();

        $this->email = $this->lead->email;
        $this->subject = '';

        $this->showModal = true;
    }

    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }

    public function closeModal()
    {
        $this->reset(['email', 'subject', 'inbox', 'attachments', 'showModal']);
    }

    public function send()
    {
        $this->validate();

        // Validate email addresses
        $emails = array_map('trim', explode(',', $this->email));
        $validEmails = [];
        $invalidEmails = [];

        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $validEmails[] = $email;
            } else {
                $invalidEmails[] = $email;
            }
        }

        if (empty($validEmails)) {
            session()->flash('error', 'Please provide at least one valid email address.');
            return;
        }

        if (!empty($invalidEmails)) {
            session()->flash('warning', 'Some email addresses are invalid: ' . implode(', ', $invalidEmails));
        }

        try {
            // Check if mail configuration is properly set up
            if (!config('mail.default')) {
                throw new \Exception('Mail configuration is not properly set up.');
            }

            // Prepare attachment paths
            $attachmentPaths = [];
            
            // Add user uploaded attachments
            foreach ($this->attachments as $attachment) {
                $attachmentPaths[] = $attachment->getRealPath();
            }

            // Send email to all valid email addresses with timeout
            Mail::to($validEmails)->send(new \App\Mail\LeadDetailsMail($attachmentPaths, $this->subject, $this->inbox));

            // Reset form and close modal
            $this->reset(['email', 'subject', 'inbox', 'attachments']);
            $this->showModal = false;
            
            session()->flash('success', 'Email sent successfully to ' . count($validEmails) . ' recipient(s).');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Email sending failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to send email. Please try again later.');
        }
    }

    public function updatedEmail()
    {
        $this->validateOnly('email');
    }

    public function render()
    {
        return view('livewire.send-lead-email');
    }
}
