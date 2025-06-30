
<form action="" method= "post">
Dein Benutzernahme: <br>
<input type="text" name= "benutzername" placeholder="Benutzername">
Dein Passwort: <br>
<input type="password" name = "passwort" placeholder= "Passwort"><br>
Wiederhole dein Passwort:
<input type="passsword" name= "passwort_wiederholen" placeholder= "Passwort"> <br>
<input type="submit" name="absenden" value = "Absenden"> <br>

</form>

<?php 
require_once 'includes/db.php';
if (isset($_POST['absenden']));

 $benutzername= $_POST['benutzername'];
 $passwort= $_POST['passswort'];
 $passwort_wiederholen= $_POST['passwort_wiederholen'];

$search_user = $db->query("SELECT id FROM kunden WHERE benuzername = ? ");
$search_user->bind_param('s', $benutzername);
$search_user->execute([$benutzername]);

endif;
?>