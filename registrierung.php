<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require_once 'classes/db.php';
require_once 'classes/Kunde.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kunde = new Kunde();
    $ergebnis = $kunde->registrieren([
        'vorname' => $_POST['vorname'],
        'nachname' => $_POST['nachname'],
        'email' => $_POST['email'],
        'adresse' => $_POST['adresse'],
        'benutzername' => $_POST['benutzername'],
        'passwort' => $_POST['passwort']
    ]);

    if ($ergebnis) {
        header("Location: main.php");
        exit;
    } else {
        echo "❌ Registrierung fehlgeschlagen (Benutzername oder E-Mail existiert bereits)";
    }
}
?>


