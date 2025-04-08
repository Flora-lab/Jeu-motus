# Projet Motus

Le jeu Motus est une version en ligne du célèbre jeu de mots. Le but du jeu est de deviner un mot secret parmi une liste de mots. Chaque joueur a un nombre limité de tentatives (6 au total) pour découvrir le mot. Les lettres sont évaluées et affichées en fonction de leur position (correctement placées, mal placées ou absentes).

## Fonctionnalités

- Choix aléatoire du mot secret parmi une liste de mots définie dans un fichier JSON.
- Affichage du mot à deviner avec des lettres masquées, sauf la première lettre.
- Système de validation des tentatives avec des retours indiquant si une lettre est bien placée, mal placée ou absente.
- Enregistrement des scores dans une base de données MySQL.
- Wall of Fame affichant les meilleurs scores.
- Utilisation de la programmation orientée objet (POO) en PHP.

## Technologies utilisées

- **HTML** : Structure de la page web.
- **CSS** : Design et animations du jeu.
- **JavaScript** : Interactions et animations.
- **PHP** : Backend pour la gestion du jeu, des sessions et des scores.
- **MySQL** : Base de données pour stocker les scores des joueurs.

## Prérequis

Pour faire fonctionner ce projet, vous devez avoir les éléments suivants installés sur votre machine :

- Serveur local (comme XAMPP ou WAMP) pour exécuter le code PHP.
- Serveur MySQL ou MariaDB pour gérer la base de données.
- Un éditeur de texte ou un IDE pour modifier les fichiers.

## Installation

1. Clonez ce dépôt ou téléchargez le fichier ZIP et extrayez-le.
2. Placez les fichiers du projet dans le répertoire du serveur local (`htdocs` pour XAMPP, par exemple).
3. Créez une base de données MySQL appelée `motus`.
4. Créez une table `word` et une table `scores` dans la base de données avec les commandes suivante :

```sql
CREATE TABLE word (
  id INT AUTO_INCREMENT PRIMARY KEY,
  word VARCHAR(255) NOT NULL
);

CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    score INT NOT NULL,
    date DATETIME NOT NULL,
    mot VARCHAR(255) NOT NULL,
    etat VARCHAR(255) NOT NULL
);
