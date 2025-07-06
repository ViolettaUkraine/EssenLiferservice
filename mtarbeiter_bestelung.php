<?php
require_once 'classes/db.php';

$pdo = DB::getVerbindung();

// Hol alle Bestellungen
$stmt = $pdo->query("SELECT * FROM bestellungen ORDER BY erstellt_am DESC");
$bestellungen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bestellungen verwalten</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
    </style>
</head>
<body>
    <h1>🧾 Bestellungen verwalten</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Adresse</th>
            <th>Zahlungsart</th>
            <th>Status</th>
            <th>Erstellt am</th>
            <th>Aktion</th>
        </tr>
        <?php foreach ($bestellungen as $b): ?>
            <tr>
                <td><?= $b['bestellung_id'] ?></td>
                <td><?= htmlspecialchars($b['adresse']) ?></td>
                <td><?= htmlspecialchars($b['zahlungsart']) ?></td>
                <td><?= htmlspecialchars($b['status']) ?></td>
                <td><?= $b['erstellt_am'] ?></td>
                <td><a href="bestellung_details.php?id=<?= $b['bestellung_id'] ?>">Details</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>