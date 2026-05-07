# HubFolio — Portfolio de Paul Edwen Elibana Mbadinga

Portfolio personnel futuriste construit avec **Laravel 12**, **Tailwind CSS v4** et **Vite 7**.

---

## Stack technique

| Couche | Technologies |
|---|---|
| Backend | Laravel 12, PHP 8.2+, MySQL, Eloquent ORM |
| Frontend | Tailwind CSS v4, Blade Templates, Vanilla JS |
| Build | Vite 7, Laravel Vite Plugin |
| Auth | Session-based (Laravel Auth) |

---

## Fonctionnalités

**Portfolio public**
- Hero animé — canvas particles interactif, typing effect, avatar flottant
- Section À propos avec valeurs et compteurs animés
- Timeline parcours (formation + expériences)
- Compétences avec barres de progression animées au scroll
- Projets avec filtre par technologie et overlay hover
- Services proposés
- Formulaire de contact avec envoi AJAX et stockage en base
- Design futuriste glassmorphism — palette neon cyan / violet

**Espace admin (protégé)**
- Tableau de bord : stats vues, visiteurs uniques, projets, compétences, messages reçus
- CRUD complet projets (titre, description, technologies, image, liens GitHub/live)
- CRUD compétences par catégorie
- Gestion profil (nom, email, photo, mot de passe)
- Coffre-fort de documents (PDF, images)
- Messages de contact reçus avec statut lu/non lu

---

## Installation

```bash
# 1. Cloner le dépôt
git clone <url-du-repo>
cd mon-site

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JS
npm install

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 5. Configurer la base de données dans .env
DB_DATABASE=hubfolio
DB_USERNAME=root
DB_PASSWORD=

# 6. Migrer et seeder
php artisan migrate --seed

# 7. Lier le stockage public
php artisan storage:link

# 8. Builder les assets
npm run build

# 9. Lancer le serveur (développement)
php artisan serve
```

---

## Développement

```bash
# Lancer Vite en mode watch + serveur Laravel
npm run dev
php artisan serve
```

---

## Structure des fichiers clés

```
app/
├── Http/Controllers/
│   ├── PortfolioController.php   # Page publique + formulaire contact
│   └── AdminController.php       # Toute la partie admin
├── Models/
│   ├── Project.php
│   ├── Skill.php
│   ├── ContactMessage.php        # Messages du formulaire de contact
│   ├── Visit.php
│   └── User.php
└── Services/
    └── AnalyticsService.php

resources/
├── css/app.css                   # Tailwind v4 + utilities custom (glassmorphism, animations)
├── js/app.js                     # Modules JS (particles, typing, scroll-reveal, filtres...)
└── views/
    ├── welcome.blade.php          # Page portfolio (toutes les sections)
    ├── components/
    │   ├── glass-card.blade.php
    │   └── badge.blade.php
    └── admin/
        ├── dashboard.blade.php
        ├── projects.blade.php
        ├── skills.blade.php
        ├── profile.blade.php
        └── documents.blade.php
```

---

## Variables d'environnement importantes

```env
APP_NAME=HubFolio
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hubfolio
DB_USERNAME=root
DB_PASSWORD=
```

---

## Auteur

**Paul Edwen Elibana Mbadinga**  
Développeur Full-Stack — Libreville, Gabon  
[GitHub](https://github.com/Paul-Elibana) · [WhatsApp](https://wa.me/24177519644)

---

> Built with Laravel + Tailwind CSS + ♥
