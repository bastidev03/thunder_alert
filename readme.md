# Bienvenue sur le projet thunder_alert

Ceci est une application backend qui permet d’importer des destinataires depuis un fichier CSV vers une Base de Donnée, et de simuler des envois d'alertes météo par SMS à des particuliers ([cf. Spécifications.pdf](./Spécifications.pdf)).


## Pré-requis

- Installer Symfony-CLI 
- Installer PHP 8.4
- Installer Postgresql 17.4
- Installer pgAdmin 4 (Pour administrer la Base de Donnée PostgreSQL)

>**<u>Remarque :</u>** Le projet a été conçu sans l'aide de Docker. Il nécessite d'avoir un serveur Postgresql opérationnel et prêt à recevoir les requêtes de migration.


## Installation

- A la racine du projet, lancer la commande suivante :

    ```bash
        # Installera toutes les dépendances liées au projet
        Composer install
    ```

## Configuration

- Configurer votre serveur Postgresql

    - Via PgAdmin, créer un utilisateur que l'application pourra utiliser pour exécuter le script de migration et envoyer les requêtes SQL par la suite.

    - Via PgAdmin, créer une nouvelle base de données
        >Pour ne pas modifier la config, utiliser le nom `thunder_alert`

    - Modifier si besoin dans le fichier `.env` à la racine du projet, les configurations suivantes en cohérence avec les configurations du serveur PostgreSQL et de la base de données que vous souhaitez utiliser  : `DB_HOST`, `DB_PORT`, `DB_USER`, `DB_PWD`, `DB_NAME` et `DATABASE_URL`.

- Lancer la migrations du model vers la nouvelle BDD créée
    ```bash
        # Assurez-vous que le serveur PostgreSQL est en fonctionnement
        symfony console sql-migrations:execute
    ```

## Lancement du projet
 
- A la racine du projet, lancer le serveur Symfony avec la commande suivante :
    ```bash
        symfony server:start
    ```

## Utilisation des fonctionnalités développées

## Problèmes rencontrés

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
- Implémenter des tests unitaires