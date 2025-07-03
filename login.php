<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<form method="post" action="login.php">
  <label>Benutzername:</label><br>
  <input type="text" name="benutzername" required><br>
  
  <label>Passwort:</label><br>
  <input type="password" name="passwort" required><br>
  
  <input type="submit" name="login" value="Login">
</form>
<?php
session_start();
require_once 'classes/db.php';
require_once 'classes/Kunde.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $benutzername = $_POST['benutzername'];
    $passwort = $_POST['passwort'];

    $kundeObjekt = new Kunde();
    if ($kundeObjekt->login($benutzername, $passwort)) {
        $kundendaten = $kundeObjekt->getKundendaten($_SESSION['kunde_id']);
        echo "✅ Login erfolgreich! Willkommen, " . htmlspecialchars($kundendaten['vorname']);
         header('Location: produkten.php');
    } else {
        echo "❌ Benutzername oder Passwort ist falsch!";
    }
}
?>
