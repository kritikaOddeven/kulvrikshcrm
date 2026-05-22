<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Main Puja Event
        $mainPuja = Project::create([
            'name' => 'Durga Puja 2025',
            'description' => 'Annual Durga Puja organized by the temple committee.',
            'status' => 'active',
            'amount' => '150000',
        ]);

        // Child Projects under Durga Puja
        Project::create([
            'project_id' => $mainPuja->id,
            'name' => 'Pandal Decoration',
            'description' => 'Decorating the pandal with lights, flowers, and banners.',
            'status' => 'active',
            'amount' => '40000',
        ]);

        Project::create([
            'project_id' => $mainPuja->id,
            'name' => 'Cultural Program',
            'description' => 'Organizing dance, music, and drama for 4 days.',
            'status' => 'active',
            'amount' => '25000',
        ]);

        Project::create([
            'project_id' => $mainPuja->id,
            'name' => 'Food Distribution (Bhog)',
            'description' => 'Arranging bhog for 2000+ devotees for 5 days.',
            'status' => 'active',
            'amount' => '30000',
        ]);

        // Another main Puja
        $secondaryPuja = Project::create([
            'name' => 'Saraswati Puja 2025',
            'description' => 'One-day Saraswati Puja for students.',
            'status' => 'active',
            'amount' => '20000',
        ]);

        Project::create([
            'project_id' => $secondaryPuja->id,
            'name' => 'Puja Setup',
            'description' => 'Setting up idol, stage, and priest arrangements.',
            'status' => 'active',
            'amount' => '10000',
        ]);

        Project::create([
            'project_id' => $secondaryPuja->id,
            'name' => 'Student Prasad Distribution',
            'description' => 'Distributing prasad and books to students.',
            'status' => 'active',
            'amount' => '7000',
        ]);
    }
}
