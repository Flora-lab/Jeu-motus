<?php
require_once(__DIR__ . '/../db.php');  // Inclure la connexion à la base de données

class MotusGame {

    public const MAX_TENTATIVES = 6;
    private string $motSecret;
    private int $essaisMax = self::MAX_TENTATIVES;
    private array $historique = [];
    private int $tentatives = 0;
    private bool $gagne = false;

    public function __construct() {
        session_start();

        // Si le mot n'est pas déjà en session, on en tire un aléatoirement
        if (!isset($_SESSION['mot'])) {
            $this->motSecret = $this->tirerMot();
            $_SESSION['mot'] = $this->motSecret;
            $_SESSION['tentatives'] = 0;
            $_SESSION['historique'] = [];
            $_SESSION['gagne'] = false;
        } else {
            $this->motSecret = $_SESSION['mot'];
            $this->tentatives = $_SESSION['tentatives'];
            $this->historique = $_SESSION['historique'];
            $this->gagne = $_SESSION['gagne'];
        }
    }

    public function ajouterScore(string $nomJoueur): void {
        // Si le joueur a gagné, on ajoute le score à la base de données
        if ($this->gagne) {
            $score = [
                'nom' => $nomJoueur,
                'score' => $this->tentatives
            ];

            // Connexion à la base de données
            $db = new Database();
            $conn = $db->getConnection();

            // Insertion du score dans la base de données
            $stmt = $conn->prepare("INSERT INTO scores (nom, score) VALUES (:nom, :score)");
            $stmt->bindParam(':nom', $score['nom']);
            $stmt->bindParam(':score', $score['score']);
            $stmt->execute();
        }
    }

    private function tirerMot(): string {
        // Charger les mots depuis le fichier JSON
        $data = file_get_contents(__DIR__ . '/../data/mots.json');
        $mots = json_decode($data, true);
        $mot = $mots[array_rand($mots)]['mot'];
        return strtolower($mot);
    }

    public function getMasqueInitial(): string {
        return strtoupper($this->motSecret[0]) . str_repeat(' _ ', strlen($this->motSecret) - 1);
    }

    public function verifierProposition(string $mot): array {
        $mot = strtolower($mot);
        $resultat = [];
        $motSecretArray = str_split($this->motSecret);
        $motProposeArray = str_split($mot);

        foreach ($motProposeArray as $i => $lettre) {
            if ($lettre === $motSecretArray[$i]) {
                $resultat[] = ['lettre' => strtoupper($lettre), 'etat' => 'bien-place'];
            } elseif (in_array($lettre, $motSecretArray)) {
                $resultat[] = ['lettre' => strtoupper($lettre), 'etat' => 'mal-place'];
            } else {
                $resultat[] = ['lettre' => strtoupper($lettre), 'etat' => 'absente'];
            }
        }

        $this->tentatives++;
        $this->historique[] = $resultat;

        if ($mot === $this->motSecret) {
            $this->gagne = true;
        }

        // Mise à jour session
        $_SESSION['tentatives'] = $this->tentatives;
        $_SESSION['historique'] = $this->historique;
        $_SESSION['gagne'] = $this->gagne;

        return $resultat;
    }

    public function getHistorique(): array {
        return $this->historique;
    }

    public function isGagne(): bool {
        return $this->gagne;
    }

    public function isPerdu(): bool {
        return !$this->gagne && $this->tentatives >= $this->essaisMax;
    }

    public function getMotSecret(): string {
        return strtoupper($this->motSecret);
    }

    public function getTentativesRestantes(): int {
        return $this->essaisMax - $this->tentatives;
    }

    public function reset(): void {
        session_unset();
        session_destroy();
    }
}
?>
