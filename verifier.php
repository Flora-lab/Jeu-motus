<?php
require_once 'classes/MotusGame.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proposition'])) {
    $proposition = trim($_POST['proposition']);

    // Nettoyage simple
    $proposition = strtolower($proposition);
    $proposition = preg_replace('/[^a-z]/', '', $proposition);

    $game = new MotusGame();

    // Vérification de la longueur
    if (strlen($proposition) === strlen($game->getMotSecret()) && !$game->isGagne() && !$game->isPerdu()) {
        $game->verifierProposition($proposition);
    }
}

// Redirection vers la page principale
header('Location: motus.php');
exit;
