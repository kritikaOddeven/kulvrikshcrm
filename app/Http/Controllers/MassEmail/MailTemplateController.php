<?php
namespace App\Http\Controllers\MassEmail;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class MailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::get();
        return view('admin.mass-email.template.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.mass-email.template.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_name' => 'required|string|max:255',
            'subject'       => 'required|string|max:255',
            'description'   => 'required|string',
        ]);
        // dd($request->all());

        $template = EmailTemplate::create([
            'template_name' => $request->template_name,
            'subject'       => $request->subject,
            'description'   => $request->description,
        ]);

        log_activity('EmailTemplate', 'create', "New email template created: {$template->template_name}");

        return redirect('admin/mass-email/template')->with('success', 'Email Template created successfully.');
    }

    public function show($id)
    {
         $template = EmailTemplate::find($id);
        return view('admin.mass-email.template.view', compact('template'));
    }

    public function edit($id)
    {
        $template = EmailTemplate::find($id);
        return view('admin.mass-email.template.edit', compact('template'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'template_name' => 'required|string|max:255',
            'subject'       => 'required|string|max:255',
            'description'   => 'required|string',
        ]);
        // dd($request->all());
        $template = EmailTemplate::findOrFail($request->id);
        $template->update([
            'template_name' => $request->template_name,
            'subject'       => $request->subject,
            'description'   => $request->description,
        ]);

        log_activity('EmailTemplate', 'update', "Email template updated: {$template->template_name}");

        return redirect('admin/mass-email/template')->with('success', 'Email Template updated successfully.');
    }

    public function destory($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $templateName = $template->template_name;
        $template->delete();

        log_activity('EmailTemplate', 'delete', "Email template deleted: {$templateName}");

        return redirect('admin/mass-email/template')->with('success', 'Email Template deleted successfully.');
    }
}