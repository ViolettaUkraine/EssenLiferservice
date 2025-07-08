<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require_once 'classes/db.php';
require_once 'classes/Kunde.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $benutzername = $_POST['benutzername'];
    $passwort = $_POST['passwort'];

    $kundeObjekt = new Kunde();
    if ($kundeObjekt->login($benutzername, $passwort)) {
        header('Location: produkten.php'); // Weiterleitung
        exit;
    } else {
        echo "❌ Benutzername oder Passwort falsch";
    }
}
?>