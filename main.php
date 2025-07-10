<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Startseite</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fredericka+the+Great&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fredericka+the+Great&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style_main.css">
</head>
<body>
  <div class="overlay">
    <h1>Hast du Hunger?</h1>
    <h1>Komm rein!</h1>
    <h1>Wir liefern!</h1>
<div class="button-container">
  <button id="loginBtn">🔐 Login</button>
  <button id="registerBtn">📝 Registrierung</button>
</div>


<div id="loginForm" class="popup hidden">
  <h2>Login</h2>
  <form method="post" action="login.php">
    <label>Benutzername oder E-Mail:</label><br>
    <input type="text" name="benutzername" required><br>
    
    <label>Passwort:</label><br>
    <input type="password" name="passwort" required><br>
    
    <input type="submit" name="login" value="Login">
    
    <p>Kein Konto? <a href="#" id="showRegister">Registrieren</a></p>
  </form>
</div>


<div id="registerForm" class="popup hidden">
  <h2>Registrierung</h2>
  <form  action="main.php" method="post">
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
</div>
  </div>
  <script src="login.js"></script>
</body>
</html>
