<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Project;
use App\Models\Service;
use App\Models\TimelineEntry;
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
            ['name' => 'PHP 8.2',      'category' => 'Backend',  'level' => 88],
            ['name' => 'MySQL',        'category' => 'Backend',  'level' => 82],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'level' => 92],
            ['name' => 'Vue.js',       'category' => 'Frontend', 'level' => 78],
            ['name' => 'JavaScript',   'category' => 'Frontend', 'level' => 85],
            ['name' => 'Git',          'category' => 'Tools',    'level' => 85],
            ['name' => 'Vite',         'category' => 'Tools',    'level' => 80],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill['name']], $skill);
        }

        $timelineEntries = [
            ['sort_order' => 0, 'icon' => '🚀', 'type' => 'exp', 'date_label' => '2024 — Présent',  'title' => 'Développeur Full-Stack Freelance',  'organization' => 'Indépendant — Libreville & International', 'description' => 'Conception et développement d\'applications web sur mesure pour des clients locaux et internationaux. Stack principal : Laravel, Vue.js, Tailwind CSS, MySQL.'],
            ['sort_order' => 1, 'icon' => '🎓', 'type' => 'edu', 'date_label' => '2022 — 2024',     'title' => 'Licence en Informatique',             'organization' => 'Université Omar Bongo — Libreville',        'description' => 'Spécialisation en développement logiciel et systèmes d\'information. Projet de fin d\'études : plateforme de gestion académique en Laravel.'],
            ['sort_order' => 2, 'icon' => '💼', 'type' => 'exp', 'date_label' => '2023',             'title' => 'Développeur Stagiaire',               'organization' => 'Agence Digitale — Libreville',              'description' => 'Participation au développement de sites web pour des entreprises gabonaises. Apprentissage des méthodes agiles et des bonnes pratiques en équipe.'],
            ['sort_order' => 3, 'icon' => '📚', 'type' => 'edu', 'date_label' => '2021 — 2022',     'title' => 'BTS Développement Web & Mobile',      'organization' => 'Institut Supérieur de Technologie — Libreville', 'description' => 'Fondamentaux du développement web (HTML, CSS, JavaScript, PHP). Premier contact avec les frameworks modernes.'],
            ['sort_order' => 4, 'icon' => '⚡', 'type' => 'edu', 'date_label' => '2021',             'title' => 'Autodidacte & Certification',          'organization' => 'OpenClassrooms / FreeCodeCamp',             'description' => 'Parcours d\'apprentissage intensif en développement web. Certifications en JavaScript, React et UX Design.'],
        ];

        foreach ($timelineEntries as $entry) {
            TimelineEntry::firstOrCreate(
                ['title' => $entry['title'], 'date_label' => $entry['date_label']],
                $entry
            );
        }

        Project::firstOrCreate(
            ['title' => 'HubFolio'],
            [
                'description'  => 'Portfolio personnel full-stack avec dashboard admin, analytics et gestion de contenu dynamique.',
                'technologies' => ['Laravel', 'Tailwind CSS', 'Vite'],
                'github_url'   => 'https://github.com/Paul-Elibana/portfolio-licht',
            ]
        );

        $services = [
            [
                'sort_order'  => 0,
                'title'       => 'Développement Full-Stack',
                'description' => 'Conception et développement d\'applications web complètes, de la base de données à l\'interface utilisateur. Expertise Laravel, PHP, MySQL, Vue.js et API REST.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>',
                'color'       => 'primary',
                'tags'        => ['Laravel', 'PHP', 'Vue.js', 'MySQL'],
            ],
            [
                'sort_order'  => 1,
                'title'       => 'Design UI/UX Moderne',
                'description' => 'Création d\'interfaces utilisateurs soignées, intuitives et accessibles. Du wireframe à la mise en production, avec un focus sur l\'expérience utilisateur.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>',
                'color'       => 'secondary',
                'tags'        => ['Figma', 'Tailwind', 'Responsive'],
            ],
            [
                'sort_order'  => 2,
                'title'       => 'Conseil & Architecture',
                'description' => 'Audit technique de vos projets existants, recommandations d\'architecture, optimisation des performances et accompagnement dans vos choix technologiques.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
                'color'       => 'primary',
                'tags'        => ['Audit', 'Optimisation', 'Conseil'],
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['title' => $service['title']], $service);
        }
    }
}
