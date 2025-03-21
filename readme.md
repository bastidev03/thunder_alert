# Bienvenue sur le projet thunder_alert

Ceci est une application backend qui permet d’importer des destinataires depuis un fichier CSV vers une Base de Donnée, et d’envoyer des alertes météo par SMS à des particuliers.

## Installations

- Installer Symfony 6.4 via Composer install
- Installer PHP 8.4
- Installer Postgresql 17.4

## Lancement du projet

- Lancer le serveur PostgreSQL
- Adapter la configuration du fichier .env à la racine du projet pour y mettre les configurations de votre serveur PostgreSQL 
- Lancer le script de migration afin de créer la Base 'thunder_alert' et la table 'contacts' dans votre serveur Postgresql 
- Lancer le serveur Symfony

## Utilisation des fonctionnalités développées

## Axes d'amélioration

- Améliorer la robustesse du parsing des champs CSV (Séparateur dynamique via une conf dans le fichier .env, ...)
- Améliorer la gestion des Erreurs / Exceptions
- Améliorer la traçabilité des actions (Système de Logger à améliorer => Voir comment faire avec le loggeur Symfony ou Monolog)
- Empêcher l'insertion de doublons dans la table contacts
- Faire une insertion en lots plutôt que d'insérer les lignes une par une (Meilleures perfs)
- Ajouter la gestion du code pays dans les numéros de téléphone
- Utiliser PDO pour les transactions BDD (Doctrine interdit => Pas voulu utiliser PDO)
- Protéger le point d'entrée /alerter des injections SQL (Utiliser PDO)
- Utiliser un template pour l'envoi des messages