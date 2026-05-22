<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            CountryStateCitySeeder::class,
            PermissionSeeder::class,
            AdminUserSeeder::class,
            ProjectSeeder::class,
            MailSettingSeeder::class,
        ]);
    }
}
