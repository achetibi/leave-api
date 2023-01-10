## Prérequis
- PHP 8.0
- MySQL 8.0
- Apache
- Composer

## Installation
- Installez les dépendances avec composer ```composer install```
- Installez un vhost sur Apache server, Exemple:
```
<VirtualHost *:80>
    ServerName leave-api.local
    DocumentRoot "c:/wamp/www/leave-api/public"
    
    <Directory  "c:/wamp/www/leave-api/public/">
    Options +Indexes +Includes +FollowSymLinks +MultiViews
    AllowOverride All
    Require local
    </Directory>
</VirtualHost>
```

- Ajouter le vhost dans le fichier hosts de votre système
`127.0.0.1	leave-api.local`

- Ajoutez une base de données
- Importez la base de données ``src/schema/leave_api.sql``
- Copiez le fichier `.env.example` vers `.env` et remplissez les informations dans le fichier

## Resources
Le fichier de collection de PostMan est fourni avec, il suffit de l'importer.

## Fonctionnalités
- Routage dynamique avec prise en charge des méthodes GET, POST, PUT et DELETE
- Pas de package externe a l'exception de:
  - JWT pour l'optention des tokens JSON
  - Symfony VarDumper pour l'environnement de développement uniquement
- Middlewares pour l'authentification et filtrage des requêtes non autorisées
- Middleware pour les permissions et autorisations par role sur les routes
- Architecture MVC
- Autoloader PSR-4

## A faire
- Validation des données
- Autre optimisation...
