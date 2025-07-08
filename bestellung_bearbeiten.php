<?php
session_start();
require_once 'classes/Bestellung.php';

if (!isset($_SESSION['mitarbeiter_id'])) {
    die("Nicht eingeloggt!");
}

if (isset($_POST['bestellung_id'])) {
    $bestellung = new Bestellung();
    if ($bestellung->bearbeiteBestellung($_POST['bestellung_id'], $_SESSION['mitarbeiter_id'])) {
        echo "Bestellung übernommen!";
    } else {
        echo "Konnte Bestellung nicht übernehmen.";
    }
}
?>