<?php
session_start();
require_once 'classes/Bestellung_class.php';

if (!isset($_SESSION['mitarbeiter_id'])) {
    die("Nicht eingeloggt!");
}

if (isset($_POST['bestellung_id'], $_POST['aktion'])) {
    $bestellung = new Bestellung();
    $bestellung_id = $_POST['bestellung_id'];
    $mitarbeiter_id = $_SESSION['mitarbeiter_id'];
    $aktion = $_POST['aktion'];

    if ($aktion === 'uebernehmen') {
        $erfolg = $bestellung->bearbeiteBestellung($bestellung_id, $mitarbeiter_id);
    } elseif (in_array($aktion, ['unterwegs', 'ausgeliefert'])) {
        $erfolg = $bestellung->setzeStatus($bestellung_id, $aktion, $mitarbeiter_id);
    } else {
        $erfolg = false;
    }

    if ($erfolg) {
        echo "✅ Aktion erfolgreich!";
    } else {
        echo "❌ Aktion fehlgeschlagen!";
    }
}
?>