<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'paoloedwen@gmail.com'],
            [
                'name'     => 'Paul Edwen Elibana Mbadinga',
                'password' => Hash::make('HubFolio2026!'),
            ]
        );

        $skills = [
            ['name' => 'Laravel',      'category' => 'Backend',  'level' => 90],
            ['name' => 'PHP 8.2',      'category' => 'Backend',  'level' => 85],
            ['name' => 'MySQL',        'category' => 'Backend',  'level' => 80],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'level' => 92],
            ['name' => 'Vue.js',       'category' => 'Frontend', 'level' => 75],
            ['name' => 'JavaScript',   'category' => 'Frontend', 'level' => 82],
            ['name' => 'Git',          'category' => 'Tools',    'level' => 85],
            ['name' => 'Vite',         'category' => 'Tools',    'level' => 78],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill['name']], $skill);
        }

        Project::firstOrCreate(
            ['title' => 'HubFolio'],
            [
                'description'  => 'Portfolio personnel full-stack avec dashboard admin, analytics et gestion de contenu dynamique.',
                'technologies' => ['Laravel', 'Tailwind CSS', 'Vite'],
                'github_url'   => 'https://github.com/Paul-Elibana/portfolio-licht',
            ]
        );
    }
}
