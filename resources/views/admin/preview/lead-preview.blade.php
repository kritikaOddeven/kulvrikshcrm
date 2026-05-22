<!DOCTYPE html>
<html>
<head>
    <title>Lead Preview</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;700&family=Noto+Sans+Gujarati:wght@400;700&family=Noto+Sans:wght@400;700&display=swap');
        
        @page {
            size: landscape;
            margin: 10mm;
        }
        body {
            font-family: 'Noto Sans Devanagari', 'Noto Sans Gujarati', 'Noto Sans', sans-serif;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 10px;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .logo {
            max-height: 40px;
            margin-bottom: 5px;
        }
        .section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #f5f5f5;
            padding: 5px 8px;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 11px;
        }
        th, td {
            padding: 4px 6px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .notes-section {
            margin-top: 10px;
        }
        .note-item {
            margin-bottom: 8px;
            padding: 6px;
            background-color: #f9f9f9;
            border-radius: 3px;
            font-size: 11px;
        }
        .note-header {
            display: flex;
            align-items: center;
            margin-bottom: 3px;
        }
        .initials {
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-size: 10px;
        }
        textarea {
            width: 100%;
            padding: 4px;
            border: 1px solid #ddd;
            border-radius: 3px;
            resize: none;
            font-size: 11px;
        }
        @media print {
            body {
                padding: 0;
            }
            .section {
                page-break-inside: avoid;
            }
        }
        .notes-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 12px;
        }
        .notes-table th, .notes-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        .notes-table th {
            background: #f5f5f5;
            font-weight: bold;
        }
        .notes-user {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .notes-initials {
            width: 28px;
            height: 28px;
            border-radius: 50%;
        }
        .notes-date {
            text-align: right;
            color: #888;
            font-size: 11px;
            white-space: nowrap;
        }
        .notes-content {
            word-break: break-word;
        }
        .notes-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('assets/admin/images/logo.png') }}" alt="logo" class="logo">
            <h4 style="margin: 5px 0; font-size: 14px;">REF001</h4>
        </div>

        <div class="section">
            <div class="section-title">Lead Information</div>
            <table>
                <tbody>
                    <tr>
                        <th>First Name</th>
                        <td>{{ $data->first_name }}</td>
                        <th>Middle Name</th>
                        <td>{{ $data->middle_name }}</td>
                        <th>Last Name</th>
                        <td>{{ $data->last_name }}</td>
                        <th>DOB</th>
                        <td>{{ $data->birth_date }}</td>
                    </tr>
                    <tr>
                        <th>Marriage Date</th>
                        <td>{{ $data->marriage_date }}</td>
                        <th>Phone No.</th>
                        <td>{{ $data->phone }}</td>
                        <th>Email</th>
                        <td>{{ $data->email }}</td>
                        <th>Country</th>
                        <td>{{ $data->countries->name }}</td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>{{ $data->states->name }}</td>
                        <th>District</th>
                        <td>{{ $data->districts->name }}</td>
                        <th>City</th>
                        <td>{{ $data->cities->name }}</td>
                        <th>Taluka</th>
                        <td>{{ $data->taluka }}</td>
                    </tr>
                    <tr>
                        <th>Village</th>
                        <td>{{ $data->village }}</td>
                        <th>Notes/Address</th>
                        <td colspan="6">{{ $data->notes }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            @php
                $leadLineage = $data->lineages && isset($data->lineages) ? $data->lineages()->firstWhere('belongs_to', 'lead') : null;
            @endphp
            <div class="section-title">Lead Family Lineage and Heritage</div>
            <table>
                <tbody>
                    <tr>
                        <th>Lineage</th>
                        <td>{{ optional($leadLineage)->lineage }}</td>
                        <th>Caste</th>
                        <td>{{ optional($leadLineage)->caste }}</td>
                        <th>Sub-Caste</th>
                        <td>{{ optional($leadLineage)->sub_caste }}</td>
                        <th>Surname</th>
                        <td>{{ optional($leadLineage)->surname }}</td>
                    </tr>
                    <tr>
                        <th>Gotra</th>
                        <td>{{ optional($leadLineage)->gotra }}</td>
                        <th>Kuldevi</th>
                        <td>{{ optional($leadLineage)->kuldevi }}</td>
                        <th>Kuldevta</th>
                        <td>{{ optional($leadLineage)->kuldevta }}</td>
                        <th>Primary Clan</th>
                        <td>{{ optional($leadLineage)->primary_clan }}</td>
                    </tr>
                    <tr>
                        <th>Sub-clan</th>
                        <td>{{ optional($leadLineage)->sub_clan }}</td>
                        <th>Khap</th>
                        <td>{{ optional($leadLineage)->khap }}</td>
                        <th>Rulership</th>
                        <td>{{ optional($leadLineage)->rulership }}</td>
                        <th>Spiritual Seat</th>
                        <td>{{ optional($leadLineage)->spiritual_seat }}</td>
                    </tr>
                    <tr>
                        <th>Ancestral Village</th>
                        <td colspan="3">{{ optional($leadLineage)->ancestral_village }}</td>
                        <th>Notes/Address</th>
                        <td colspan="3">{{ optional($leadLineage)->ancestral_village }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Lead Family Information</div>
            <table>
                <thead>
                    <tr>
                        <th>Relation</th>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Marriage Date</th>
                        <th>Death Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->families->whereIn('belongs_to', 'lead') as $item)
                        <tr>
                            <td>{{ ucfirst($item->relation) }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->birth_date }}</td>
                            <td>{{ $item->marriage_date }}</td>
                            <td>{{ $item->death_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table>
                <thead>
                    <tr>
                        <th>Relation</th>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Death Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->siblings->whereIn('belongs_to', 'lead') as $item)
                        <tr>
                            <td>{{ ucfirst($item->relation) }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->birth_date }}</td>
                            <td>{{ $item->death_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="notes-section">
                <label>Ancestor History Notes</label>
                <div style="border: .5px solid #dfdcdc; padding:10px;" readonly name="ancestor_notes" rows="5">{{ $data->lead_ancestor_notes }}</div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Lead Wife Information</div>
            <table>
                <tbody>
                    <tr>
                        <th>First Name</th>
                        <td>{{ $data->wifeDetail->first_name ?? '' }}</td>
                        <th>Middle Name</th>
                        <td>{{ $data->wifeDetail->middle_name ?? '' }}</td>
                        <th>Last Name</th>
                        <td>{{ $data->wifeDetail->last_name ?? '' }}</td>
                        <th>DOB</th>
                        <td>{{ $data->wifeDetail->birth_date ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Marriage Date</th>
                        <td>{{ $data->wifeDetail->marriage_date ?? '' }}</td>
                        <th>Death Date</th>
                        <td>{{ $data->wifeDetail->death_date ?? '' }}</td>
                        <th>Phone No.</th>
                        <td>{{ $data->wifeDetail->phonecode ?? '' }}{{ $data->wifeDetail->phone ?? '' }}</td>
                        <th>Email</th>
                        <td>{{ $data->wifeDetail->email ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td>{{ $data->wifeDetail->countries->name ?? '' }}</td>
                        <th>State</th>
                        <td>{{ $data->wifeDetail->states->name ?? '' }}</td>
                        <th>District</th>
                        <td>{{ $data->wifeDetail->districts->name ?? '' }}</td>
                        <th>City</th>
                        <td>{{ $data->wifeDetail->cities->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Taluka</th>
                        <td>{{ $data->wifeDetail->taluka ?? '' }}</td>
                        <th>Village</th>
                        <td>{{ $data->wifeDetail->village ?? '' }}</td>
                        <th>Notes/Address</th>
                        <td colspan="3">{{ $data->wifeDetail->address ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Wife Family Lineage and Heritage</div>
            @php
                $wifeLineage = $data->lineages && isset($data->lineages) ? $data->lineages()->firstWhere('belongs_to', 'wife') : null;
            @endphp
            <table>
                <tbody>
                    <tr>
                        <th>Lineage</th>
                        <td>{{ optional($wifeLineage)->lineage }}</td>
                        <th>Caste</th>
                        <td>{{ optional($wifeLineage)->caste }}</td>
                        <th>Sub-Caste</th>
                        <td>{{ optional($wifeLineage)->sub_caste }}</td>
                        <th>Surname</th>
                        <td>{{ optional($wifeLineage)->surname }}</td>
                    </tr>
                    <tr>
                        <th>Gotra</th>
                        <td>{{ optional($wifeLineage)->gotra }}</td>
                        <th>Kuldevi</th>
                        <td>{{ optional($wifeLineage)->kuldevi }}</td>
                        <th>Kuldevta</th>
                        <td>{{ optional($wifeLineage)->kuldevta }}</td>
                        <th>Primary Clan</th>
                        <td>{{ optional($wifeLineage)->primary_clan }}</td>
                    </tr>
                    <tr>
                        <th>Sub-clan</th>
                        <td>{{ optional($wifeLineage)->sub_clan }}</td>
                        <th>Khap</th>
                        <td>{{ optional($wifeLineage)->khap }}</td>
                        <th>Rulership</th>
                        <td>{{ optional($wifeLineage)->rulership }}</td>
                        <th>Spiritual Seat</th>
                        <td>{{ optional($wifeLineage)->spiritual_seat }}</td>
                    </tr>
                    <tr>
                        <th>Ancestral Village</th>
                        <td colspan="3">{{ optional($wifeLineage)->ancestral_village }}</td>
                        <th>Notes/Address</th>
                        <td colspan="3">{{ optional($wifeLineage)->note }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Wife Family Information</div>
            <table>
                <thead>
                    <tr>
                        <th>Relation</th>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Marriage Date</th>
                        <th>Death Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->families->whereIn('belongs_to', 'wife') as $item)
                        <tr>
                            <td>{{ ucfirst($item->relation) }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->birth_date }}</td>
                            <td>{{ $item->marriage_date }}</td>
                            <td>{{ $item->death_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table>
                <thead>
                    <tr>
                        <th>Relation</th>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Death Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->siblings->whereIn('belongs_to', 'wife') as $item)
                        <tr>
                            <td>{{ $item->relation }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->birth_date }}</td>
                            <td>{{ $item->death_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="notes-section">
                <label>Ancestor History Notes</label>
                <div style="border: .5px solid #dfdcdc; padding:10px;" readonly name="ancestor_notes" rows="5">{{ $data->wife_ancestor_notes }}</div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Children Information</div>
            <table>
                <thead>
                    <tr>
                        <th>Gender</th>
                        <th>Children Name</th>
                        <th>Birth Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->children as $item)
                        <tr>
                            <td>{{ ucfirst($item->gender ?? '') }}</td>
                            <td>{{ $item->name ?? '' }}</td>
                            <td>{{ $item->birth_date ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Notes</div>
            <table class="notes-table">
                <tbody>
                    @foreach ($data->leadNote as $item)
                        
                        <tr>
                            <td style="width:100%">
                                <div class="notes-header-row">
                                    <span class="notes-user">
                                        <img src="{{ $item->user->profile_image ? public_path($item->user->profile_image) : 'https://placehold.co/50?text='.get_initials($item->user->name) }}" alt="user" class="notes-initials">
                                        <span>{{ $item->user->name ?? '' }}</span>
                                    </span>
                                    <span class="notes-date">{{ $item->created_at->format('D d F, g:i') }}</span>
                                </div>
                                <div class="notes-content">{{ strip_tags($item->content) }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>