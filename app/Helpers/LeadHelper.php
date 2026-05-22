<?php
namespace App\Helpers;

use App\Models\Children;
use App\Models\Family;
use App\Models\LeadAttachment;
use App\Models\LeadNote;
use App\Models\Lineages;
use App\Models\Sibling;
use App\Models\WifeDetail;
use Auth;

class LeadHelper
{
    public static function saveFamilyMembers($leadId, $belongsTo, $data, $notes = null)
    {
        Family::where('lead_id', $leadId)->where('belongs_to', $belongsTo)->forceDelete();

        foreach (['father', 'mother', 'grandfather', 'grandmother'] as $relation) {
            if (isset($data[$relation])) {
                Family::create([
                    'lead_id'       => $leadId,
                    'belongs_to'    => $belongsTo,
                    'relation'      => $relation,
                    'name'          => $data[$relation]['name'],
                    'birth_date'    => $data[$relation]['birth_date'],
                    'marriage_date' => $data[$relation]['marriage_date'] ?? null,
                    'death_date'    => $data[$relation]['death_date'] ?? null,

                ]);
            }
        }
    }

    public static function saveGreatGrandParents($leadId, $belongsTo, $request, $prefix, $relation)
    {
        Family::where('lead_id', $leadId)->where('belongs_to', $belongsTo)->where('relation', $relation)->forceDelete();

        foreach ($request->input("{$prefix}_name", []) as $index => $name) {
            if ($name) {
                Family::create([
                    'lead_id'       => $leadId,
                    'belongs_to'    => $belongsTo,
                    'relation'      => $relation,
                    'name'          => $name,
                    'birth_date'    => $request->input("{$prefix}_dob.$index"),
                    'marriage_date' => $request->input("{$prefix}_marriage_date.$index"),
                    'death_date'    => $request->input("{$prefix}_death_date.$index"),
                ]);
            }
        }
    }

    public static function saveSiblings($leadId, $belongsTo, $request, $prefix)
    {
        Sibling::where('lead_id', $leadId)->where('belongs_to', $belongsTo)->forceDelete();

        foreach ($request->input("{$prefix}_relation", []) as $index => $relation) {
            Sibling::create([
                'lead_id'    => $leadId,
                'belongs_to' => $belongsTo,
                'relation'   => $relation,
                'name'       => $request->input("{$prefix}_name.$index"),
                'birth_date' => $request->input("{$prefix}_dob.$index"),
                'death_date' => $request->input("{$prefix}_death_date.$index"),
            ]);
        }
    }

    public static function saveLineages($leadId, $request)
    {
        Lineages::where('lead_id', $leadId)->forceDelete();

        foreach ($request->input('belongs_to', []) as $index => $belongsTo) {
            Lineages::create([
                'lead_id'           => $leadId,
                'belongs_to'        => $belongsTo,
                'lineage'           => $request->input("lineage.$index"),
                'caste'             => $request->input("caste.$index"),
                'sub_caste'         => $request->input("sub_caste.$index"),
                'surname'           => $request->input("surname.$index"),
                'gotra'             => $request->input("gotra.$index"),
                'kuldevi'           => $request->input("kuldevi.$index"),
                'kuldevta'          => $request->input("kuldevta.$index"),
                'primary_clan'      => $request->input("primary_clan.$index"),
                'sub_clan'          => $request->input("sub_clan.$index"),
                'khap'              => $request->input("khap.$index"),
                'rulership'         => $request->input("rulership.$index"),
                'spiritual_seat'    => $request->input("spiritual_seat.$index"),
                'ancestral_village' => $request->input("ancestral_village.$index"),
                'note'              => $request->input("notes.$index"),
            ]);
        }
    }

    public static function saveWifeDetails($leadId, $request)
    {
        WifeDetail::updateOrCreate(
            ['lead_id' => $leadId],
            [
                'first_name'    => $request->wife_first_name,
                'middle_name'   => $request->wife_middle_name,
                'last_name'     => $request->wife_last_name,
                'birth_date'    => $request->wife_dob,
                'marriage_date' => $request->wife_marriage_date,
                'death_date'    => $request->wife_death_date,
                'phone'         => $request->wife_phone,
                'phonecode'     => $request->wife_phonecode,
                'email'         => $request->wife_email,
                'country'       => $request->wife_country,
                'state'         => $request->wife_state,
                'district'      => $request->wife_district,
                'city'          => $request->wife_city,
                'taluka'        => $request->wife_taluka,
                'village'       => $request->wife_village,
                'address'       => $request->wife_notes_address,
            ]
        );
    }

    public static function saveChildren($leadId, $request)
    {
        Children::where('lead_id', $leadId)->forceDelete();

        foreach ($request->input('child_name', []) as $index => $name) {
            if ($name) {
                Children::create([
                    'lead_id'    => $leadId,
                    'name'       => $name,
                    'gender'     => $request->input("child_gender.$index") ?? 'male',
                    'birth_date' => $request->input("child_dob.$index"),
                ]);
            }
        }
    }

    public static function saveLeadNotes($leadId, $request)
    {
        LeadNote::where('lead_id', $leadId)->forceDelete();

        foreach ($request->input('content', []) as $index => $content) {
            if ($content) {
                $addedBy = $request->input("added_by.$index") ?? auth()->id();

                // Get original content - try to get from original_content array first, then fallback to content
                $originalContent = $request->input("original_content.$index") ?? $content;

                // Create the note first
                $note = LeadNote::create([
                    'lead_id'          => $leadId,
                    'added_by'         => $addedBy,
                    'original_content' => $originalContent,
                    'content'          => $content,
                ]);

                // Handle new file uploads for this specific note
                if ($request->hasFile("attachment.$index")) {
                    foreach ($request->file("attachment.$index") as $file) {
                        $fileType     = $file->getMimeType();
                        $fileCategory = explode('/', $fileType)[0]; // 'image', 'audio', or 'application'

                        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('assets/admin/leads/attachment'), $fileName);

                        LeadAttachment::create([
                            'lead_id'    => $leadId,
                            'note_id'    => $note->id,
                            'attachment' => 'assets/admin/leads/attachment/' . $fileName,
                            'type'       => $fileCategory,
                        ]);
                    }
                }

                // Handle existing files for this specific note
                if ($request->has("existing_attachment.$index")) {
                    $existingAttachments = $request->input("existing_attachment.$index");
                    if (is_array($existingAttachments)) {
                        foreach ($existingAttachments as $existingFile) {
                            $fileMime     = mime_content_type(public_path($existingFile));
                            $fileCategory = explode('/', $fileMime)[0];

                            LeadAttachment::create([
                                'lead_id'    => $leadId,
                                'note_id'    => $note->id,
                                'attachment' => $existingFile,
                                'type'       => $fileCategory,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
