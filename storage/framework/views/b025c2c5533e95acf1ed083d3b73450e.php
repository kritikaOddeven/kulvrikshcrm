

<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
            Family lineage and heritage
        </button>
    </h2>
    <?php
        $leadLineage = $data->lineages && isset($data->lineages) ? $data->lineages()->firstWhere('belongs_to', 'lead') : null;
    ?>

    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
        <div class="accordion-body">
            <table class="table info-table">
                <tbody>
                    <tr>
                        <th>Lineage</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e(optional($leadLineage)->lineage ?? ''); ?></td>

                        <th>Caste</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e(optional($leadLineage)->caste ?? ''); ?></td>

                        <th>Sub-Caste</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e(optional($leadLineage)->sub_caste ?? ''); ?></td>

                        <th>Surname</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e(optional($leadLineage)->surname ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Gotra</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e(optional($leadLineage)->gotra ?? ''); ?></td>

                        <th>Kuldevi</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e(optional($leadLineage)->kuldevi ?? ''); ?></td>

                        <th>Kuldevta</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e(optional($leadLineage)->kuldevta ?? ''); ?></td>

                        <th>Primary Clan</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e(optional($leadLineage)->primary_clan ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Sub-clan</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e(optional($leadLineage)->sub_clan ?? ''); ?></td>

                        <th>Khap</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e(optional($leadLineage)->khap ?? ''); ?></td>

                        <th>Rulership</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e(optional($leadLineage)->rulership ?? ''); ?></td>


                        <th>Spiritual Seat</th>
                        <td>:</td>
                        <td class="ps-3"><?php echo e(optional($leadLineage)->spiritual_seat ?? ''); ?></td>
                    </tr>
                    <tr>
                        <th>Ancestral Village</th>
                        <td>:</td>
                        <td class="ps-3" colspan="4"><?php echo e(optional($leadLineage)->ancestral_village ?? ''); ?></td>

                        <th>Notes/Address</th>
                        <td>:</td>
                        <td class="ps-3" colspan="4"><?php echo e(optional($leadLineage)->note ?? ''); ?></td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
</div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/leads/details/lineage-info.blade.php ENDPATH**/ ?>