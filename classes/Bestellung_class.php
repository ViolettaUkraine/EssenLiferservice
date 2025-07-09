<?php
require_once 'classes/db.php';
class Bestellung {
    private $db;

    public function __construct() {
        $this->db = (new Datenbank())->getVerbindung();
    }

    public function neueBestellung($kunden_id, $produkte) {
        $this->db->beginTransaction();

        $stmt = $this->db->prepare("INSERT INTO bestellungen (kunden_id, status, erstellt_am) VALUES (?, 'offen', NOW())");
        $stmt->execute([$kunden_id]);
        $bestellung_id = $this->db->lastInsertId();

        foreach ($produkte as $produkt_id => $menge) {
            $stmt = $this->db->prepare("INSERT INTO bestellpositionen (bestellung_id, produkt_id, menge) VALUES (?, ?, ?)");
            $stmt->execute([$bestellung_id, $produkt_id, $menge]);
        }

        $this->db->commit();
        return $bestellung_id;
    }

public function bearbeiteBestellung($bestellung_id, $mitarbeiter_id) {
    // 1. Status ändern
    $stmt1 = $this->db->prepare("UPDATE bestellungen SET status = 'in_bearbeitung' WHERE bestellung_id = ? AND status = 'offen'");
    $ok = $stmt1->execute([$bestellung_id]);

    // 2. Mitbearbeiter speichern
    if ($ok) {
        $stmt2 = $this->db->prepare("INSERT INTO mitarbeiter_bestellungen (bestellung_id, mitarbeiter_id) VALUES (?, ?)");
        return $stmt2->execute([$bestellung_id, $mitarbeiter_id]);
    }
    return false;
}
    public function abschliessen($bestellung_id) {
        $stmt = $this->db->prepare("UPDATE bestellungen SET status = 'abgeschlossen' WHERE bestellung_id = ?");
        return $stmt->execute([$bestellung_id]);
    }
     public function setzeStatus($bestellung_id, $status, $mitarbeiter_id) {
        // Nur zulassen, wenn der eingeloggte Mitarbeiter diese Bestellung bearbeitet
        $stmt = $this->db->prepare("SELECT * FROM mitarbeiter_bestellungen WHERE bestellung_id = ? AND mitarbeiter_id = ?");
        $stmt->execute([$bestellung_id, $mitarbeiter_id]);
        if ($stmt->rowCount() === 0) {
            return false; // Nicht berechtigt!
        }

        $stmt2 = $this->db->prepare("UPDATE bestellungen SET status = ? WHERE bestellung_id = ?");
        $stmt2->execute([$status, $bestellung_id]);
        return true;
    }
}

?>