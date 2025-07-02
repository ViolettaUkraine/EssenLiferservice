<form method="post" action="login.php">
  Benutzername:<br>
  <input type="text" name="benutzername" required><br>
  Passwort:<br>
  <input type="password" name="passwort" required><br>
  <input type="submit" name="login" value="Login">
</form>

<?php
session_start();
require_once 'classes/db.php'; // Datenbankverbindung
require_once 'classes/Kunde.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $benutzername = $_POST['benutzername'];
    $passwort = $_POST['passwort'];

    $kunde = new Kunde();

    if ($kunde->login($benutzername, $passwort)) {
        echo "✅ Login erfolgreich! Willkommen, $benutzername";
        // Weiterleitung möglich: header('Location: dashboard.php');
    } else {
        echo "❌ Benutzername oder Passwort ist falsch!";
    }
}
?>
