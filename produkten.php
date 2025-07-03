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
            <div class="produkt">
                <h3><?= htmlspecialchars($produkt['name']) ?></h3>
                <p><?= htmlspecialchars($produkt['beschreibung']) ?></p>
                <p><strong><?= number_format($produkt['preis'], 2, ',', '.') ?> €</strong></p>
                <button onclick="addToCart(
                    <?= (int)$produkt['produkt_id'] ?>,
                    <?= json_encode($produkt['name']) ?>,
                    <?= (float)$produkt['preis'] ?>
                )">In den Warenkorb</button>
            </div>
        <?php endforeach; ?>
    </div>

   
    <h2>🛒 Warenkorb</h2>
    <div id="warenkorb"></div>

    <script src="scripts.js"></script>
</body>
</html>