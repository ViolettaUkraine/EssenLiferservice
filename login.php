<?php
session_start();
require_once 'classes/db.php';

// Formulardaten
$benutzername = $_POST['benutzername'] ?? '';
$passwort = $_POST['passwort'] ?? '';

$db = (new Datenbank())->getVerbindung();

// 1. Prüfen: Ist es ein Mitarbeiter?
$stmt = $db->prepare("SELECT * FROM mitarbeiter WHERE email = ? or benutzername = ?");
$stmt->execute([$benutzername, $benutzername]);
$mitarbeiter = $stmt->fetch(PDO::FETCH_ASSOC);

if ($mitarbeiter && password_verify($passwort, $mitarbeiter['passwort_hash'])) {
    $_SESSION['mitarbeiter_id'] = $mitarbeiter['mitarbeiter_id'];
    $_SESSION['mitarbeiter_name'] = $mitarbeiter['name'];
    header("Location: mitarbeiter_bestellung.php");
    exit;
}

// 2. Prüfen: Ist es ein Kunde?
$stmt = $db->prepare("SELECT * FROM kunden WHERE benutzername = ?");
$stmt->execute([$benutzername]);
$kunde = $stmt->fetch(PDO::FETCH_ASSOC);

if ($kunde && password_verify($passwort, $kunde['passwort_hash'])) {
    $_SESSION['kunden_id'] = $kunde['kunden_id'];
    $_SESSION['kundenname'] = $kunde['benutzername'];
    header("Location: produkten.php");
    exit;
}

// Wenn beides fehlschlägt:
echo "❌ Benutzername oder Passwort falsch.";
?>