# HubFolio — Portfolio Full-Stack

Portfolio personnel de **Paul Edwen Elibana Mbadinga**, développeur Full-Stack basé à Libreville, Gabon.

**Stack :** Laravel 12 · PHP 8.2 · Tailwind CSS v4 · Vite · MySQL · Blade

---

## Démo en ligne

**URL :** `https://portfolio-licht-production.up.railway.app`
**Admin :** `/login` → `paoloedwen@gmail.com`

---

## Fonctionnalités

### Portfolio public
- Hero animé (canvas particles, typing effect, avatar flottant)
- Section À propos + valeurs
- Timeline Parcours (formations & expériences dynamiques)
- Compétences avec barres de progression animées
- Projets avec filtres par technologie
- Services proposés
- Formulaire de contact (stockage DB + notification email optionnelle)
- Carte de visite imprimable (`/carte`)

### Dashboard admin
- Statistiques visiteurs (vues totales, visiteurs uniques)
- **Profil** : photo, coordonnées publiques (email, téléphone, GitHub, LinkedIn, localisation), statut de disponibilité éditable
- **Projets** : CRUD complet avec upload image et prévisualisation instantanée
- **Compétences** : ajout/suppression, niveau (%) modifiable par slider
- **Parcours** : CRUD formations & expériences, réorganisation par drag-and-drop
- **Assets du site** : images hero, profil, illustration, background, certifications
- **Messages** : liste avec aperçu modal au clic, marquer comme lu
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
│   ├── AdminController.php      CRUD admin complet
│   └── PortfolioController.php  Pages publiques
├── Mail/
│   └── NewContactMessage.php    Notification email contact
├── Models/
│   ├── User.php                 + coordonnées publiques + disponibilité
│   ├── Skill.php                + level (%)
│   ├── TimelineEntry.php        Parcours
│   ├── ContactMessage.php
│   └── PublicDocument.php       Assets (hero, profil, background, certification...)
docker/
├── nginx.conf / supervisord.conf / start.sh
resources/views/
├── welcome.blade.php            Portfolio public
├── admin/
│   ├── dashboard / profile / skills / projects
│   └── timeline/  (index / create / edit)
└── emails/contact-notification.blade.php
```
