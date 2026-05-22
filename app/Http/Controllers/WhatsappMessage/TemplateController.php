<?php

namespace App\Http\Controllers\WhatsappMessage;

use App\Http\Controllers\Controller;
use App\Models\WhatsappTemplate;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = WhatsappTemplate::all();
        return view('admin.whatsapp.template.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.whatsapp.template.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_name' => 'required|string|max:255',
            'template_api_name' => 'nullable|string|max:255',
            'template_type' => 'nullable|string|max:100',
            'message_text' => 'required|string',
            'template_footer' => 'nullable|string',
        ]);

        $template = WhatsappTemplate::create([
            'template_name' => $request->template_name,
            'template_api_name' => $request->template_api_name,
            'template_type' => $request->template_type,
            'message_text' => $request->message_text,
            'template_footer' => $request->template_footer,
        ]);

        log_activity('WhatsappTemplate', 'create', "New WhatsApp template created: {$template->template_name}");

        return redirect('admin/whatsapp/template')->with('success', 'WhatsApp Template created successfully.');
    }

    public function show($id)
    {
        $template = WhatsappTemplate::findOrFail($id);
        return view('admin.whatsapp.template.view', compact('template'));
    }

    public function edit($id)
    {
        $template = WhatsappTemplate::findOrFail($id);
        return view('admin.whatsapp.template.edit', compact('template'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:whatsapp_templates,id',
            'template_name' => 'required|string|max:255',
            'template_api_name' => 'nullable|string|max:255',
            'template_type' => 'nullable|string|max:100',
            'message_text' => 'required|string',
            'template_footer' => 'nullable|string',
        ]);

        $template = WhatsappTemplate::findOrFail($request->id);
        $template->update([
            'template_name' => $request->template_name,
            'template_api_name' => $request->template_api_name,
            'template_type' => $request->template_type,
            'message_text' => $request->message_text,
            'template_footer' => $request->template_footer,
        ]);

        log_activity('WhatsappTemplate', 'update', "WhatsApp template updated: {$template->template_name}");

        return redirect('admin/whatsapp/template')->with('success', 'WhatsApp Template updated successfully.');
    }

    public function destory($id)
    {
        $template = WhatsappTemplate::findOrFail($id);
        $templateName = $template->template_name;
        $template->delete();

        log_activity('WhatsappTemplate', 'delete', "WhatsApp template deleted: {$templateName}");

        return redirect('admin/whatsapp/template')->with('success', 'WhatsApp Template deleted successfully.');
    }
}