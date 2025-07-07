<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Startseite</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <style>
    
{
    margin: 0;
    padding: 0;
    box-sizing: border-box;}

    body {
      background-image: url('8.png'); /* Hintergrundbild */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.6); / Abdunklung */
      padding: 60px 30px;
      box-shadow: 0 0 20px rgba(202, 105, 14, 0.5);
    }

    h1 {
      color: #fff;
      font-size: 64px;
      margin-bottom: 20px;
      margin: 10px;
    }

    h2 {
      color: #fff;
      font-size: 40px;
      margin-bottom: 40px;
    }

    .button-container {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    button {
      background-color: #ff5722;
      color: white;
      border: none;
      padding: 18px 30px;
      margin: 20px;
      font-size: 18px;
      
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }

    button:hover {
      background-color: #e64a19;
      transform: scale(1.05);
    }
@media (max-width: 600px) {
      h1 { font-size: 48px; }
      h2 { font-size: 30px; }
      button { font-size: 16px; padding: 12px 24px; }
    }
    .hidden {
  display: none;
}

.popup {
  background: rgba(114, 50, 14, 0.9);
  padding: 30px;
  border-radius: 10px;
  position: absolute;
  top: 20%;
  left: 50%;
  transform: translateX(-50%);
  box-shadow: 0 0 20px rgba(0,0,0,0.5);
}
  </style>
</head>
<body>
  <div class="overlay">
    <h1>Hast du Hunger?</h1>
    <h1>Komm rein!</h1>
    <h2>Wir liefern!</h2>
<div class="button-container">
  <button id="loginBtn">🔐 Login</button>
  <button id="registerBtn">📝 Registrierung</button>
</div>


<div id="loginForm" class="popup hidden">
  <h2>Login</h2>
  <form method="post" action="login.php">
    <label>Benutzername:</label><br>
    <input type="text" name="benutzername" required><br>
    <label>Passwort:</label><br>
    <input type="password" name="passwort" required><br>
    <input type="submit" name="login" value="Login">
    <p>Kein Konto? <a href="#" id="showRegister">Registrieren</a></p>


  </form>
</div>


<div id="registerForm" class="popup hidden">
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
</div>
  </div>
  <script src="scripts.js"></script>
</body>
</html>
