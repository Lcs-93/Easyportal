# Easyportal

Easyportal est une application Symfony développée pour simplifier la gestion de portails d'entreprises. Elle permet de gérer les utilisateurs, les rôles, ainsi que l'accès à différentes sections de l'application.

## 📌 Description
L'application propose une interface intuitive pour les administrateurs et les utilisateurs. Les administrateurs peuvent gérer les utilisateurs, les rôles, et configurer les accès. Les utilisateurs peuvent accéder aux sections qui leur sont autorisées.

## 🚀 Fonctionnalités principales
- **Gestion des utilisateurs** : Inscription, connexion, modification de profil.
- **Gestion des rôles** : Définition des rôles d'administrateur, utilisateur, etc.
- **Gestion des permissions** : Contrôle d'accès aux différentes sections selon les rôles.
- **Dashboard administrateur** : Interface dédiée aux administrateurs pour gérer les utilisateurs.
- **Dashboard utilisateur** : Interface personnalisée selon les permissions accordées.

## 📂 Structure du projet
```
.
├── config/           # Configuration de l'application Symfony
├── migrations/       # Fichiers de migration de la base de données
├── public/           # Dossier public contenant l'index.php
├── src/              # Code source de l'application (Controllers, Entities, Repositories)
├── templates/        # Vues Twig pour l'affichage
├── .env              # Configuration de l'environnement
├── composer.json     # Dépendances PHP
├── README.md         # Documentation du projet
```

## 🔧 Prérequis
- PHP >= 8.0
- Composer
- Symfony CLI
- MariaDB ou MySQL

## 📥 Installation
1. Clonez ce dépôt :
```bash
$ git clone https://github.com/Lcs-93/Easyportal.git
```
2. Rendez-vous dans le répertoire cloné :
```bash
$ cd Easyportal
```
3. Installez les dépendances PHP avec Composer :
```bash
$ composer install
```
4. Configurez votre base de données dans le fichier `.env` :
```
DATABASE_URL="mysql://root:@127.0.0.1:3306/easyportal?serverVersion=10.4.32-MariaDB&charset=utf8mb4"
```
5. Effectuez les migrations :
```bash
$ php bin/console doctrine:migrations:migrate
```
6. Lancez le serveur Symfony :
```bash
$ symfony server:start
```

## 📌 Utilisation
Accédez à l'application via votre navigateur à l'adresse suivante :
```
http://127.0.0.1:8000
```

## 🛠️ Technologies utilisées
- **Symfony** (PHP framework)
- **Twig** (Moteur de templates)
- **MariaDB / MySQL** (Base de données)
- **HTML / CSS / JavaScript** (Frontend)

## 📄 Licence
Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 📣 Auteur
Projet créé par **Lcs-93**. N'hésitez pas à me contacter pour toute suggestion ou amélioration !

---

🔥 Bon développement !

