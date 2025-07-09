<?php
session_start();
require_once 'classes/db.php';

// Eingaben abholen
$adresse = $_POST['adresse'] ?? '';
$zahlungsart = $_POST['zahlungsart'] ?? '';
$cartJson = $_POST['cart'] ?? '';
$cart = json_decode($cartJson, true);

// Prüfen
if (!$adresse || !$zahlungsart || empty($cart)) {
    die('❌ Ungültige Eingaben.');
}

try {
    $pdo = (new Datenbank())->getVerbindung();
    $pdo->beginTransaction();

    // 🟢 ACHTUNG: Einheitlicher Name!
    $kunden_id = $_SESSION['kunden_id'] ?? null;

    $stmt = $pdo->prepare("INSERT INTO bestellungen (kunden_id, adresse, zahlungsart, status, erstellt_am)
                           VALUES (?, ?, ?, 'offen', NOW())");
    $stmt->execute([$kunden_id, $adresse, $zahlungsart]);
    $bestellung_id = $pdo->lastInsertId();

    $stmt2 = $pdo->prepare("INSERT INTO bestellpositionen (bestellung_id, produkt_id, menge)
                            VALUES (?, ?, ?)");

    // 🟢 Produkte für Session aufbauen
    $produkte = [];

    foreach ($cart as $item) {
        $stmt2->execute([
            $bestellung_id,
            $item['id'],
            $item['menge']
        ]);

        // 🟢 Produkte für spätere Anzeige merken!
        $produkte[] = [
            'name' => $item['name'],
            'preis' => $item['preis'],
            'menge' => $item['menge']
        ];
    }

    $pdo->commit();

    // 🟢 SPEICHERN für die Dankeseite!
    $_SESSION['letzte_bestellung'] = [
        'adresse' => $adresse,
        'zahlungsart' => $zahlungsart,
        'produkte' => $produkte
    ];

    echo '✅ Bestellung erfolgreich!';
} catch (Exception $e) {
    $pdo->rollBack();
    echo '❌ Fehler bei der Bestellung: ' . $e->getMessage();
}
?>

<?php

// Hole letzte Bestellung aus Session
$bestellung = $_SESSION['letzte_bestellung'] ?? null;
unset($_SESSION['letzte_bestellung']); // Nur einmal anzeigen!

// Hole Bestellungen aus DB

$db = (new Datenbank())->getVerbindung();

$stmt = $db->prepare("SELECT * FROM bestellungen WHERE kunden_id = ? ORDER BY erstellt_am DESC");
$stmt->execute([$_SESSION['kunden_id']]);
$bestellungen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<script src="scripts.js"></script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellung</title>
    <link rel="stylesheet" href="style_bestellung.css">
</head>
<body>
<div class="danke-container">

    <h1>🎉 Vielen Dank für Ihre Bestellung!</h1>

    <?php if ($bestellung): ?>
        <p><strong>Adresse:</strong> <?= htmlspecialchars($bestellung['adresse']) ?></p>
        <p><strong>Zahlungsart:</strong> <?= htmlspecialchars($bestellung['zahlungsart']) ?></p>

        <h2>🧾 Zusammenfassung</h2>
        <?php
        $gesamt = 0;
        foreach ($bestellung['produkte'] as $produkt):
            $subtotal = $produkt['preis'] * $produkt['menge'];
            $gesamt += $subtotal;
        ?>
            <div class="produkt">
                <?= htmlspecialchars($produkt['name']) ?> × <?= $produkt['menge'] ?> = <?= number_format($subtotal, 2, ',', '.') ?> €
            </div>
        <?php endforeach; ?>

        <p class="total">Gesamt: <?= number_format($gesamt, 2, ',', '.') ?> €</p>
    <?php else: ?>
        <p>Keine Bestelldaten verfügbar.</p>
    <?php endif; ?>
    <?php
    
    $db = (new Datenbank())->getVerbindung();
        $stmt = $db->prepare("SELECT * FROM bestellungen WHERE kunden_id = ? ORDER BY erstellt_am DESC");

        $stmt->execute([$_SESSION['kunden_id']]);
        $bestellungen = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
    
        <h2>Ihre Bestellungen</h2>
    <?php if (empty($bestellungen)): ?>
        <p>Sie haben noch keine Bestellungen.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($bestellungen as $b): ?>
                <li>Bestellung #<?= $b['bestellung_id'] ?> – Status: <?= $b['status'] ?> – <?= $b['erstellt_am'] ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="produkten.php" class="btn">🔙 Zurück zu den Produkten</a>
    </div>
</body>
</html>