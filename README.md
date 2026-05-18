# PeerSync
PeerSync – Plateforme de Tutorat ENAA
Description

PeerSync est une plateforme web développée pour l’ENAA afin de faciliter l’entraide entre les apprenants.
Le système permet aux étudiants de publier des demandes d’aide sur des sujets techniques (POO, SQL, JavaScript, etc.) et aux tuteurs volontaires de les prendre en charge.

L’objectif principal est :

centraliser les demandes d’aide,
éviter la perte des messages sur Discord,
suivre les sessions de tutorat,
valoriser les tuteurs actifs grâce à un système de points et badges.
Fonctionnalités
Gestion des utilisateurs
Connexion des utilisateurs
Gestion des rôles :
Apprenant
Tuteur
Administrateur
Ajout des compétences maîtrisées
Ajout des compétences à améliorer
Gestion des demandes d’aide
Création d’une demande d’aide
Attribution automatique du statut :
PENDING
ASSIGNED
RESOLVED
Acceptation d’une demande par un tuteur
Résolution d’une session
Ajout d’un commentaire après la session
Système de notation
Notation du tuteur de 1 à 5 étoiles
Validation des notes avant insertion en base de données
Gamification
Attribution de points après chaque session validée
Déblocage automatique de badges
Classement des meilleurs tuteurs

Exemples de badges :

Expert PHP
Expert POO
Sauveur de la semaine
Dashboard Administration
Nombre total de sessions
Tuteurs les plus actifs
Technologies les plus demandées
Volume d’heures générées
Export des statistiques
Architecture du Projet

Le projet suit une architecture :

PHP Orienté Objet (OOP)
MVC
Repository Pattern
MySQL
Technologies utilisées
PHP 8+
MySQL
HTML5
CSS3
JavaScript
Bootstrap
PDO
Structure du Projet
PeerSync/
│
├── app/
│   ├── Models/
│   ├── Controllers/
│   ├── Views/
│   ├── Repositories/
│   └── Services/
│
├── config/
│
├── public/
│
├── database/
│
└── README.md
Diagramme de Classes
Classes principales
User
HelpRequest
Review
Badge
Leaderboard
Dashboard
Status (Enum)
Relations UML
User 1 -------- * HelpRequest
User 1 -------- * HelpRequest (Tutor)

HelpRequest 1 -------- 0..1 Review

HelpRequest --------> Status(Enum)

User * -------- * Badge

Leaderboard 1 -------- * User

Dashboard 1 -------- * HelpRequest
Dashboard 1 -------- * User
Dashboard 1 -------- * Review
Base de Données
Tables principales
users
help_requests
reviews
badges
user_badges
skills
leaderboard
Installation
1. Cloner le projet
git clone https://github.com/username/peersync.git
2. Accéder au dossier
cd peersync
3. Configurer la base de données

Créer une base MySQL :

CREATE DATABASE peersync;
4. Configurer .env
DB_HOST=localhost
DB_NAME=peersync
DB_USER=root
DB_PASS=
5. Lancer le serveur
php -S localhost:8000 -t public
Exemple de Workflow
Un apprenant crée une demande.
Le ticket passe au statut PENDING.
Un tuteur accepte la demande.
Le statut devient ASSIGNED.
La session est terminée.
L’apprenant marque la demande comme RESOLVED.
Le tuteur reçoit des points et éventuellement un badge.
Objectifs pédagogiques

Ce projet permet de pratiquer :

la programmation orientée objet,
les relations UML,
les Enums PHP,
PDO et les requêtes sécurisées,
l’architecture MVC,
la conception d’une base de données relationnelle.
Auteur

Projet réalisé dans le cadre du bootcamp ENAA.