<?php
require_once 'classes/db.php';
require_once 'produkten.php';

$data = json_decode(file_get_contents('php://input'), true);

$adresse = $data['adresse'] ?? '';
$zahlungsart = $data['zahlungsart'] ?? '';
$cart = $data['cart'] ?? [];

if (!$adresse || !$zahlungsart || empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Ungültige Eingabe']);
    exit;
}

try {
    $pdo = DB::getConnection();
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO bestellungen (kunden_id, zahlungsart, status, adresse, erstellt_am)
                           VALUES (NULL, ?, 'offen', ?, NOW())");
    $stmt->execute([$zahlungsart, $adresse]);
    $bestellung_id = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO bestellpositionen (bestellung_id, produkt_id, menge, preis)
                           VALUES (?, ?, ?, ?)");
    foreach ($cart as $item) {
        $stmt->execute([
            $bestellung_id,
            $item['produkt_id'],
            $item['menge'],
            $item['preis']
        ]);
    }

    $pdo->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>