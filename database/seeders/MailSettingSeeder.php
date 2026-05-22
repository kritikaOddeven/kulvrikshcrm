<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserSmtpSetting;
use Illuminate\Support\Facades\DB;

class MailSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $settings = [
            [
                'user_id' => 1, 
                'provider' => 'gmail',
                'host' => 'smtp.gmail.com', 
                'port' => 587, 
                'username' => 'kritikaoddeveninfotech@gmail.com', 
                'password' => 'tuqz ptcf lkmh lnsf', 
                'encryption' => 'tls', 
                'from_address' => 'noreply@kulvriksh.com', 
                'from_name' => 'Kulvriksh',
                'is_active' => true
            ],
        ];

        foreach ($settings as $setting) {
            UserSmtpSetting::updateOrCreate(
                ['user_id' => $setting['user_id']], // unique constraint
                $setting
            );
        }
    }
}
