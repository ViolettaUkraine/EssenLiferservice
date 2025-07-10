<?php
session_start();
require_once 'classes/db.php';

// Prüfen ob Kunde eingeloggt ist
$kunden_id = $_SESSION['kunden_id'] ?? null;
if (!$kunden_id) {
    die('❌ Sie müssen eingeloggt sein.');
}

// Eingaben abholen
$adresse = $_POST['adresse'] ?? '';
$zahlungsart = $_POST['zahlungsart'] ?? '';
$cartJson = $_POST['cart'] ?? '';
$cart = json_decode($cartJson, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$adresse || !$zahlungsart || empty($cart)) {
        die('❌ Ungültige Eingaben.');
    }

    try {
        $pdo = (new Datenbank())->getVerbindung();
        $pdo->beginTransaction();

        // Bestellung speichern
        $stmt = $pdo->prepare("INSERT INTO bestellungen (kunden_id, adresse, zahlungsart, status, erstellt_am)
                               VALUES (?, ?, ?, 'offen', NOW())");
        $stmt->execute([$kunden_id, $adresse, $zahlungsart]);
        $bestellung_id = $pdo->lastInsertId();

        // Bestellpositionen speichern
        $stmt2 = $pdo->prepare("INSERT INTO bestellpositionen (bestellung_id, produkt_id, menge)
                                VALUES (?, ?, ?)");

        $produkte = [];
        foreach ($cart as $item) {
            $stmt2->execute([$bestellung_id, $item['id'], $item['menge']]);
            $produkte[] = [
                'name' => $item['name'],
                'preis' => $item['preis'],
                'menge' => $item['menge']
            ];
        }

        $pdo->commit();

        // Letzte Bestellung in Session speichern
        $_SESSION['letzte_bestellung'] = [
            'adresse' => $adresse,
            'zahlungsart' => $zahlungsart,
            'produkte' => $produkte
        ];

        // Weiterleitung auf Dankeseite
        header('Location: bestellung.php');
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die('❌ Fehler bei der Bestellung: ' . $e->getMessage());
    }
}

// Ab hier: HTML Teil
$bestellung = $_SESSION['letzte_bestellung'] ?? null;
unset($_SESSION['letzte_bestellung']);

$db = (new Datenbank())->getVerbindung();
$stmt = $db->prepare("SELECT * FROM bestellungen WHERE kunden_id = ? ORDER BY erstellt_am DESC");
$stmt->execute([$kunden_id]);
$bestellungen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bestellung</title>
    <link rel="stylesheet" href="style_bestellung.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredericka+the+Great&display=swap" rel="stylesheet">
</head>
<body>
<div class="danke-container">

    <?php if ($bestellung): ?>
        <h1>🎉 Vielen Dank für Ihre Bestellung!</h1>
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
        <h1>📦 Ihre Bestellungen</h1>
    <?php endif; ?>

    <h2>Alle Bestellungen</h2>
    <?php if (empty($bestellungen)): ?>
        <p>Sie haben noch keine Bestellungen.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($bestellungen as $b): ?>
                <li>Bestellung #<?= $b['bestellung_id'] ?> – Status: <?= htmlspecialchars($b['status']) ?> – <?= $b['erstellt_am'] ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="produkten.php" class="btn">Zurück zu den Produkten</a>
    <a href="main.php" class="btn"> Logout</a>
</div>
</body>
</html>