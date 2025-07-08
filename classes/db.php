<?php class Datenbank {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:host=localhost;dbname=liferung;charset=utf8mb4", "root", "");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getVerbindung() {
        return $this->pdo;
    }
}
?>
