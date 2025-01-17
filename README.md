# SAE-WEB_BD-PONEY
## Membres du projet

Alexandre GUIHARD

Antoine DELAHAYE

Sargis VARDANYAN
## Base de données
> Pour créer les tables, créer les triggers et insérer des données, il faut exécuter le fichier **execute.sql** présent dans le dossier **bd** dans une base de données
## Fonctionnalités du site
### PDO
> Le site web établi une connexion à la base de données MySQL qui contient toutes les informations sur le moniteur, l'adhérent, les cours et les poneys
### Page de connexion
> Sur la page de connexion, vous devez entrer une adresse mail présent dans la base de données. Le mot de passe correspond à l'identifiant de la personne avec l'adresse mail rentrée. Selon le type d'utilisateur (adhérent ou moniteur) qui tente de se connecter, il sera dirigé sur la page qui le concerne (page adhérent pour les adhérents et page moniteur pour les moniteurs)
### Vue Adhérent
> En étant connecté en tant qu'adhérant, vous pouvez consulter les cours réservés par l'adhérant et les annuler en cas d'imprévus à la date du cours. Vous pouvez également réserver des cours non réservés de son niveau. Il s'ajoutera alors à vos réservations.
### Vue Moniteur
> Le moniteur peut, lui ajouter un cours qu'il gère, le modifier ou également le supprimer
### Autres fonctionnalités
> Les moniteurs et les adhérents peuvent connaître les cours qu'ils ont dans les 7 prochains jours et les informations sur ces cours. Ils peuvent également consulter des informations sur leurs compte
## Fonctionnalités ajoutées depuis la soutenance
> Avant la soutenance, notre site était uniquement différentes pages connectées entre elles par des boutons. Après la soutenance, nous avons donc implémentés les différentes fonctionnalités présentés dans la partie des fonctionnalités
## Lancement du site
> Pour lancer le site, il faut exécuter la commande **"bash start.sh"** 
## Git
> Lien Git: https://github.com/varuniv/SAE-WEB_BD-PONEY.git
