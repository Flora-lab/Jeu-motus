<?php
require_once 'classes/MotusGame.php';
require_once 'db.php';  // Inclure le fichier de connexion à la base de données

// Créer une instance du jeu
$game = new MotusGame();
$motSecret = $game->getMotSecret();
$historique = $game->getHistorique();
$tentatives = count($historique);
$gagne = $game->isGagne();

// Récupérer le nom du joueur depuis le formulaire
$nom = $_POST['nom'] ?? 'Anonyme';

// On prépare les données du score
$scoreData = [
    'nom' => htmlspecialchars($nom),
    'date' => date('Y-m-d H:i:s'),
    'mot' => $motSecret,
    'tentatives' => $tentatives,
    'etat' => $gagne ? 'Gagné' : 'Perdu'
];

// Connexion à la base de données
$conn = Database::getConnection();  // Utilisation de la méthode getConnection()

// Insertion du score dans la base de données
$sql = "INSERT INTO scores (nom, date, mot, tentatives, etat) VALUES (:nom, :date, :mot, :tentatives, :etat)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':nom', $scoreData['nom']);
$stmt->bindParam(':date', $scoreData['date']);
$stmt->bindParam(':mot', $scoreData['mot']);
$stmt->bindParam(':tentatives', $scoreData['tentatives']);
$stmt->bindParam(':etat', $scoreData['etat']);

// Exécution de la requête
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Motus - Score</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<div id="particles-js"></div>
<body class="score">
    <div class="container">
        <h1>🎯 Résultat de la Partie</h1>

        <p>Joueur : <strong><?= htmlspecialchars($nom) ?></strong></p>
        <p>Mot à deviner : <strong><?= strtoupper($motSecret) ?></strong></p>
        <p>Nombre de tentatives : <strong><?= $tentatives ?></strong></p>
        <p>Résultat : <strong><?= $gagne ? "Gagné 🎉" : "Perdu ❌" ?></strong></p>

        <a href="reset.php" class="btn-rejouer">🔁 Rejouer</a>

        <hr>

        <h2>📜 Historique des scores</h2>
        <table class="table-score">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Date</th>
                    <th>Mot</th>
                    <th>Tentatives</th>
                    <th>État</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Récupérer les scores de la base de données
                $sql = "SELECT * FROM scores ORDER BY date DESC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Afficher les scores
                foreach ($scores as $score): ?>
                    <tr>
                        <td><?= htmlspecialchars($score['nom']) ?></td>
                        <td><?= $score['date'] ?></td>
                        <td><?= strtoupper($score['mot']) ?></td>
                        <td><?= $score['tentatives'] ?></td>
                        <td><?= $score['etat'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="assets/js/particles-config.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
