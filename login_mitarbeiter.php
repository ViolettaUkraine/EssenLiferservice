<?php 
session_start();
require_once 'classes/db.php';      

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $db =(new Datenbank())->getVerbindung();
    $stmt =$db->prepare("SELECT * FROM mitarbeiter WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    $mitarbeiter = $stmt->fetch(PDO::FETCH_ASSOC);
     if ($mitarbeiter && password_verify($_POST['passwort'], $mitarbeiter['passwort_hash'])) {
        $_SESSION['mitarbeiter_id'] = $mitarbeiter['mitarbeiter_id'];
        $_SESSION['mitarbeiter_name'] = $mitarbeiter['name'];
        header("Location: mitarbeiter_bestellung.php");
        exit;
    } else {
        echo "Login fehlgeschlagen!";
    }
}

?>
