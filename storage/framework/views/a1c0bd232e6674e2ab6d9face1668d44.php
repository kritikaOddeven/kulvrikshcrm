<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="<?php echo e(request()->is('admin/dashboard') ? 'menuitem-active' : ''); ?>">
                    <a class=' <?php echo e(request()->is('admin/dashboard') ? 'active' : ''); ?>' href='<?php echo e(url('admin/dashboard')); ?>'>
                        <i class="ri-home-3-line"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add_agent', 'edit_agent', 'view_agent', 'delete_agent'])): ?>
                    <li class="<?php echo e(request()->is('admin/agents*') ? 'menuitem-active' : ''); ?>">
                        <a class="<?php echo e(request()->is('admin/agents') ? 'active' : ''); ?>" href="<?php echo e(url('admin/agents/*')); ?>#sidebarAuth" data-bs-toggle="collapse">
                            <i class="ri-user-line"></i>
                            <span> Agents </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?php echo e(request()->is('admin/agents*') ? 'show' : ''); ?>" id="sidebarAuth">
                            <ul class="nav-second-level">
                                <li>
                                    <a class='tp-link <?php echo e(request()->is('admin/agents') ? 'active' : ''); ?>' href='<?php echo e(url('admin/agents')); ?>'>View All Agents</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add_role', 'edit_role', 'view_role', 'delete_role'])): ?>
                    <li class="<?php echo e(request()->is('admin/roles*') ? 'menuitem-active' : ''); ?>">
                        <a class="<?php echo e(request()->is('admin/roles') ? 'active' : ''); ?>" href="<?php echo e(url('admin/roles/*')); ?>#sidebarAuth1" data-bs-toggle="collapse">
                            <i class="ri-shield-line"></i>
                            <span> Roles </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?php echo e(request()->is('admin/roles') ? 'show' : ''); ?>" id="sidebarAuth1">
                            <ul class="nav-second-level">
                                <li>
                                    <a class='tp-link <?php echo e(request()->is('admin/roles') ? 'active' : ''); ?>' href='<?php echo e(url('admin/roles')); ?>'>View All Roles</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add_lead', 'edit_lead', 'view_lead', 'delete_lead', 'convert_to_client', 'preview_lead', 'send_lead_email', 'send_lead_whatsapp'])): ?>
                    <li class="<?php echo e(request()->is('admin/leads*') ? 'menuitem-active' : ''); ?>">
                        <a class="<?php echo e(request()->is('admin/leads') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/leads')); ?>#sidebarAuth2" data-bs-toggle="collapse">
                            <i class="ri-bar-chart-line"></i>
                            <span> Leads </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?php echo e(request()->is('admin/leads') ? 'show' : ''); ?>" id="sidebarAuth2">
                            <ul class="nav-second-level">
                                <li>
                                    <a class='tp-link <?php echo e(request()->is('admin/leads') ? 'active' : ''); ?>' href='<?php echo e(url('/admin/leads')); ?>'>View All Leads</a>
                                </li>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_lead')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/leads/create') ? 'active' : ''); ?>' href='<?php echo e(url('/admin/leads/create')); ?>'> Add Leads</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add_client', 'edit_client', 'view_client', 'delete_client', 'generate_bill', 'preview_client', 'send_client_email', 'send_client_whatsapp'])): ?>
                    <li class="<?php echo e(request()->is('admin/clients*') ? 'menuitem-active' : ''); ?>">
                        <a class="<?php echo e(request()->is('admin/clients') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/clients')); ?>#sidebarAuth3" data-bs-toggle="collapse">
                            <i class="ri-group-line"></i>
                            <span> Clients </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?php echo e(request()->is('admin/clients') ? 'show' : ''); ?>" id="sidebarAuth3">
                            <ul class="nav-second-level">
                                <li>
                                    <a class='tp-link <?php echo e(request()->is('admin/clients') ? 'active' : ''); ?>' href='<?php echo e(url('/admin/clients')); ?>'>View All Clients</a>
                                </li>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_client')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/clients/create') ? 'active' : ''); ?>' href='<?php echo e(url('/admin/clients/create')); ?>'> Add Clients</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_researcher', 'delete_researcher', 'edit_researcher'])): ?>
                    <li class="<?php echo e(request()->is('admin/researcher*') ? 'menuitem-active' : ''); ?>">
                        <a class="<?php echo e(request()->is('admin/researcher') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/researcher')); ?>#sidebarAuth0" data-bs-toggle="collapse">
                            <i class="ri-user-search-line"></i>
                            <span> Researcher </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?php echo e(request()->is('admin/researcher') ? 'show' : ''); ?>" id="sidebarAuth0">
                            <ul class="nav-second-level">
                                <li>
                                    <a class='tp-link <?php echo e(request()->is('admin/researcher') ? 'active' : ''); ?>' href='<?php echo e(url('/admin/researcher')); ?>'>View All Researcher</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_researcher_report', 'delete_researcher_report', 'preview_researcher_report', 'send_researcher_report_email', 'send_researcher_report_whatsapp', 'fill_researcher_report_form', 'archive_report', 'download_archive_report', 'view_archive_report', 'delete_archive_report'])): ?>
                    <li class="<?php echo e(request()->is('admin/research-reports*') ? 'menuitem-active' : ''); ?>">
                        <a class="<?php echo e(request()->is('admin/research-reports') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/research-reports')); ?>#sidebarAuthR" data-bs-toggle="collapse">
                            <i class="ri-file-search-line"></i>

                            <span> Research Report </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?php echo e(request()->is('admin/research-reports') ? 'show' : ''); ?>" id="sidebarAuthR">
                            <ul class="nav-second-level">
                                <li>
                                    <a class='tp-link <?php echo e(request()->is('admin/research-reports/') ? 'active' : ''); ?>' href='<?php echo e(url('/admin/research-reports')); ?>'>View All Report</a>
                                </li>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('archive_report')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/research-reports/archives') ? 'active' : ''); ?>' href='<?php echo e(url('/admin/research-reports/archives')); ?>'>Archive Report</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add_project', 'edit_project', 'view_project', 'delete_project', 'add_sub_project', 'edit_sub_project', 'delete_sub_project'])): ?>
                    <li class="<?php echo e(request()->is('admin/projects*') ? 'menuitem-active' : ''); ?>">
                        <a class="<?php echo e(request()->is('admin/projects') ? 'active' : ''); ?>" href="<?php echo e(url('admin/projects')); ?>#sidebarAuth4" data-bs-toggle="collapse">
                            <i class="ri-folder-line"></i>
                            <span> Projects </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?php echo e(request()->is('admin/projects') ? 'show' : ''); ?>" id="sidebarAuth4">
                            <ul class="nav-second-level">
                                <li>
                                    <a class='tp-link <?php echo e(request()->is('admin/projects') ? 'active' : ''); ?>' href='<?php echo e(url('admin/projects')); ?>'>View All Projects</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['bill_pdf_download', 'edit_bill', 'view_bill', 'delete_bill'])): ?>
                    <li class="<?php echo e(request()->is('admin/bills*') ? 'menuitem-active' : ''); ?>">
                        <a class="<?php echo e(request()->is('admin/bills') ? 'active' : ''); ?>" href="<?php echo e(url('admin/bills')); ?>#sidebarAuth5" data-bs-toggle="collapse">
                            <i class="ri-file-text-line"></i>
                            <span> Bills </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarAuth5">
                            <ul class="nav-second-level">
                                <li>
                                    <a class='tp-link <?php echo e(request()->is('admin/bills') ? 'active' : ''); ?>' href='<?php echo e(url('admin/bills')); ?>'>View All Bills</a>
                                </li>
                                <li>
                                <a class='tp-link <?php echo e(request()->is('admin/bills/create') ? 'active' : ''); ?>' href='<?php echo e(url('admin/bills/create')); ?>'>Add Bills</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add_expense', 'edit_expense', 'view_expense', 'delete_expense', 'view_expense_category', 'add_expense_category', 'edit_expense_category', 'delete_expense_category'])): ?>
                    <li class="<?php echo e(request()->is('admin/expenses*') ? 'menuitem-active' : ''); ?>">
                        <a class="<?php echo e(request()->is('admin/expenses') ? 'active' : ''); ?>" href="<?php echo e(url('admin/expenses')); ?>#sidebarAuth6" data-bs-toggle="collapse">
                            <i class="ri-archive-line"></i>
                            <span> Expenses </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?php echo e(request()->is('admin/expenses') ? 'show' : ''); ?>" id="sidebarAuth6">
                            <ul class="nav-second-level">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_expense')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/expenses') ? 'active' : ''); ?>' href='<?php echo e(url('admin/expenses')); ?>'>View All Expenses</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_expense_category')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/expenses/category') ? 'active' : ''); ?>' href='<?php echo e(url('admin/expenses/category')); ?>'>Expense Categories</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['income_expense_report', 'income_expense_report_export', 'lead_report', 'lead_report_export', 'client_report', 'client_report_export', 'researcher_report', 'researcher_report_export'])): ?>
                    <li class="<?php echo e(request()->is('admin/reports*') ? 'menuitem-active' : ''); ?>">
                        <a href="index.html#sidebarAuth7" data-bs-toggle="collapse">
                            <i class="ri-book-open-line"></i>
                            <span> Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarAuth7">
                            <ul class="nav-second-level">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('income_expense_report')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/reports/income-expense') ? 'active' : ''); ?>' href='<?php echo e(url('admin/reports/income-expense')); ?>'>Income Expenses</a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead_report')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/reports/lead') ? 'active' : ''); ?>' href='<?php echo e(url('admin/reports/lead')); ?>'>Total Lead</a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client_report')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/reports/client') ? 'active' : ''); ?>' href='<?php echo e(url('admin/reports/client')); ?>'>Total Client</a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('researcher_report')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/reports/researcher') ? 'active' : ''); ?>' href='<?php echo e(url('admin/reports/researcher')); ?>'>Total Research</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['whatsapp_template', 'add_whatsapp_template', 'edit_whatsapp_template', 'view_whatsapp_template', 'delete_whatsapp_template', 'whatsapp_campaign', 'view_whatsapp_campaign', 'delete_whatsapp_campaign', 'today_birthday_whatsapp', 'all_birthday_whatsapp', 'send_birthday_whatsapp', 'today_marraiage_whatsapp', 'all_marraiage_whatsapp', 'send_marraiage_whatsapp', 'today_death_whatsapp', 'all_death_whatsapp', 'send_death_whatsapp', 'whatsapp_campaign_setting', 'whatsapp_api_setting'])): ?>

                    <li class="<?php echo e(request()->is('admin/whatsapp*') ? 'menuitem-active' : ''); ?>">
                        <a class="<?php echo e(request()->is('admin/whatsapp') ? 'active' : ''); ?>" href="<?php echo e(url('admin/whatsapp')); ?>#sidebarBaseui" data-bs-toggle="collapse">
                            <i class="ri-message-3-line"></i>
                            <span> Whatsapp Message </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?php echo e(request()->is('admin/whatsapp*') ? 'show' : ''); ?>" id="sidebarBaseui">
                            <ul class="nav-second-level">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('whatsapp_template')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/whatsapp/template*') ? 'active' : ''); ?>' href='<?php echo e(url('admin/whatsapp/template')); ?>'>View All Template</a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('whatsapp_campaign')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/whatsapp/campaign*') ? 'active' : ''); ?>' href='<?php echo e(url('admin/whatsapp/campaign')); ?>'>WhatsApp Campaign</a>
                                    </li>
                                <?php endif; ?>

                                <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/whatsapp/advertisements') ? 'active' : ''); ?>' href='<?php echo e(url('admin/whatsapp/advertisements')); ?>'>Advertisement </a>
                                    </li>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['today_birthday_whatsapp', 'all_birthday_whatsapp', 'send_birthday_whatsapp'])): ?>
                                    <li>
                                        <a href="#sidebarBaseui1" data-bs-toggle="collapse">
                                            <span> Birthday </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarBaseui1">
                                            <ul class="nav-second-level">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('today_birthday_whatsapp')): ?>
                                                    <li>
                                                        <a class='tp-link' href='<?php echo e(url('admin/whatsapp/birthday/today')); ?>'>Today Birthday</a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('all_birthday_whatsapp')): ?>
                                                    <li>
                                                        <a class='tp-link' href='<?php echo e(url('admin/whatsapp/birthday/all')); ?>'>View All Birthday</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['today_marraiage_whatsapp', 'all_marraiage_whatsapp', 'send_marraiage_whatsapp'])): ?>
                                    <li>
                                        <a href="#sidebarBaseui2" data-bs-toggle="collapse">
                                            <span> Marriage Anniversary </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarBaseui2">
                                            <ul class="nav-second-level">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('today_marraiage_whatsapp')): ?>
                                                    <li>
                                                        <a class='tp-link' href='<?php echo e(url('admin/whatsapp/marriage/today')); ?>'>Today Marriage Anniversary</a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('all_marraiage_whatsapp')): ?>
                                                    <li>
                                                        <a class='tp-link' href='<?php echo e(url('admin/whatsapp/marriage/all')); ?>'>View All Marriage Anniversary</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endif; ?>


                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['today_death_whatsapp', 'all_death_whatsapp', 'send_death_whatsapp'])): ?>
                                    <li>
                                        <a href="#sidebarBaseui3" data-bs-toggle="collapse">
                                            <span> Death Anniversary </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarBaseui3">
                                            <ul class="nav-second-level">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('today_death_whatsapp')): ?>
                                                    <li>
                                                        <a class='tp-link' href='<?php echo e(url('admin/whatsapp/death/today')); ?>'>Today Death Anniversary</a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('all_death_whatsapp')): ?>
                                                    <li>
                                                        <a class='tp-link' href='<?php echo e(url('admin/whatsapp/death/all')); ?>'>View All Death Anniversary</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('whatsapp_api_setting')): ?>
                                    <li>
                                        <a class='tp-link' href='<?php echo e(url('admin/whatsapp/api_settings')); ?>'>API Setting</a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('whatsapp_campaign_setting')): ?>
                                    <li>
                                        <a class='tp-link' href='ui-collapse.html'>Campaign Setting</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add_email_template', 'edit_email_template', 'view_email_template', 'delete_email_template', 'email_campaign', 'view_email_campaign', 'delete_email_campaign', 'view_mass_email', 'today_birthday_email', 'all_birthday_email', 'send_birthday_email', 'today_marraiage_email', 'all_marraiage_email', 'send_marraiage_email', 'today_death_email', 'all_death_email', 'send_death_email'])): ?>


                    <li class="<?php echo e(request()->is('admin/mass-email*') ? 'menuitem-active' : ''); ?>">
                        <a class="<?php echo e(request()->is('admin/mass-email') ? 'active' : ''); ?>" href="<?php echo e(url('admin/mass-email')); ?>#sidebarMail" data-bs-toggle="collapse">
                            <i class="ri-mail-line"></i>
                            <span> Mass Email </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?php echo e(request()->is('admin/mass-email*') ? 'show' : ''); ?>" id="sidebarMail">
                            <ul class="nav-second-level">

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_all_template')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/mass-email/template*') ? 'active' : ''); ?>' href='<?php echo e(url('admin/mass-email/template')); ?>'>View All Template</a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('email_campaign')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/mass-email/campaign') ? 'active' : ''); ?>' href='<?php echo e(url('admin/mass-email/campaign')); ?>'>Mail Campaign</a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_mass_email')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/mass-email/view-email') ? 'active' : ''); ?>' href='<?php echo e(url('admin/mass-email/view-email')); ?>'>View Email</a>
                                    </li>
                                <?php endif; ?>

                                 <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/mass-email/advertisements') ? 'active' : ''); ?>' href='<?php echo e(url('admin/mass-email/advertisements')); ?>'>Advertisement </a>
                                    </li>

                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['today_birthday_email', 'all_birthday_email', 'send_birthday_email'])): ?>
                                    <li>
                                        <a href="#sidebarMail1" data-bs-toggle="collapse">
                                            <span> Birthday </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarMail1">
                                            <ul class="nav-second-level">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('today_birthday_email')): ?>
                                                    <li>
                                                        <a class='tp-link' href='<?php echo e(url('admin/mass-email/birthday/today')); ?>'>Today Birthday</a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('all_birthday_email')): ?>
                                                    <li>
                                                        <a class='tp-link' href='<?php echo e(url('admin/mass-email/birthday/all')); ?>'>View All Birthday</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['today_marraiage_email', 'all_marraiage_email', 'send_marraiage_email'])): ?>
                                    <li>
                                        <a href="#sidebarMail2" data-bs-toggle="collapse">
                                            <span> Marriage Anniversary </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarMail2">
                                            <ul class="nav-second-level">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('today_marraiage_email')): ?>
                                                    <li>
                                                        <a class='tp-link' href='<?php echo e(url('admin/mass-email/marriage/today')); ?>'>Today Marriage Anniversary</a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('all_marraiage_email')): ?>
                                                    <li>
                                                        <a class='tp-link' href='<?php echo e(url('admin/mass-email/marriage/all')); ?>'>View All Marriage Anniversary</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['today_death_email', 'all_death_email', 'send_death_email'])): ?>
                                    <li>
                                        <a href="#sidebarMail3" data-bs-toggle="collapse">
                                            <span> Death Anniversary </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarMail3">
                                            <ul class="nav-second-level">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('today_death_email')): ?>
                                                    <li>
                                                        <a class='tp-link' href='<?php echo e(url('admin/mass-email/death/today')); ?>'>Today Death Anniversary</a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('all_death_email')): ?>
                                                    <li>
                                                        <a class='tp-link' href='<?php echo e(url('admin/mass-email/death/all')); ?>'>View All Death Anniversary</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                

                            </ul>
                        </div>
                    </li>
                <?php endif; ?>



                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_account', 'add_account', 'edit_account', 'delete_account', 'smtp_setup', 'imap_setup'])): ?>
                    <li class="<?php echo e(request()->is('admin/settings/*') ? 'menuitem-active' : ''); ?>">
                        <a class=" <?php echo e(request()->is('admin/settings') ? 'active' : ''); ?>" href="<?php echo e(url('admin/settings')); ?>#sidebarMaps" data-bs-toggle="collapse">
                            <i class="ri-settings-2-line"></i>
                            <span> Settings </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse  <?php echo e(request()->is('admin/settings') ? 'show' : ''); ?>" id="sidebarMaps">
                            <ul class="nav-second-level">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_account')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/settings/accounts') ? 'active' : ''); ?>' href='<?php echo e(url('admin/settings/accounts')); ?>'>Account Setting</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('smtp_setup')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/settings/my-smtp') ? 'active' : ''); ?>' href='<?php echo e(url('admin/settings/my-smtp')); ?>'>SMTP Settings</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('imap_setup')): ?>
                                    <li>
                                        <a class='tp-link <?php echo e(request()->is('admin/settings/my-imap') ? 'active' : ''); ?>' href='<?php echo e(url('admin/settings/my-imap')); ?>'>IMAP Settings</a>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <a class='tp-link <?php echo e(request()->is('admin/settings/address') ? 'active' : ''); ?>' href='<?php echo e(url('admin/settings/address')); ?>'>Address Settings</a>
                                </li>
                                
                                <li>
                                    <a class='tp-link <?php echo e(request()->is('admin/settings/import') ? 'active' : ''); ?>' href='<?php echo e(url('admin/settings/import')); ?>'>Import/Export Data</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['export_csv', 'view_logs'])): ?>

                    <li class="<?php echo e(request()->is('/admin/logs*') ? 'menuitem-active' : ''); ?>">
                        <a class=' <?php echo e(request()->is('/admin/logs') ? 'active' : ''); ?>' href='<?php echo e(url('admin/logs')); ?>'>
                            <i class="ri-history-fill"></i>
                            <span>Activity Logs </span>
                        </a>
                    </li>
                <?php endif; ?>


            </ul>

        </div>
        <!-- End Sidebar -->


        <div class="clearfix"></div>

    </div>
</div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/partials/_sidebar.blade.php ENDPATH**/ ?>