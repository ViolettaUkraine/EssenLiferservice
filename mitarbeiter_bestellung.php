<?php
session_start();
require_once 'classes/db.php';
require_once 'classes/Bestellung_class.php';

if (!isset($_SESSION['mitarbeiter_id'])) {
    die("Bitte zuerst einloggen.");
}

$db = (new Datenbank())->getVerbindung();
$bestellung = new Bestellung();

// Offene und in Bearbeitung befindliche Bestellungen laden
$stmt = $db->query("
    SELECT b.*, 
           k.vorname, 
           k.nachname AS kundenname, 
           m.name AS mitarbeitername,
           mb.mitarbeiter_id AS bearbeiter_id
    FROM bestellungen b
    JOIN kunden k ON b.kunden_id = k.kunden_id
    LEFT JOIN mitarbeiter_bestellungen mb ON b.bestellung_id = mb.bestellung_id
    LEFT JOIN mitarbeiter m ON mb.mitarbeiter_id = m.mitarbeiter_id
    ORDER BY b.erstellt_am DESC;
");
$bestellungen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mitarbeiter-Dashboard</title>
    <style>
        body {
             background-image: url('8.png');
        }
        h1 { color: white; }
        h2{ color: white; }
        body { font-family: Arial; margin: 40px; background-color: black; }
        table { width: 100%; border-collapse: collapse; background: #f9f9f9; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left;  }
        th { background: #eee; }
        form { display: inline; }
        .actions button { padding: 5px 10px; }
    </style>
</head>
<body>

<h1>Willkommen, <?php echo htmlspecialchars($_SESSION['mitarbeiter_name']); ?>!</h1>
<h2>Bestellungen</h2>

<table>
    <tr>
        <th>Bestell-ID</th>
        <th>Kunde</th>
        <th>Status</th>
        <th>Bearbeiter</th>
        <th>Erstellt am</th>
        <th>Aktionen</th>
    </tr>
    <?php foreach ($bestellungen as $b): ?>
        <tr>
            <td><?= $b['bestellung_id'] ?></td>
            <td><?= htmlspecialchars($b['kundenname']) ?></td>
            <td><?= $b['status'] ?></td>
            <td><?= $b['mitarbeitername'] ?? '-' ?></td>
            <td><?= $b['erstellt_am'] ?></td>
                   <td class="actions">
                <?php if ($b['status'] === 'offen'): ?>
                    <form method="post" action="bestellung_bearbeiten.php">
                        <input type="hidden" name="bestellung_id" value="<?= $b['bestellung_id'] ?>">
                        <input type="hidden" name="aktion" value="uebernehmen">
                        <button type="submit">Übernehmen</button>
                    </form>
                <?php elseif ($b['status'] === 'in_bearbeitung' && $b['bearbeiter_id'] == $_SESSION['mitarbeiter_id']): ?>
                    <form method="post" action="bestellung_bearbeiten.php">
                        <input type="hidden" name="bestellung_id" value="<?= $b['bestellung_id'] ?>">
                        <input type="hidden" name="aktion" value="unterwegs">
                        <button type="submit">Unterwegs</button>
                    </form>
                    <form method="post" action="bestellung_bearbeiten.php">
                        <input type="hidden" name="bestellung_id" value="<?= $b['bestellung_id'] ?>">
                        <input type="hidden" name="aktion" value="ausgeliefert">
                        <button type="submit">Ausgeliefert</button>
                    </form>
                <?php else: ?>
                    Keine Aktion
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>