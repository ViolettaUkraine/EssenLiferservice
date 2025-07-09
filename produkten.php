<?php
require_once 'classes/db.php';
require_once 'classes/Produkt.php';

$produkteObjekt = new Produkte();
$produkte = $produkteObjekt->getAlleProdukte();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Unsere Produkte</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h1>🍽️ Unsere Produkte</h1>

    <div id="produktliste">
       <?php foreach ($produkte as $produkt): ?>
    <?php
        $id = (int)$produkt['produkt_id'];
        $name = json_encode($produkt['name']); // Erzeugt z. B. "Brot" mit doppelten Anführungszeichen
        $preis = json_encode((float)$produkt['preis']); // z. B. 2.5
    ?>
    <div class="produkt">
        <h3><?= htmlspecialchars($produkt['name']) ?></h3>
        <p><?= htmlspecialchars($produkt['beschreibung']) ?></p>
        <p><strong><?= number_format($produkt['preis'], 2, ',', '.') ?> €</strong></p>

        <!-- 💡 Wichtig: onclick muss EINE korrekte JavaScript-Zeile ergeben -->
        <button onclick='addToCart(<?= $id ?>, <?= $name ?>, <?= $preis ?>)'>In den Warenkorb</button>
    </div>
<?php endforeach; ?>
    </div>

<h2>🛒 Warenkorb</h2>
<div id="warenkorb"></div>

<h2>📦 Bestellung aufgeben</h2>
<form id="checkoutForm" method="POST" action="bestellung.php">
    <label>Adresse: <input type="text" name="adresse" required /></label><br>
    <label>Zahlungsart:
        <select name="zahlungsart" required>
            <option value="bar">Bar</option>
            <option value="karte">Karte</option>
            <option value="paypal">PayPal</option>
            <option value="überweisung">Überweisung</option>
        </select>
    </label><br>

    <!-- Hier kommt das versteckte Warenkorb-Feld rein -->
    <input type="hidden" name="cart" id="cartInput" />

    <button type="submit">Bestellung abschicken</button>
</form>

    <script src="scripts.js"></script>
</body>
</html>