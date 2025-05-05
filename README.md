# 📅 Gestion de Planning – Application PHP/MySQL

## ⚙️ Présentation

Cette application permet de gérer un planning de cours par classe avec affichage sous forme de calendrier mensuel, hebdomadaire et annuel. Il est également possible d'ajouter, modifier, supprimer et glisser-déposer des modules.

---

## 🚀 Installation

### 1. Prérequis

- XAMPP (ou WAMP/LAMP)
- PHP ≥ 7.4
- MySQL
- Navigateur web

### 2. Déploiement

1. Copier/cloner tous les fichiers du projet dans le dossier `htdocs` (pour XAMPP) ou dans le répertoire web de votre serveur.
   exemple : C:\xampp\htdocs\Gestion-planning

2. Créer une base de données `planning` dans phpMyAdmin :
(sql)
CREATE DATABASE planning CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

3. Importer le fichier planning.sql (fourni avec ce projet) dans la base planning.

4. Vérifier que la connexion à la base dans includes/db.php est correcte :
   <?php
   $pdo = new PDO('mysql:host=localhost;dbname=planning;charset=utf8mb4', 'root', '');
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
## 🌐 Accès à l'application

1. Lancer Apache et MySQL dans XAMPP (ou autre), puis ouvrir votre navigateur à l’adresse :
   http://localhost/Gestion-planning/pages/calendrier_classe.php

## 📁 Structure du projet

Gestion-planning/
├── includes/
│   ├── db.php
│   └── header.php
├── modules/
│   ├── ajouter.php
│   ├── modifier.php
│   ├── supprimer.php
│   └── lister.php
├── pages/
│   └── calendrier_classe.php (page principale)
├── assets/
│   └── (fichiers JS/CSS si besoin)
└── planning.sql (script SQL)


---

### ✅ 2. Script SQL `planning.sql`

Voici le contenu à copier dans le fichier `planning.sql` :

sql :
CREATE DATABASE IF NOT EXISTS planning CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE planning;

-- Table : modules
CREATE TABLE IF NOT EXISTS modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    classe_id INT DEFAULT NULL,
    heures_total INT DEFAULT 0,
    couleur VARCHAR(7) DEFAULT '#D1D5DB',
    FOREIGN KEY (classe_id) REFERENCES classes(id) ON DELETE SET NULL
);

-- Table : plannings (association d'un module à une date)
CREATE TABLE IF NOT EXISTS plannings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    module_id INT NOT NULL,
    date_cours DATE NOT NULL,
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE
);
