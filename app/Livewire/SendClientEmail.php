<?php
namespace App\Livewire;

use App\Models\Client;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SendClientEmail extends Component
{
    public Client $client;
    public $email;
    public $pdfFilename;
    public $showModal = false;

    public function mount(Client $client)
    {
        $this->client = $client;
    }

    public function prepareEmail()
    {
        $projects = Project::parent()->status('active')->get();
        $subprojects = Project::subproject()->status('active')->get();
        $data = $this->client->load('lead.wifeDetail', 'lead.families', 'lead.siblings', 'lead.children', 'lead.lineages', 'lead.leadNote', 'lead.states', 'lead.cities', 'lead.countries', 'lead.districts');

        $this->email = $this->client->lead->email;

        // Ensure the public/tmp directory exists
        $publicTmpPath = public_path('tmp');
        if (!file_exists($publicTmpPath)) {
            mkdir($publicTmpPath, 0755, true);
        }

        // Generate PDF
        $pdf = Pdf::loadView('admin.preview.client-preview', ['data' => $data]);

        $this->pdfFilename = 'client_preview_' . $this->client->id . '_' . time() . '.pdf';
        $fullPath = $publicTmpPath . '/' . $this->pdfFilename;

        // Save PDF to public/tmp
        $pdf->save($fullPath);

        if (!file_exists($fullPath)) {
            session()->flash('error', 'Failed to save PDF file.');
            return;
        }

        $this->showModal = true;
    }

    public function send()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $file = public_path("tmp/{$this->pdfFilename}");

        if (!file_exists($file)) {
            session()->flash('error', 'PDF file not found.');
            return;
        }

        Mail::to($this->email)->send(new \App\Mail\ClientDetailsMail($file));

        // Delete the temporary file
        if (file_exists($file)) {
            unlink($file);
        }

        $this->reset(['email', 'pdfFilename', 'showModal']);
        session()->flash('success', 'Email sent successfully.');
    }

    public function render()
    {
        return view('livewire.send-client-email');
    }
} 