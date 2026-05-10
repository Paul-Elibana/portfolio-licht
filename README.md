# HubFolio — Portfolio Full-Stack

Portfolio personnel de **Paul Edwen Elibana Mbadinga**, développeur Full-Stack basé à Libreville, Gabon.

---

## Stack technique complète

### Back-end
| Technologie | Rôle | Pourquoi |
|---|---|---|
| **Laravel 12** | Framework PHP principal | Structure MVC, routing, ORM Eloquent, middleware, validations — productivité maximale |
| **PHP 8.2** | Langage serveur | Typage strict, performance améliorée (JIT), fibers, enums |
| **MySQL** | Base de données relationnelle | Gestion des projets, compétences, messages, timeline, services, visites |
| **Eloquent ORM** | Abstraction base de données | Requêtes lisibles, relations, casts automatiques (JSON, boolean) |
| **Laravel Blade** | Moteur de templates | Composants réutilisables (`x-badge`, `x-glass-card`), directives `@foreach`, `@if` |
| **Intervention Image 3** | Traitement d'images PHP | Redimensionnement, recadrage, conversion WebP côté serveur après upload |

### Front-end
| Technologie | Rôle | Pourquoi |
|---|---|---|
| **Tailwind CSS v4** | Utility-first CSS | Rapidité de prototypage, design system cohérent, dark theme natif |
| **Vite** | Bundler / build tool | HMR ultrarapide en dev, chunks optimisés en prod, intégration Laravel native |
| **Vanilla JS** | Interactions UI | Particles canvas, typing effect, scroll reveal, filtres projets — sans framework lourd |
| **Cropper.js 1.6** | Recadrage d'images interactif | Modal de recadrage côté client avant upload (profil, projets) — aucun aller-serveur inutile |
| **PDF.js 3.11** | Rendu PDF côté client | Aperçu miniature de la première page des certifications PDF (portfolio + admin) |
| **SortableJS** | Drag-and-drop | Réorganisation de la timeline et des entrées de parcours dans l'admin |
| **QRCode.js** | Génération QR Code | QR code dynamique sur la carte de visite pointant vers le portfolio |

### Infrastructure & déploiement
| Technologie | Rôle | Pourquoi |
|---|---|---|
| **Railway.app** | Hébergement cloud | Déploiement automatique depuis GitHub, base MySQL incluse, HTTPS gratuit |
| **Docker** (php:8.2-fpm-alpine) | Containerisation | Environnement reproductible, image légère (~150 Mo), build isolé |
| **Nginx** | Serveur web | Sert les assets statiques directement (×10 plus rapide que `php artisan serve`) |
| **PHP-FPM** | Process manager PHP | Gestion des workers PHP, performances en production |
| **Supervisor** | Gestionnaire de processus | Maintient nginx + php-fpm actifs et les redémarre automatiquement |
| **Composer** | Gestionnaire de dépendances PHP | Autoload PSR-4, packages Laravel/Intervention |
| **npm** | Gestionnaire de dépendances JS | Build Tailwind + Vite en production |

### Extensions PHP compilées
| Extension | Utilité |
|---|---|
| `pdo` + `pdo_mysql` | Connexion MySQL via PDO |
| `gd` | Traitement d'images (Intervention Image) — libpng, libjpeg-turbo, freetype |
| `intl` | Internationalisation, formatage des nombres/dates — icu-libs |
| `bcmath` | Calculs précis (analytics, compteurs) |
| `opcache` | Cache du bytecode PHP — performances production |
| `fileinfo` | Détection du type MIME réel des fichiers uploadés |

### Services externes
| Service | Rôle |
|---|---|
| **Gmail SMTP** (App Password) | Notifications email à la réception d'un message de contact |
| **Cloudflare CDN** (via Railway) | Cache et compression automatiques |

---

## Fonctionnalités

### Portfolio public (`/`)
- Hero animé : canvas particles vanilla JS, typing effect, avatar flottant
- Section À propos : bio, valeurs, compteurs animés
- Timeline Parcours : formations & expériences depuis la DB, drag-and-drop dans l'admin
- Compétences : barres de progression animées au scroll (Intersection Observer)
- Projets : filtre JS par technologie, cards avec overlay et liens
- Services : gestion complète depuis l'admin
- Formulaire de contact : stockage DB + notification Gmail optionnelle
- Carte de visite imprimable (`/carte`) avec QR code

### Dashboard admin (`/admin`)
- **Tableau de bord** : stats visiteurs, messages non lus, accès rapides
- **Profil** : photo (avec recadrage Cropper.js), coordonnées publiques, statut de disponibilité
- **Projets** : CRUD + upload image avec recadrage 16:9
- **Compétences** : ajout/suppression, niveau (%) modifiable par slider
- **Parcours** : CRUD formations & expériences, réorganisation drag-and-drop
- **Services** : CRUD complet avec icône SVG, couleur, tags
- **Assets du site** : images hero, illustration, background, certifications (PDF avec aperçu miniature via PDF.js)
- **Messages** : liste avec aperçu modal, marquer comme lu
- **Maintenance** : reset visites / messages

---

## Installation locale

```bash
git clone https://github.com/Paul-Elibana/portfolio-licht.git
cd portfolio-licht

composer install
npm install

cp .env.example .env
php artisan key:generate

# Configurer DB_* dans .env
php artisan migrate --seed
php artisan storage:link

npm run dev
php artisan serve
```

---

## Déploiement Railway

Railway détecte automatiquement le `Dockerfile` (nginx + php-fpm) et build l'image.

**Variables d'environnement Railway requises :**
```
APP_ENV=production
APP_KEY=base64:...
APP_URL=https://votre-app.railway.app

DB_HOST=mysql.railway.internal
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=...

SESSION_DRIVER=database
```

**Activer les notifications Gmail (optionnel) :**
1. Compte Google → Sécurité → Validation en 2 étapes (activer)
2. Sécurité → Mots de passe des applications → Créer "HubFolio"
3. Ajouter dans Railway :
```
MAIL_MAILER=smtp
MAIL_SCHEME=ssl
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=paoloedwen@gmail.com
MAIL_PASSWORD=xxxx_xxxx_xxxx_xxxx
MAIL_FROM_ADDRESS=paoloedwen@gmail.com
MAIL_FROM_NAME=HubFolio
```

---

## Structure principale

```
app/
├── Http/Controllers/
│   ├── AdminController.php      CRUD admin complet + traitement images
│   └── PortfolioController.php  Pages publiques + envoi contact
├── Mail/
│   └── NewContactMessage.php    Notification email contact
├── Models/
│   ├── User.php                 + coordonnées publiques + disponibilité
│   ├── Skill.php                + level (%)
│   ├── TimelineEntry.php        Parcours (formations/expériences)
│   ├── Service.php              Services proposés
│   ├── ContactMessage.php       Messages reçus via formulaire
│   └── PublicDocument.php       Assets (hero, profil, background...)
├── Services/
│   └── AnalyticsService.php     Tracking visites uniques
docker/
├── nginx.conf                   Assets statiques servis directement
├── supervisord.conf             nginx + php-fpm supervisés
└── start.sh                     migrate/seed + démarrage serveurs
public/
└── images/default-avatar.svg    Avatar par défaut (affiché si aucune photo uploadée)
resources/views/
├── welcome.blade.php            Portfolio public (toutes sections)
├── public/carte.blade.php       Carte de visite imprimable
├── admin/
│   ├── dashboard/profile/skills/projects/services
│   └── timeline/ (index/create/edit)
└── layouts/admin.blade.php      Layout admin + modal Cropper.js
```

---

## Démo

**URL :** `https://portfolio-licht-production.up.railway.app`
**Admin :** `/login` → `paoloedwen@gmail.com`
