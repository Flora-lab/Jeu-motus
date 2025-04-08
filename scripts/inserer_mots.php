<?php
require_once(__DIR__ . '/../db.php');  // Inclure la classe Database
// Votre code pour insérer les mots
$pdo = Database::getInstance();
$mots = ['risque', 'actuel', 'cheval', 'paquet', 'examen', 'buveur', 'cabine'];

foreach ($mots as $mot) {
    $stmt = $pdo->prepare('INSERT INTO word (word) VALUES (:word)');
    $stmt->execute([':word' => $mot]);
}

echo "Mots insérés avec succès!";
?>
