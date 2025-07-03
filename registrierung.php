
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
        echo "✅ Registrierung erfolgreich! <a href='login.php'>Jetzt einloggen</a>";
    } else {
        echo "❌ Fehler bei der Registrierung. E-Mail oder Benutzername existiert vielleicht schon.";
    }
}
?>

<h2>Registrierung</h2>
<form method="post" action="">
    <label>Vorname:</label><br>
    <input type="text" name="vorname" required><br>

    <label>Nachname:</label><br>
    <input type="text" name="nachname" required><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br>

    <label>Adresse:</label><br>
    <input type="text" name="adresse" required><br>

    <label>Benutzername:</label><br>
    <input type="text" name="benutzername" required><br>

    <label>Passwort:</label><br>
    <input type="password" name="passwort" required><br>

    <button type="submit">Registrieren</button>
</form>
