<?php
require_once 'db.php';

class Kunde {
    private $kunden_id;
    private $vorname;
    private $nachname;
    private $email;
    private $passwort_hash;
    private $adresse;
    private $erstellt_am;
    private $benutzername;
    private $db;

public function __construct() {
    $this->db = (new Datenbank())->getVerbindung();
}

     public function registrieren($daten) {
        $hash = password_hash($daten['passwort'], PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO kunden (vorname, nachname, email, passwort_hash, adresse, benutzername) VALUES (?, ?, ?, ?, ?, ?)");
            return $stmt->execute([
            $daten['vorname'],
            $daten['nachname'],
            $daten['email'],
            $hash,
            $daten['adresse'],
            $daten['benutzername']
        ]);
     }

     public function login($benutzername, $passwort) {
        $stmt = $this->db->prepare("SELECT * FROM kunden WHERE benutzername = ?");
        $stmt->execute([$benutzername]);
        $kunde = $stmt->fetch(PDO::FETCH_ASSOC);//Holt die Kundendaten aus der Datenbank als assoziatives Array
        if ($kunde && password_verify($passwort, $kunde['passwort_hash'])) {
            $_SESSION['kunde_id'] = $kunde['kunden_id'];
            $_SESSION['vorname'] = $kunde['vorname'];
            $_SESSION['benutzername'] = $kunde['benutzername'];
            return true;

        }
        return false;
    }
    public function istEingeloggt() {
        return isset($_SESSION['kunde_id']);
    }


    public function logout() {
        session_unset();
        session_destroy();
    }

    public function getKundendaten($kunden_id) {
        $stmt = $this->db->prepare("SELECT * FROM kunden WHERE kunden_id = ?");
        $stmt->execute([$kunden_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}