<?php
session_start();
require_once 'classes/Bestellung.php';

if (!isset($_SESSION['mitarbeiter_id'])) {
    die("Nicht eingeloggt!");
}

if (isset($_POST['bestellung_id'])) {
    $bestellung = new Bestellung();
    if ($bestellung->abschliessen($_POST['bestellung_id'])) {
        echo "Bestellung abgeschlossen!";
    } else {
        echo "Fehler beim Abschließen.";
    }
}
?>
