<?php
// Réinitialiser la session si jamais l'utilisateur revient ici
session_start();

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Motus - Accueil</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div id="particles-js"></div>
<body class="accueil">

    <div class="container">

        <h1 class="titre-accueil">Bienvenue dans le jeu <span>Motus</span> !</h1>
        <a href="motus.php" class="btn-jouer">🎮 Jouer</a>
    </div>
    <script>
        const music = document.getElementById('bg-music');
        document.addEventListener("click", () => music.play());
    </script>
    <script src="assets/js/particles-config.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>

