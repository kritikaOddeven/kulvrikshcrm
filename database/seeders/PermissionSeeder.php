<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'add_agent', 'section' => 'agent'],
            ['name' => 'edit_agent', 'section' => 'agent'],
            ['name' => 'view_agent', 'section' => 'agent'],
            ['name' => 'delete_agent', 'section' => 'agent'],

            ['name' => 'add_role', 'section' => 'role'],
            ['name' => 'edit_role', 'section' => 'role'],
            // ['name' => 'view_role', 'section' => 'role'],
            ['name' => 'delete_role', 'section' => 'role'],
            ['name' => 'assign_permission', 'section' => 'role'],

            ['name' => 'add_lead', 'section' => 'lead'],
            ['name' => 'edit_lead', 'section' => 'lead'],
            ['name' => 'view_lead', 'section' => 'lead'],
            ['name' => 'preview_lead', 'section' => 'lead'],
            ['name' => 'delete_lead', 'section' => 'lead'],
            ['name' => 'convert_to_client', 'section' => 'lead'],
            ['name' => 'send_lead_email', 'section' => 'lead'],
            ['name' => 'send_lead_whatsapp', 'section' => 'lead'],

            ['name' => 'add_client', 'section' => 'client'],
            ['name' => 'edit_client', 'section' => 'client'],
            ['name' => 'view_client', 'section' => 'client'],
            ['name' => 'preview_client', 'section' => 'client'],
            ['name' => 'delete_client', 'section' => 'client'],
            ['name' => 'generate_bill', 'section' => 'client'],
            ['name' => 'assign_researcher', 'section' => 'client'],
            ['name' => 'send_client_email', 'section' => 'client'],
            ['name' => 'send_client_whatsapp', 'section' => 'client'],

            ['name' => 'view_researcher', 'section' => 'researcher'],
            ['name' => 'researcher_edit_client', 'section' => 'researcher'],
            ['name' => 'delete_researcher', 'section' => 'researcher'],

            ['name' => 'view_researcher_report', 'section' => 'researcher_report'],
            ['name' => 'download_researcher_report', 'section' => 'researcher_report'],
            ['name' => 'delete_researcher_report', 'section' => 'researcher_report'],
            ['name' => 'preview_researcher_report', 'section' => 'researcher_report'],
            ['name' => 'send_researcher_report_email', 'section' => 'researcher_report'],
            ['name' => 'send_researcher_report_whatsapp', 'section' => 'researcher_report'],
            ['name' => 'fill_researcher_report_form', 'section' => 'researcher_report'],
            ['name' => 'archive_report', 'section' => 'researcher_report'],
            ['name' => 'download_archive_report', 'section' => 'researcher_report'],
            ['name' => 'view_archive_report', 'section' => 'researcher_report'],
            ['name' => 'delete_archive_report', 'section' => 'researcher_report'],
            

            ['name' => 'add_project', 'section' => 'project'],
            ['name' => 'edit_project', 'section' => 'project'],
            ['name' => 'view_project', 'section' => 'project'],
            ['name' => 'delete_project', 'section' => 'project'],

            ['name' => 'add_sub_project', 'section' => 'project'],
            ['name' => 'edit_sub_project', 'section' => 'project'],
            ['name' => 'delete_sub_project', 'section' => 'project'],

            // ['name' => 'add_bill', 'section' => 'bill'],
            ['name' => 'edit_bill', 'section' => 'bill'],
            ['name' => 'view_bill', 'section' => 'bill'],
            ['name' => 'bill_pdf_download', 'section' => 'bill'],
            ['name' => 'send_bill_email', 'section' => 'bill'],
            ['name' => 'delete_bill', 'section' => 'bill'],

            ['name' => 'add_expense', 'section' => 'expense'],
            ['name' => 'edit_expense', 'section' => 'expense'],
            ['name' => 'view_expense', 'section' => 'expense'],
            ['name' => 'delete_expense', 'section' => 'expense'],

            ['name' => 'view_expense_category', 'section' => 'expense'],
            ['name' => 'add_expense_category', 'section' => 'expense'],
            ['name' => 'edit_expense_category', 'section' => 'expense'],
            ['name' => 'delete_expense_category', 'section' => 'expense'],

            ['name' => 'income_expense_report', 'section' => 'report'],
            ['name' => 'income_expense_report_export', 'section' => 'report'],
            ['name' => 'lead_report', 'section' => 'report'],
            ['name' => 'lead_report_export', 'section' => 'report'],
            ['name' => 'client_report', 'section' => 'report'],
            ['name' => 'client_report_export', 'section' => 'report'],
            ['name' => 'researcher_report', 'section' => 'report'],
            ['name' => 'researcher_report_export', 'section' => 'report'],

            ['name' => 'whatsapp_template', 'section' => 'whatsapp message'],
            ['name' => 'add_whatsapp_template', 'section' => 'whatsapp message'],
            ['name' => 'edit_whatsapp_template', 'section' => 'whatsapp message'],
            ['name' => 'view_whatsapp_template', 'section' => 'whatsapp message'],
            ['name' => 'delete_whatsapp_template', 'section' => 'whatsapp message'],
            ['name' => 'whatsapp_campaign', 'section' => 'whatsapp message'],
            ['name' => 'view_whatsapp_campaign', 'section' => 'whatsapp message'],
            ['name' => 'delete_whatsapp_campaign', 'section' => 'whatsapp message'],
            ['name' => 'today_birthday_whatsapp', 'section' => 'whatsapp message'],
            ['name' => 'all_birthday_whatsapp', 'section' => 'whatsapp message'],
            ['name' => 'send_birthday_whatsapp', 'section' => 'whatsapp message'],
            ['name' => 'today_marraiage_whatsapp', 'section' => 'whatsapp message'],
            ['name' => 'all_marraiage_whatsapp', 'section' => 'whatsapp message'],
            ['name' => 'send_marraiage_whatsapp', 'section' => 'whatsapp message'],
            ['name' => 'today_death_whatsapp', 'section' => 'whatsapp message'],
            ['name' => 'all_death_whatsapp', 'section' => 'whatsapp message'],
            ['name' => 'send_death_whatsapp', 'section' => 'whatsapp message'],
            ['name' => 'whatsapp_api_setting', 'section' => 'whatsapp message'],
            ['name' => 'whatsapp_campaign_setting', 'section' => 'whatsapp message'],

            ['name' => 'view_all_template', 'section' => 'mass email'],
            ['name' => 'add_email_template', 'section' => 'mass email'],
            ['name' => 'edit__email_template', 'section' => 'mass email'],
            ['name' => 'view_email_template', 'section' => 'mass email'],
            ['name' => 'delete_email_template', 'section' => 'mass email'],
            ['name' => 'email_campaign', 'section' => 'mass email'],
            ['name' => 'view_email_campaign', 'section' => 'mass email'],
            ['name' => 'delete_email_campaign', 'section' => 'mass email'],
            ['name' => 'view_mass_email', 'section' => 'mass email'],
            ['name' => 'today_birthday_email', 'section' => 'mass email'],
            ['name' => 'all_birthday_email', 'section' => 'mass email'],
            ['name' => 'send_birthday_email', 'section' => 'mass email'],
            ['name' => 'today_marraiage_email', 'section' => 'mass email'],
            ['name' => 'all_marraiage_email', 'section' => 'mass email'],
            ['name' => 'send_marraiage_email', 'section' => 'mass email'],
            ['name' => 'today_death_email', 'section' => 'mass email'],
            ['name' => 'all_death_email', 'section' => 'mass email'],
            ['name' => 'send_death_email', 'section' => 'mass email'],

            ['name' => 'view_account', 'section' => 'settings'],
            ['name' => 'add_account', 'section' => 'settings'],
            ['name' => 'edit_account', 'section' => 'settings'],
            ['name' => 'delete_account', 'section' => 'settings'],
            ['name' => 'smtp_setup', 'section' => 'settings'],
            ['name' => 'imap_setup', 'section' => 'settings'],
            
            // Address Settings Permissions
            ['name' => 'view_address_settings', 'section' => 'settings'],
            ['name' => 'add_country', 'section' => 'settings'],
            ['name' => 'edit_country', 'section' => 'settings'],
            ['name' => 'delete_country', 'section' => 'settings'],
            ['name' => 'add_state', 'section' => 'settings'],
            ['name' => 'edit_state', 'section' => 'settings'],
            ['name' => 'delete_state', 'section' => 'settings'],
            ['name' => 'add_district', 'section' => 'settings'],
            ['name' => 'edit_district', 'section' => 'settings'],
            ['name' => 'delete_district', 'section' => 'settings'],
            ['name' => 'add_city', 'section' => 'settings'],
            ['name' => 'edit_city', 'section' => 'settings'],
            ['name' => 'delete_city', 'section' => 'settings'],
            ['name' => 'add_taluka', 'section' => 'settings'],
            ['name' => 'edit_taluka', 'section' => 'settings'],
            ['name' => 'delete_taluka', 'section' => 'settings'],
            ['name' => 'add_village', 'section' => 'settings'],
            ['name' => 'edit_village', 'section' => 'settings'],
            ['name' => 'delete_village', 'section' => 'settings'],

            ['name' => 'export_csv', 'section' => 'activity_log'],
            ['name' => 'view_logs', 'section' => 'activity_log'],

            ['name' => 'view_profile', 'section' => 'profile'],
            ['name' => 'update_profile', 'section' => 'profile'],
            ['name' => 'update_password', 'section' => 'profile'],

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Super Admin
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        Role::firstOrCreate(['name' => 'researcher']);
        Role::firstOrCreate(['name' => 'agent']);

        $allPermissions = Permission::all();
        $superAdminRole->syncPermissions($allPermissions);

    }
}
