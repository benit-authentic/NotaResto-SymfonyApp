NotaResto - Application de Gestion de Restaurants

NotaResto est une application web développée avec le framework Symfony. Elle permet aux utilisateurs de consulter des restaurants, de laisser des avis, et aux restaurateurs de gérer leurs établissements. Les administrateurs et les modérateurs ont des privilèges supplémentaires pour maintenir la qualité des contenus et gérer les utilisateurs.

Prérequis
Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

    WAMP (Windows, Apache, MySQL, PHP)
        Vous pouvez télécharger et installer WAMP depuis le site officiel.
    Composer
        Composer est un gestionnaire de dépendances pour PHP. Vous pouvez le télécharger et l'installer depuis le site officiel.

Installation

Suivez ces étapes pour installer et exécuter le projet sur votre machine locale :

Téléchargez et dézippez le projet depuis GitHub :
      Accédez au dépôt GitHub de NotaResto et téléchargez le fichier ZIP du projet.
      Décompressez le fichier ZIP dans le répertoire de votre choix.

Installez les dépendances avec Composer :

    composer install

Configurez votre base de données :
  Dupliquez le fichier .env en .env.local et configurez vos informations de base de données :

    DATABASE_URL="mysql://root:password@127.0.0.1:3306/notaresto"

    Ajustez root et password selon votre configuration MySQL.

Créez la base de données :

php bin/console doctrine:database:create

Générez et appliquez les migrations :

    php bin/console make:migration
    php bin/console doctrine:migrations:migrate

(Optionnel) Charger des données de test avec les fixtures :
  Si vous souhaitez tester l'application avec des données de test, utilisez cette commande :

    php bin/console doctrine:fixtures:load

    Les comptes utilisateurs suivants seront créés pour tester les différentes fonctionnalités de l'application :
        Administrateur
            Email: administrateur@notaresto.com
            Mot de passe: notaresto
        Modérateur
            Email: moderateur@notaresto.com
            Mot de passe: notaresto
        Client
            Email: client@notaresto.com
            Mot de passe: notaresto
        Restaurateur
            Email: restaurateur@notaresto.com
            Mot de passe: notaresto

Lancez le serveur Symfony :

    php bin/console server:run

Utilisation

L'application est maintenant prête à être utilisée. Ouvrez votre navigateur et accédez à http://localhost:8000.
Fonctionnalités

    Utilisateurs :
        Consulter les restaurants.
        Laisser des avis.

    Restaurateurs :
        Créer, modifier et supprimer leurs restaurants.
        Ajouter des images aux restaurants.
        Répondre aux avis des clients.

    Modérateurs :
        Modérer les avis.
        Gérer les utilisateurs (suspendre/bannir).

    Administrateurs :
        Gestion complète de l'application.
        Gestion des utilisateurs, des restaurants et des avis.
        Attribution des rôles de modérateur et de restaurateur.

Ce README vous guide à travers les étapes nécessaires pour installer et utiliser NotaResto sur votre machine locale. Si vous avez des questions ou des problèmes, n'hésitez pas à les soulever.
