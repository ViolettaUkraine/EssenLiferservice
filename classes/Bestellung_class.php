<?php
require_once 'classes/db.php';
class Bestellung {
    private $db;

    public function __construct() {
        $this->db = (new Datenbank())->getVerbindung();
    }

    public function neueBestellung($kunde_id, $produkte) {
        $this->db->beginTransaction();

        $stmt = $this->db->prepare("INSERT INTO bestellungen (kunde_id, status, erstellt_am) VALUES (?, 'offen', NOW())");
        $stmt->execute([$kunde_id]);
        $bestellung_id = $this->db->lastInsertId();

        foreach ($produkte as $produkt_id => $menge) {
            $stmt = $this->db->prepare("INSERT INTO bestellpositionen (bestellung_id, produkt_id, menge) VALUES (?, ?, ?)");
            $stmt->execute([$bestellung_id, $produkt_id, $menge]);
        }

        $this->db->commit();
        return $bestellung_id;
    }

    public function bearbeiteBestellung($bestellung_id, $mitarbeiter_id) {
        $stmt = $this->db->prepare("UPDATE bestellungen SET mitarbeiter_id = ?, status = 'in_bearbeitung' WHERE bestellung_id = ? AND status = 'offen'");
        return $stmt->execute([$mitarbeiter_id, $bestellung_id]);
    }

    public function abschliessen($bestellung_id) {
        $stmt = $this->db->prepare("UPDATE bestellungen SET status = 'abgeschlossen' WHERE bestellung_id = ?");
        return $stmt->execute([$bestellung_id]);
    }
}
?>