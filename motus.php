<?php
require_once 'classes/MotusGame.php';

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=motus", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer un mot aléatoire depuis la base de données
$stmt = $pdo->query("SELECT word FROM word ORDER BY RAND() LIMIT 1");
$motSecret = $stmt->fetchColumn();

$game = new MotusGame();
$historique = $game->getHistorique();
$motSecret = $game->getMotSecret();
$gagne = $game->isGagne();
$perdu = $game->isPerdu();
$tour = count($historique);
$maxTentatives = $game::MAX_TENTATIVES;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Motus - Jeu</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<div id="particles-js"></div>
<body class="jeu">
    <div class="container">

        <h1>Motus</h1>
        <?php if ($gagne): ?>
            <div class="message victoire">
                🎉 Bravo ! Le mot était <strong><?= $motSecret ?></strong>.
            </div>
            <a href="reset.php" class="btn-rejouer">🔁 Rejouer</a>

        <?php elseif ($perdu): ?>
            <div class="message defaite">
                ❌ Dommage ! Le mot était <strong><?= $motSecret ?></strong>.
            </div>
            <a href="reset.php" class="btn-rejouer">🔁 Rejouer</a>

        <?php else: ?>
            <div class="tentatives">
                Tentatives restantes : <strong><?= $game->getTentativesRestantes() ?></strong>
            </div>

            <form action="verifier.php" method="post" class="form-jeu">
                <input type="text" name="proposition" maxlength="6" minlength="6" required autocomplete="off" placeholder="Entrez un mot">
                <button type="submit">Valider</button>
            </form>
        <?php endif; ?>

        <div class="grille">
            <?php if (empty($historique)): ?>
                <div class="mot masque"><?= $game->getMasqueInitial() ?></div>
            <?php else: ?>
                <?php foreach ($historique as $ligne): ?>
                    <div class="mot">
                        <?php foreach ($ligne as $lettre): ?>
                            <span class="lettre <?= $lettre['etat'] ?>">
                                <?= $lettre['lettre'] ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <?php if ($gagne || $perdu): ?>
                    <form action="score.php" method="post" class="form-score">
                        <label for="nom">Entrez votre nom pour enregistrer votre score :</label><br>
                        <input type="text" name="nom" id="nom" required placeholder="Ex : Samir">
                        <button type="submit">✅ Valider mon score</button>
                    </form>
                <?php endif; ?>
                <?php if ($gagne): ?>
                <audio autoplay src="assets/sounds/victoire.mp3"></audio>
                <?php elseif ($perdu): ?>
                <audio autoplay src="assets/sounds/defaite.mp3"></audio>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <script src="assets/js/particles-config.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
