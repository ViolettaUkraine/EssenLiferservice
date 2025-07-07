<?php
header('Content-Type: application/json');
require_once 'classes/db.php';


$data = json_decode(file_get_contents('php://input'), true);

$adresse = $data['adresse'] ?? '';
$zahlungsart = $data['zahlungsart'] ?? '';
$cart = $data['cart'] ?? [];
$zahlungsart = $data['zahlungsart'] ?? '';

if (!$adresse || !$zahlungsart || empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Ungültige Eingabe']);
    exit;
}

try {
    $pdo = (new Datenbank())->getVerbindung();
    $pdo->beginTransaction();

     $kunde_id = $_SESSION['kunde_id'] ?? null;

    $stmt = $pdo->prepare("INSERT INTO bestellungen (kunden_id, adresse, zahlungsart, status, erstellt_am)
                           VALUES (?, ?, ?, 'offen', NOW())");
    $stmt->execute([$kunde_id, $adresse, $zahlungsart]);
    $bestellung_id = $pdo->lastInsertId();

    $stmt2 = $pdo->prepare("INSERT INTO bestellpositionen (bestellung_id, produkt_id, menge)
                            VALUES (?, ?, ?)");

    foreach ($cart as $item) {
        $stmt2->execute([
            $bestellung_id,
            $item['produkt_id'],
            $item['menge']
        ]);
    }

    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>