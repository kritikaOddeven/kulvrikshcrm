<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'              => 'Admin',
            'email'             => 'kritikaoddeveninfotech@gmail.com',
            'password'          => Hash::make('12345678'),
            'is_admin'          => true,
            'email_verified_at' => now(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        DB::table('users')->insert([
            'name'              => 'Researcher',
            'email'             => 'kritikaoddeveninfotech+1@gmail.com',
            'password'          => Hash::make('12345678'),
            'is_admin'          => false,
            'email_verified_at' => now(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        DB::table('users')->insert([
            'name'              => 'Ajent',
            'email'             => 'kritikaoddeveninfotech+2@gmail.com',
            'password'          => Hash::make('12345678'),
            'is_admin'          => false,
            'email_verified_at' => now(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // Fetch users and assign roles
        $researcher = User::where('email', 'kritikaoddeveninfotech@gmail.com')->first();
        $researcher = User::where('email', 'kritikaoddeveninfotech+1@gmail.com')->first();
        $agent      = User::where('email', 'kritikaoddeveninfotech+2@gmail.com')->first();
        $admin = User::where('is_admin', true)->first();

        if ($researcher) {
            $researcher->assignRole('researcher');
        }

        if ($agent) {
            $agent->assignRole('agent');
        }

        if ($admin) {
            $admin->assignRole('super-admin');
        }
    }
}
