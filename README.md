# PoC OC 10 : Plateforme d'évaluation et recommandation pour hébergements

## Description et objectif du PoC

Ce projet est un Proof of Concept (PoC) visant à démontrer la faisabilité technique d'un outil de captation de leads pour des propriétaires d'hébergements (gîtes, hôtels, chambres d'hôtes). L'objectif est de permettre aux utilisateurs d'évaluer gratuitement le potentiel de leur hébergement via un formulaire simple. En retour, la plateforme traite ces données et propose dynamiquement une recommandation personnalisée parmi 3 offres : **Essentiel**, **Réservation directe**, ou **Acquisition**.

Le projet est divisé en deux parties strictement découplées :

- **Frontend** : Une Single Page Application (SPA) ultra-rapide en Vue 3 (Vite, Pinia, Router), sans SSR.
- **Backend** : Une API REST légère en PHP 8.3 Vanilla et MySQL.

---

## ⚙️ Prérequis

- **Node.js** (Version `>= 22.18.0` ou `>= 24.12.0`)
- **Serveur local PHP/MySQL** (ex: [Laragon](https://laragon.org/), XAMPP, MAMP ou PHP CLI natif)
- **PHP** (Version `8.3`)
- **MySQL / MariaDB** (Version testée : `10.2.44-MariaDB`)
- **Composer** (Optionnel, recommandé pour l'outil de tests PHPUnit)

---

## 🛠️ Installation et lancement pas à pas

### 1. Base de données (Backend)

1. Démarrez votre serveur local (Laragon).
2. Via votre gestionnaire (phpMyAdmin), créez une base de données nommée `poc_hebergements`.
3. Importez le script `backend/sql/init.sql` pour générer les tables.
4. Renseignez vos identifiants locaux dans le fichier `backend/config/config.php`.

### 2. Lancement de l'API (Backend)

Placez le dossier du projet dans votre répertoire web (ex: `C:\laragon\www\poc-oc-10`) et accédez à l'URL locale. Alternativement, utilisez le serveur interne de PHP :

```bash
cd backend
php -S 127.0.0.1:8000
```

L'API sera à l'écoute sur http://localhost:8000.

### Lancement de l'application Vue.js (Frontend)

Ouvrez un terminal à la racine du dossier de projet :

```bash
bun install
bun run dev
```

Ouvrez le lien fourni par Vite (généralement http://localhost:5173).

---

## Arborescence et architecture

### Structure frontend (Vue 3)

```
/frontend
├── .htaccess               # Règles CORS
├── index.html
├── src/
│   ├── components/
│   │   └── Gites.vue       # Composant métier principal (Formulaire + Requêtes)
│   ├── router/
│   │   └── index.ts        # Routes avec meta: { title, description }
│   ├── stores/             # Gestion de l'état avec Pinia
│   └── main.ts             # Initialisation + Hook router.beforeEach (MAJ SEO)
└── package.json
```

### Structure backend (PHP 8.3 vanilla)

```
/backend
├── .htaccess               # Front Controller API et règles CORS
├── index.php               # Routeur principal de l'API
├── config.php
├── config/
│   ├── .htaccess           # Blocage du dossier par url
│   └── config.php
├── controllers/
│   └── api/
│       └── audit.php       # Endpoint de traitement des leads
├── models/
├── sql/
│   └── init.sql            # Table prospects (id, nom, url, email, reco...)
└── tests/
```

---

## Scénario de test et interactions (Front / Back)

Pour valider l'intégration technique du PoC :

1. Page pilote & SEO (Front) : Accédez à la vue /gites. Vérifiez dans le code source que le routeur a bien injecté la balise <title> : "Création de site internet pour gîte" et les balises <meta name="description"> orientées sur la rentabilité et les réservations directes.

2. Évaluation (Front) : Sur le composant Gites.vue, remplissez le formulaire avec un nom, une url et un email. Cliquez sur le CTA "Évaluer gratuitement le potentiel de mon hébergement".

3. Envoi asynchrone : Le composant utilise Fetch/Axios pour envoyer les données saisies via une requête HTTP POST asynchrone (au format JSON) vers api/audit.php.

4. Traitement (Back) : L'endpoint PHP récupère et assainit les données. Il simule un score d'audit, détermine une recommandation personnalisée (Essentiel, Réservation directe, Acquisition), stocke la demande dans la base MySQL (table prospects), et retourne une réponse JSON (succès, recommandation).

5. Feedback visuel (Front) : À la réception de la réponse, l'interface Vue.js se met à jour dynamiquement et affiche la recommandation sans aucun rechargement de page.

---

## Qualité et Tests Automatisés

**Tests Frontend :**

- Tests unitaires et composants avec Vitest : npm run test:unit (Couverture : npm run test:unit --coverage)

- Tests End-to-End (E2E) avec Playwright : npx playwright test

**Tests Backend :**

- Tests unitaires avec PHPUnit : ./vendor/bin/phpunit tests (Couverture : ./vendor/bin/phpunit --coverage-text)

---

## Dépendances obligatoires

### Frontend (frontend/package.json)

- **Dépendances de production :**
  - vue : Core framework (v3).

  - vue-router : Gestion des routes et injection dynamique des méta-balises SEO.

  - pinia : Store pour la gestion d'état centralisée.

**Les requêtes vers le backend utiliseront l'API Fetch native de JS**.

- **Dépendances de développement :**
  - vite & @vitejs/plugin-vue : Serveur de dev et bundler.

  - typescript : Typage du code.

  - vitest & @vue/test-utils : Tests unitaires.

  - @playwright/test : Tests End-to-End.

**Commande d'installation frontend (racine du projet) :**

```bash
bun install -D @playwright/test
```

### Backend (backend/composer.json)

- **Dépendance de production :**
  - vlucas/phpdotenv : Permet de lire le fichier .env en PHP Vanilla.

- **Dépendance de développement :**
  - phpunit/phpunit : Suite de tests unitaires pour l'API.

Commande d'installation backend :

```bash
cd backend
composer require vlucas/phpdotenv
composer require --dev phpunit/phpunit
```

---

## Configuration ENV

### frontend/.env

```
VITE_API_BASE_URL=http://localhost:VOTRE_PORT/backend
```

### frontend/.env.example

```
VITE_API_BASE_URL=http://localhost:VOTRE_PORT/backend
```

### backend/.env

```
DB_HOST=VOTRE_HOST
DB_PORT=VOTRE_PORT
DB_NAME=VOTRE_NOM_DE_BDD
DB_USER=VOTRE_USERNAME
DB_PASS=VOTRE_PASSWORD # ou vide si pas de password en local
APP_ENV=local # ou prod
```

### backend/.env.example

```
DB_HOST=VOTRE_HOST
DB_PORT=VOTRE_PORT
DB_NAME=VOTRE_NOM_DE_BDD
DB_USER=VOTRE_USERNAME
DB_PASS=VOTRE_PASSWORD # ou vide si pas de password en local
APP_ENV=local # ou prod
```

### Backend : Chargement du .env (backend/config/config.php)

Le package `phpdotenv` permet de charger les variables globales sans exposer les identifiants dans le code.

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Chargement des variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$dbHost = $_ENV['DB_HOST'] ?? 'VOTRE_HOST';
$dbPort = $_ENV['DB_PORT'] ?? 'VOTRE_PORT';
$dbName = $_ENV['DB_NAME'] ?? 'VOTRE_NOM_De_BDD';
$dbUser = $_ENV['DB_USER'] ?? 'VOTRE_USERNAME';
$dbPass = $_ENV['DB_PASS'] ?? 'VOTRE_MOT_DE_PASSE';

try {
    $pdo = new PDO(
        "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}
```

---

## Configuration serveur apache (.htaccess)

### .htaccess - Frontend (à placer dans /dist après le build)

```apache
RewriteEngine On
RewriteCond %{HTTPS} !=on
RewriteRule .* https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]

# Routage SPA Vue.js
RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]
RewriteRule ^[^.]+$ index.html [L]

Header always set Permissions-Policy "payment=(self \"[https://js.stripe.com](https://js.stripe.com)\")"
Header always set Strict-Transport-Security "max-age=63072000; includeSubDomains; preload" env=HTTPS
Options -Indexes

<Files "app-ads.txt">
    ForceType text/plain
</Files>

# Mod Deflate (Compression)
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE application/javascript application/rss+xml application/vnd.ms-fontobject application/x-font application/x-font-opentype application/x-font-otf application/x-font-truetype application/x-font-ttf application/x-javascript application/xhtml+xml application/xml font/opentype font/otf font/ttf image/svg+xml image/x-icon text/css text/html text/javascript text/plain text/xml
  BrowserMatch ^Mozilla/4 gzip-only-text/html
  BrowserMatch ^Mozilla/4\.0[678] no-gzip
  BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
  Header append Vary User-Agent
</IfModule>
Header append Vary User-Agent env=!dont-vary

# Gestion du Cache
<IfModule mod_headers.c>
  Header unset Cache-Control
  Header unset Expires
  Header unset Pragma

  <FilesMatch "^(index\.html|manifest\.json)$">
    Header set Cache-Control "no-cache, must-revalidate"
    Header set Pragma "no-cache"
    Header set Expires "0"
  </FilesMatch>

  <FilesMatch "\.(ico|pdf|flv|jpg|jpeg|png|gif|webp|svg|woff|woff2|ttf|otf|mp4|webm|css|js)$">
    Header set Cache-Control "public, max-age=31536000, immutable"
  </FilesMatch>

  Header always set X-FRAME-OPTIONS "SAMEORIGIN"
  Header always set X-Content-Type-Options "nosniff"
</IfModule>
```

### .htaccess - Backend (à placer dans /backend)

```apache
RewriteEngine On
RewriteCond %{HTTPS} !=on
RewriteRule .* https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]

# Front Controller API
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^[^.]+$ index.php [L]

Header always set Strict-Transport-Security "max-age=63072000; includeSubDomains; preload" env=HTTPS
Options -Indexes

# Mod Deflate (Compression API)
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE application/javascript application/rss+xml application/vnd.ms-fontobject application/x-font application/x-font-opentype application/x-font-otf application/x-font-truetype application/x-font-ttf application/x-javascript application/xhtml+xml application/xml font/opentype font/otf font/ttf image/svg+xml image/x-icon text/css text/html text/javascript text/plain text/xml
  BrowserMatch ^Mozilla/4 gzip-only-text/html
  BrowserMatch ^Mozilla/4\.0[678] no-gzip
  BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
  Header append Vary User-Agent
</IfModule>
Header append Vary User-Agent env=!dont-vary

# Entêtes CORS
<IfModule mod_headers.c>
  Header set Access-Control-Allow-Origin "*"
  AddType application/x-font-woff .woff
  AddType application/x-font-woff2 .woff2

  Header always set X-FRAME-OPTIONS "SAMEORIGIN"
  Header always set X-Content-Type-Options "nosniff"
  Header set Connection keep-alive

  <FilesMatch "\.(jpeg|webp|png|gif|svg\+xml|x-icon)$">
    Header set Access-Control-Allow-Origin "*"
    Header always set X-FRAME-OPTIONS "ALLOW FROM *"
    Header always set X-Content-Type-Options "nosniff"
    Header set Connection keep-alive
  </FilesMatch>
</IfModule>

# Mod Expires
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresDefault "access plus 1800 seconds"
  ExpiresByType image/jpeg "access plus 1 year"
  ExpiresByType image/webp "access plus 1 year"
  ExpiresByType image/png "access plus 1 year"
  ExpiresByType image/gif "access plus 1 year"
  ExpiresByType image/svg+xml "access plus 1 year"
  ExpiresByType image/x-icon "access plus 1 year"
  ExpiresByType application/javascript "access plus 1 month"
  ExpiresByType application/x-font-woff "access plus 1 year"
  ExpiresByType application/x-font-ttf "access plus 1 year"
  ExpiresByType text/css "access plus 1 month"
</IfModule>
```

### Protection du dossier de configuration (/backend/config/)

Pour empêcher tout accès HTTP externe au dossier contenant vos identifiants sensibles (config.php), créez ces deux fichiers directement dans le dossier /backend/config/.

#### Blocage total

Permet de bloquer l'accès par URL aux ressources du dossier (permet de faire l'inclusion programmatique).

Puisque les fichiers PHP s'incluent côté serveur (via require), il n'y a aucune raison d'y accéder via une URL. Vous pouvez simplement bloquer tout le dossier.

Fichier /backend/config/.htaccess :

```apache
Require all denied
```
