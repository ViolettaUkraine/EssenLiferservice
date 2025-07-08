<?php 

require_once 'classes/db.php';

class Produkte {
    private $produkt_id;
    private $name;
    private $beschreibung;
    private $preis;
    private $db;

    public function __construct() {
        $this->db = (new Datenbank())->getVerbindung();
    }



    public function getAlleProdukte() {
        $sql = "SELECT * FROM produkte";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>