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
        // Passwort sicher hashen
        $hash = password_hash($daten['passwort'], PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("
            INSERT INTO kunden (vorname, nachname, email, passwort_hash, adresse, benutzername)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

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
        $kunde = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$kunde) {
            echo "❌ Benutzer nicht gefunden<br>";
            return false;
        }

        echo "✅ Benutzer gefunden<br>";


        if (password_verify($passwort, $kunde['passwort_hash'])) {

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['kunden_id'] = $kunde['kunden_id'];
            $_SESSION['vorname'] = $kunde['vorname'];
            $_SESSION['benutzername'] = $kunde['benutzername'];

            return true;
        } else {
            echo "❌ Passwort falsch<br>";
            return false;
        }
    }

    public function istEingeloggt() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['kunden_id']);
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: main.php');
        exit;
    }

    public function getKundendaten($kunden_id) {
        $stmt = $this->db->prepare("SELECT * FROM kunden WHERE kunden_id = ?");
        $stmt->execute([$kunden_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}