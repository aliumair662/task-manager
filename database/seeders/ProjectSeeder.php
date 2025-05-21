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
        $projects = [
            'Website Redesign',
            'Mobile App Development',
            'Marketing Campaign',
            'Customer Support',
            'New Product Launch'
        ];

        foreach ($projects as $projectName) {
            Project::create(['name' => $projectName]);
        }
    }
}
