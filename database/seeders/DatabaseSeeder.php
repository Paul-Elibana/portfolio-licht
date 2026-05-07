<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@hubfolio.test'],
            [
                'name' => 'Paul Edwen',
                'password' => \Illuminate\Support\Facades\Hash::make('Paul2026!'),
            ]
        );

        // Création de compétences

        $skills = [
            ['name' => 'Laravel', 'category' => 'Backend'],
            ['name' => 'PHP 8.4', 'category' => 'Backend'],
            ['name' => 'MySQL', 'category' => 'Backend'],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend'],
            ['name' => 'React', 'category' => 'Frontend'],
            ['name' => 'TypeScript', 'category' => 'Frontend'],
            ['name' => 'Docker', 'category' => 'DevOps'],
            ['name' => 'Vite', 'category' => 'Tools'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }

        // Création de projets
        Project::create([
            'title' => 'Nexus Dashboard',
            'description' => 'Une interface de gestion futuriste avec analytics en temps réel et effets de verre liquide.',
            'technologies' => ['Laravel', 'Tailwind CSS', 'Chart.js'],
            'github_url' => 'https://github.com',
        ]);

        Project::create([
            'title' => 'Cyber-Commerce',
            'description' => 'Plateforme e-commerce haute performance avec système de paiement intégré.',
            'technologies' => ['React', 'Node.js', 'Stripe'],
            'github_url' => 'https://github.com',
        ]);
    }
}
