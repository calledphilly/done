# Symfony Blog App — IIM Project

Projet réalisé dans le cadre du cours *Architecture MVC avec Symfony* à l’IIM (Institut de l’Internet et du Multimédia).

## 🚀 Fonctionnalités principales

### Authentification & Sécurité
- Formulaire de login et d'inscription
- Sécurité par rôle (`ROLE_USER`, `ROLE_ADMIN`)
- Protection CSRF

### Gestion des utilisateurs
- Edition du profil (email + mot de passe)
- Navigation dynamique selon connexion / rôle

### Articles
- Création, modification, suppression
- Un utilisateur ne peut voir que ses propres articles
- Interface admin pour voir tous les articles

### Notifications
- Enregistrement des notifications en base
- Notifications asynchrones via Symfony Messenger
- Envoi d'un email (via `logger://` local)
- Badge de notification visible dans la navbar
- Bouton "Marquer comme lues"

## 🛠 Technologies utilisées
- Symfony 6.x
- Doctrine ORM
- Twig (templates)
- Symfony Messenger (notifications async)
- Mailer (transport simulé en dev)

## 📂 Arborescence principale
```
├── src
│   ├── Controller
│   ├── Entity
│   ├── Form
│   ├── Message / MessageHandler
│   ├── Repository
│   └── Twig (Extension globale)
├── templates
│   ├── base.html.twig
│   ├── article/
│   ├── admin/article/
│   ├── profile/
│   └── notification/
├── config
├── migrations
└── public
```

## ✅ Lancer le projet en local

### Prérequis
- PHP >= 8.1
- Composer
- Symfony CLI
- MySQL ou MariaDB (config dans `.env`)

### Étapes
```bash
git clone <repo>
cd <nom-du-projet>
composer install
symfony server:start
```

Créer la base et lancer les migrations :
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

Démarrer le worker Messenger :
```bash
php bin/console messenger:consume async -vv
```