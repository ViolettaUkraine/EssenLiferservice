<?php 
require_once 'classes/Kunde.php';
require_once 'classes/db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrieren'])) {
    if ($_POST['passwort'] !== $_POST['passwort_wiederholen']) {
        echo "Passwörter stimmen nicht überein!";
        exit;
    }
        $kunde = new Kunde();
        $daten = [
            'vorname' => $_POST['vorname'],
            'nachname' => $_POST['nachname'],
            'email' => $_POST['email'],
            'adresse' => $_POST['adresse'],
            'benutzername' => $_POST['benutzername'],
            'passwort' => $_POST['passwort']
        ];
        if ($kunde ->registrieren($daten)) {
            echo "Registrierung erfolgreich!";
        } else {
            echo "Registrierung fehlgeschlagen!";
        }
   
}
?>
<form method="post" action="login.php">
  Vorname:<br>
  <input type="text" name="vorname" required><br>
  Nachname:<br>
  <input type="text" name="nachname" required><br>
  E-Mail:<br>
  <input type="email" name="email" required><br>
  Adresse:<br>
  <input type="text" name="adresse"><br>
  Benutzername:<br>
  <input type="text" name="benutzername" required><br>
  Passwort:<br>
  <input type="password" name="passwort" required><br>
  Passwort wiederholen:<br>
  <input type="password" name="passwort_wiederholen" required><br>
  <input type="submit" name="registrieren" value="Registrieren">
</form>