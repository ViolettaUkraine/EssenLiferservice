<?php 

require_once 'db.php';



class Produkte {
    private $produkt_id;
    private $name;
    private $beschreibung;
    private $preis;
    private $db;

    public function construct (prdukt_id, name, beschreibung, preis, db)
    $this->produkt_id= $produkt_id;
    $this->name = $name;
    $this->beschreibung = $beschreibung;
    $this->preis = $preis;
    $this->db = (new Datenbank())->getVerbindung();


    public function getAlleProdukte() {
        return $this->db->query("SELECT * FROM produkte")->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>