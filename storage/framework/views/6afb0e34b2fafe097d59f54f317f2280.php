<!DOCTYPE html>
<html>
<head>
    <title>Client Preview</title>
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
            background-color: #007bff;
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
            <img src="<?php echo e(public_path('assets/admin/images/logo.png')); ?>" alt="logo" class="logo">
            <h4 style="margin: 5px 0; font-size: 14px;">REF001</h4>
        </div>

        <?php
            $assign_researchers = getResearchersWithNames(json_decode($data->researcher_ids ?? '[]', true))['researchers'] ?? '';
            $projects = getProjectsWithNames('parent', json_decode($data->project_ids ?? '[]', true))['names'] ?? '';
            $subprojects = getProjectsWithNames('subproject', json_decode($data->sub_project_ids ?? '[]', true))['names'] ?? '';
        ?>
        <div class="section">
            <div class="section-title">Client Information</div>
            <table>
                <tbody>
                    <tr>
                        <th>KV ID</th>
                        <td><?php echo e($data->kulvrisk_id ?? ''); ?></td>
                        <th>Researcher Name</th>
                        <td>
                            <?php $__currentLoopData = $assign_researchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researcher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span><?php echo e($researcher->name); ?></span>
                                <?php if(!$loop->last): ?>
                                    ,
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <th>Payment Mode</th>
                        <td><?php echo e($data->payment_mode ? paymentMode($data->payment_mode) : ''); ?></td>
                        <th>Image</th>
                        <td><?php echo e($data->image_path ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Project</th>
                        <td><?php echo e($projects ?? ''); ?></td>
                        <th>Sub Project</th>
                        <td><?php echo e($subprojects ?? ''); ?></td>
                        <th>Start Date</th>
                        <td><?php echo e($data->start_date ?? ''); ?></td>
                        <th>End Date</th>
                        <td><?php echo e($data->end_date ?? ''); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Lead Information</div>
            <table>
                <tbody>
                    <tr>
                        <th>First Name</th>
                        <td><?php echo e($data->lead->first_name); ?></td>
                        <th>Middle Name</th>
                        <td><?php echo e($data->lead->middle_name); ?></td>
                        <th>Last Name</th>
                        <td><?php echo e($data->lead->last_name); ?></td>
                        <th>DOB</th>
                        <td><?php echo e($data->lead->birth_date); ?></td>
                    </tr>
                    <tr>
                        <th>Marriage Date</th>
                        <td><?php echo e($data->lead->marriage_date); ?></td>
                        <th>Phone No.</th>
                        <td><?php echo e($data->lead->phone); ?></td>
                        <th>Email</th>
                        <td><?php echo e($data->lead->email); ?></td>
                        <th>Country</th>
                        <td><?php echo e($data->lead->countries->name ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td><?php echo e($data->lead->states->name ?? ''); ?></td>
                        <th>District</th>
                        <td><?php echo e($data->lead->districts->name ?? ''); ?></td>
                        <th>City</th>
                        <td><?php echo e($data->lead->cities->name ?? ''); ?></td>
                        <th>Taluka</th>
                        <td><?php echo e($data->lead->taluka ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Village</th>
                        <td><?php echo e($data->lead->village ?? ''); ?></td>
                        <th>Notes/Address</th>
                        <td colspan="6"><?php echo e($data->lead->notes); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <?php
                $leadLineage = $data->lead->lineages && isset($data->lead->lineages) ? $data->lead->lineages->firstWhere('belongs_to', 'lead') : null;
            ?>
            <div class="section-title">Lead Family Lineage and Heritage</div>
            <table>
                <tbody>
                    <tr>
                        <th>Lineage</th>
                        <td><?php echo e(optional($leadLineage)->lineage); ?></td>
                        <th>Caste</th>
                        <td><?php echo e(optional($leadLineage)->caste); ?></td>
                        <th>Sub-Caste</th>
                        <td><?php echo e(optional($leadLineage)->sub_caste); ?></td>
                        <th>Surname</th>
                        <td><?php echo e(optional($leadLineage)->surname); ?></td>
                    </tr>
                    <tr>
                        <th>Gotra</th>
                        <td><?php echo e(optional($leadLineage)->gotra); ?></td>
                        <th>Kuldevi</th>
                        <td><?php echo e(optional($leadLineage)->kuldevi); ?></td>
                        <th>Kuldevta</th>
                        <td><?php echo e(optional($leadLineage)->kuldevta); ?></td>
                        <th>Primary Clan</th>
                        <td><?php echo e(optional($leadLineage)->primary_clan); ?></td>
                    </tr>
                    <tr>
                        <th>Sub-clan</th>
                        <td><?php echo e(optional($leadLineage)->sub_clan); ?></td>
                        <th>Khap</th>
                        <td><?php echo e(optional($leadLineage)->khap); ?></td>
                        <th>Rulership</th>
                        <td><?php echo e(optional($leadLineage)->rulership); ?></td>
                        <th>Spiritual Seat</th>
                        <td><?php echo e(optional($leadLineage)->spiritual_seat); ?></td>
                    </tr>
                    <tr>
                        <th>Ancestral Village</th>
                        <td colspan="3"><?php echo e(optional($leadLineage)->ancestral_village); ?></td>
                        <th>Notes/Address</th>
                        <td colspan="3"><?php echo e(optional($leadLineage)->ancestral_village); ?></td>
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
                    <?php $__currentLoopData = $data->lead->families->whereIn('belongs_to', 'lead'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(ucfirst($item->relation)); ?></td>
                            <td><?php echo e($item->name); ?></td>
                            <td><?php echo e($item->birth_date); ?></td>
                            <td><?php echo e($item->marriage_date); ?></td>
                            <td><?php echo e($item->death_date); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php $__currentLoopData = $data->lead->siblings->whereIn('belongs_to', 'lead'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(ucfirst($item->relation)); ?></td>
                            <td><?php echo e($item->name); ?></td>
                            <td><?php echo e($item->birth_date); ?></td>
                            <td><?php echo e($item->death_date); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="notes-section">
                <label>Ancestor History Notes</label>
                <div style="border: .5px solid #dfdcdc; padding:10px;" readonly name="ancestor_notes"><?php echo e($data->lead->lead_ancestor_notes); ?></div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Lead Wife Information</div>
            <table>
                <tbody>
                    <tr>
                        <th>First Name</th>
                        <td><?php echo e($data->lead->wifeDetail->first_name ?? ''); ?></td>
                        <th>Middle Name</th>
                        <td><?php echo e($data->lead->wifeDetail->middle_name ?? ''); ?></td>
                        <th>Last Name</th>
                        <td><?php echo e($data->lead->wifeDetail->last_name ?? ''); ?></td>
                        <th>DOB</th>
                        <td><?php echo e($data->lead->wifeDetail->birth_date ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Marriage Date</th>
                        <td><?php echo e($data->lead->wifeDetail->marriage_date ?? ''); ?></td>
                        <th>Death Date</th>
                        <td><?php echo e($data->lead->wifeDetail->death_date ?? ''); ?></td>
                        <th>Phone No.</th>
                        <td><?php echo e($data->lead->wifeDetail->phonecode ?? ''); ?><?php echo e($data->lead->wifeDetail->phone ?? ''); ?></td>
                        <th>Email</th>
                        <td><?php echo e($data->lead->wifeDetail->email ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td><?php echo e($data->lead->wifeDetail->countries->name ?? ''); ?></td>
                        <th>State</th>
                        <td><?php echo e($data->lead->wifeDetail->states->name ?? ''); ?></td>
                        <th>District</th>
                        <td><?php echo e($data->lead->wifeDetail->districts->name ?? ''); ?></td>
                        <th>City</th>
                        <td><?php echo e($data->lead->wifeDetail->cities->name ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Taluka</th>
                        <td><?php echo e($data->lead->wifeDetail->taluka ?? ''); ?></td>
                        <th>Village</th>
                        <td><?php echo e($data->lead->wifeDetail->village ?? ''); ?></td>
                        <th>Notes/Address</th>
                        <td colspan="3"><?php echo e($data->lead->wifeDetail->address ?? ''); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Wife Family Lineage and Heritage</div>
            <?php
                $wifeLineage = $data->lead->lineages && isset($data->lead->lineages) ? $data->lead->lineages->firstWhere('belongs_to', 'wife') : null;
            ?>
            <table>
                <tbody>
                    <tr>
                        <th>Lineage</th>
                        <td><?php echo e(optional($wifeLineage)->lineage); ?></td>
                        <th>Caste</th>
                        <td><?php echo e(optional($wifeLineage)->caste); ?></td>
                        <th>Sub-Caste</th>
                        <td><?php echo e(optional($wifeLineage)->sub_caste); ?></td>
                        <th>Surname</th>
                        <td><?php echo e(optional($wifeLineage)->surname); ?></td>
                    </tr>
                    <tr>
                        <th>Gotra</th>
                        <td><?php echo e(optional($wifeLineage)->gotra); ?></td>
                        <th>Kuldevi</th>
                        <td><?php echo e(optional($wifeLineage)->kuldevi); ?></td>
                        <th>Kuldevta</th>
                        <td><?php echo e(optional($wifeLineage)->kuldevta); ?></td>
                        <th>Primary Clan</th>
                        <td><?php echo e(optional($wifeLineage)->primary_clan); ?></td>
                    </tr>
                    <tr>
                        <th>Sub-clan</th>
                        <td><?php echo e(optional($wifeLineage)->sub_clan); ?></td>
                        <th>Khap</th>
                        <td><?php echo e(optional($wifeLineage)->khap); ?></td>
                        <th>Rulership</th>
                        <td><?php echo e(optional($wifeLineage)->rulership); ?></td>
                        <th>Spiritual Seat</th>
                        <td><?php echo e(optional($wifeLineage)->spiritual_seat); ?></td>
                    </tr>
                    <tr>
                        <th>Ancestral Village</th>
                        <td colspan="3"><?php echo e(optional($wifeLineage)->ancestral_village); ?></td>
                        <th>Notes/Address</th>
                        <td colspan="3"><?php echo e(optional($wifeLineage)->note); ?></td>
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
                    <?php $__currentLoopData = $data->lead->families->whereIn('belongs_to', 'wife'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(ucfirst($item->relation)); ?></td>
                            <td><?php echo e($item->name); ?></td>
                            <td><?php echo e($item->birth_date); ?></td>
                            <td><?php echo e($item->marriage_date); ?></td>
                            <td><?php echo e($item->death_date); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php $__currentLoopData = $data->lead->siblings->whereIn('belongs_to', 'wife'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->relation); ?></td>
                            <td><?php echo e($item->name); ?></td>
                            <td><?php echo e($item->birth_date); ?></td>
                            <td><?php echo e($item->death_date); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="notes-section">
                <label>Ancestor History Notes</label>
                <div style="border: .5px solid #dfdcdc; padding:10px;" readonly name="ancestor_notes" rows="5"><?php echo e($data->lead->wife_ancestor_notes); ?></div>
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
                    <?php $__currentLoopData = $data->lead->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(ucfirst($item->gender ?? '')); ?></td>
                            <td><?php echo e($item->name ?? ''); ?></td>
                            <td><?php echo e($item->birth_date ?? ''); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>


        <div class="section">
            <div class="section-title">Notes</div>
            <table class="notes-table">
                <tbody>
                    <?php $__currentLoopData = $data->lead->leadNote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $nameParts = explode(' ', $item->user->name ?? '');
                            $initials = '';
                            if (count($nameParts) > 0) {
                                $initials .= strtoupper(substr($nameParts[0], 0, 1));
                                if (count($nameParts) > 1) {
                                    $initials .= strtoupper(substr($nameParts[1], 0, 1));
                                }
                            }
                        ?>
                        <tr>
                            <td style="width:100%">
                                <div class="notes-header-row">
                                    <span class="notes-user">
                                        <img src="<?php echo e($item->user->profile_image ? public_path($item->user->profile_image) : 'https://placehold.co/50?text='.get_initials($item->user->name)); ?>" alt="user" class="notes-initials">
                                        <span><?php echo e($item->user->name ?? ''); ?></span>
                                    </img>
                                    <span class="notes-date"><?php echo e($item->created_at->format('D d F, g:i')); ?></span>
                                </div>
                                <div class="notes-content"><?php echo e(strip_tags($item->content)); ?></div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/preview/client-preview.blade.php ENDPATH**/ ?>