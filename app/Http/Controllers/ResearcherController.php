<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\ResearcherConversation;
use App\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ResearcherController extends Controller
{
    public function index()
    {
        $researchers = Client::whereNotNull(['researcher_ids', 'agent_id', 'lead_id'])
            ->where('is_researchar_report', false)
            ->with(['lead', 'lead.states', 'lead.cities', 'lead.countries', 'lead.districts']);
        if (roleType() == 'researcher') {
            $researchers = $researchers->whereRaw('JSON_CONTAINS(researcher_ids, ?)', [json_encode((string) auth()->id())]);
        }
        $researchers = $researchers->get();
        $role        = Role::whereRaw('LOWER(role_type) = ?', ['researcher'])->first();

        $researchersName = collect();

        if ($role) {
            $researchersName = User::whereHas('roles', function ($query) use ($role) {
                $query->where('role_type', $role->role_type);
            })->get();
        }
        return view('admin.researchers.index', compact('researchers', 'researchersName'));
    }

    public function show(Request $request, $id)
    {
        $projects    = Project::parent()->status('active')->get();
        $subprojects = Project::subproject()->status('active')->get();
        $data        = Client::where('id', $id)->with(['lead', 'lead.states', 'lead.cities', 'lead.countries', 'lead.districts', 'conversation', 'researcherView'])->first();
        // dd($data->conersation);
        return view('admin.researchers.view', compact('data', 'projects', 'subprojects'));
    }

    public function store(Request $request)
    {
        foreach ($request->input('content', []) as $index => $content) {

            $attachmentPath = null;

            // Case 1: New uploaded file
            if ($request->hasFile("attachment.$index")) {
                $file      = $request->file("attachment.$index");
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/admin/researcher/attachment'), $imageName);
                $attachmentPath = 'assets/admin/researcher/attachment/' . $imageName;

                // Case 2: Existing file URL (from frontend input)
            } elseif ($request->has("attachment.$index") && is_string($request->input("attachment.$index"))) {
                $attachmentPath = $request->input("attachment.$index");
            }

            $addedBy = $request->input("added_by.$index") ?? auth()->id();

            ResearcherConversation::create([
                'client_id'  => $request->clientId,
                'added_by'   => $addedBy,
                'type'       => $request->type,
                'content'    => $content,
                'attachment' => $attachmentPath,
            ]);
        }
        log_activity('Researcher', 'researcher_chat', "Researcher conversation");

        return redirect()->back()->with('success', 'Notes added successfully.');
    }

    public function storeView(Request $request)
    {
        foreach ($request->input('content', []) as $index => $content) {

            $attachmentPath = null;

            // Case 1: New uploaded file
            if ($request->hasFile("attachment.$index")) {
                $file      = $request->file("attachment.$index");
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/admin/researcher/attachment'), $imageName);
                $attachmentPath = 'assets/admin/researcher/attachment/' . $imageName;

                // Case 2: Existing file URL (from frontend input)
            } elseif ($request->has("attachment.$index") && is_string($request->input("attachment.$index"))) {
                $attachmentPath = $request->input("attachment.$index");
            }

            ResearcherConversation::create([
                'client_id'  => $request->clientId,
                'added_by'   => auth()->id(),
                'type'       => $request->type,
                'content'    => $content,
                'attachment' => $attachmentPath,
            ]);
        }
        log_activity('Researcher', 'researcher_view', "Researcher view created");

        return redirect()->back()->with('success', 'Researcher view added successfully.');
    }

    public function createReport(Request $request, $id)
    {
        // dd('test', $id);
        Client::where('id', $id)->update([
            "is_researchar_report" => true,
            "research_status"      => "completed",
        ]);
        log_activity('Researcher', 'researcher_report', "Researcher generate report");

        return redirect('admin/research-reports')->with('success', 'Researhcer Report created successfully');
    }

    public function destroy($id)
    {
        $report = Client::findOrFail($id);
        $report->delete();
        log_activity('Researcher', 'delete', "Researcher delete");

        return redirect()->back()->with('success', 'Research deleted successfully');
    }

    /**
     * Store a new note via AJAX
     */
    public function storeNote(Request $request, $client_id)
    {
        $request->validate([
            'original_content'   => 'required|string',
            'translated_content' => 'required|string',
            'attachments.*'      => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp3,wav,m4a|max:10240',
        ]);

        try {
            // Create the note
            $note = ResearcherConversation::create([
                'client_id'        => $client_id,
                'added_by'         => auth()->id(),
                'type'             => 'conversation',
                'original_content' => $request->original_content,
                'content'          => $request->translated_content,
            ]);

            // Handle file uploads
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $fileType     = $file->getMimeType();
                    $fileCategory = explode('/', $fileType)[0]; // 'image', 'audio', or 'application'

                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/admin/researcher/attachment'), $fileName);

                    $attachmentPath = 'assets/admin/researcher/attachment/' . $fileName;

                    $attachments[] = [
                        'attachment' => asset($attachmentPath),
                        'type'       => $fileCategory,
                        'icon'       => $fileCategory === 'image' ? 'image' : ($fileCategory === 'audio' ? 'file-music' : ($fileCategory === 'application' ? 'file-pdf' : 'file')),
                    ];
                }

                // Store the first attachment path in the note (for backward compatibility)
                if (! empty($attachments)) {
                    $note->update([
                        'attachment' => 'assets/admin/researcher/attachment/' . $fileName,
                    ]);
                }
            }

            // Load the user relationship for the response
            $note->load('user');

            log_activity('Researcher Note', 'create', "New note added to client ID: {$client_id}");

            return response()->json([
                'success' => true,
                'message' => 'Note added successfully',
                'note'    => [
                    'id'               => $note->id,
                    'original_content' => $note->original_content,
                    'content'          => $note->content,
                    'user_name'        => $note->user->name,
                    'user_image'       => asset(get_profile_image($note->user->profile_image, $note->user->name)),
                    'created_at'       => $note->created_at->format('D d F, g:i'),
                    'attachments'      => $attachments,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding note: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing note via AJAX
     */
    public function updateNote(Request $request, $note_id)
    {
        $request->validate([
            'original_content'   => 'required|string',
            'translated_content' => 'required|string',
        ]);

        try {
            $note = ResearcherConversation::findOrFail($note_id);

            // Check if user has permission to edit this note
            if ($note->added_by !== auth()->id() && ! auth()->user()->hasRole('super-admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to edit this note',
                ], 403);
            }

            $note->update([
                'original_content' => $request->original_content,
                'content'          => $request->translated_content,
            ]);

            log_activity('Researcher Note', 'update', "Note updated ID: {$note_id}");

            return response()->json([
                'success' => true,
                'message' => 'Note updated successfully',
                'note'    => [
                    'id'               => $note->id,
                    'original_content' => $note->original_content,
                    'content'          => $note->content,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating note: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a note via AJAX
     */
    public function deleteNote($note_id)
    {
        try {
            $note = ResearcherConversation::findOrFail($note_id);

            // Check if user has permission to delete this note
            if ($note->added_by !== auth()->id() && ! auth()->user()->hasRole('super-admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to delete this note',
                ], 403);
            }

            // Delete associated attachment file if it exists
            if ($note->attachment && file_exists(public_path($note->attachment))) {
                unlink(public_path($note->attachment));
            }

            $note->delete();

            log_activity('Researcher Note', 'delete', "Note deleted ID: {$note_id}");

            return response()->json([
                'success' => true,
                'message' => 'Note deleted successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting note: ' . $e->getMessage(),
            ], 500);
        }
    }

    // status update
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id'              => 'required|exists:clients,id',
            'research_status' => 'required|in:completed',
        ]);

        $research                  = Client::findOrFail($request->id);
        $oldStatus                 = $research->research_status;
        $research->research_status = $request->research_status;

        // Use saveQuietly to bypass automatic status updates from the scope
        $research->save();

        log_activity('Researcher', 'status', "Research status changed from {$oldStatus} to {$research->research_status} for: {$research->lead->first_name} {$research->lead->last_name}");

        return redirect('admin/researcher')->with('success', 'Research status updated successfully');
    }
}
