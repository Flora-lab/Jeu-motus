<?php

class Database {
    private $host = 'localhost';
    private $dbname = 'motus';
    private $username = 'root';
    private $password = '';
    private $conn;

    // Le constructeur privé pour éviter l'instanciation directe
    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Méthode pour obtenir la connexion (singleton)
    public static function getConnection() {
        static $instance = null;

        if ($instance === null) {
            $instance = new Database();
        }

        return $instance->conn;
    }
}

?>