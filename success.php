<?php
session_start();
require 'db.php';

// Cek jika ada parameter 'order' di URL
if (isset($_GET['order'])) {
    $orderNumber = $_GET['order'];
} else {
    die("Order number is missing.");
}

// Ambil informasi order dari database berdasarkan nomor order
$stmt = $mysqli->prepare("SELECT * FROM orders WHERE order_number = ?");
$stmt->bind_param('s', $orderNumber);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if ($order) {
    // Ambil data item order
    $stmtItems = $mysqli->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmtItems->bind_param('i', $order['id']);
    $stmtItems->execute();
    $orderItems = $stmtItems->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    die("Order not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Success</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Order Success</h5>
                        <p class="text-muted">Order #<?php echo htmlspecialchars($order['order_number']); ?></p>
                        <ul class="list-group list-group-flush mb-3">
                            <?php foreach ($orderItems as $item): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($item['item_name'] . ' x ' . $item['quantity']); ?>
                                    <span>Rp<?php echo number_format($item['quantity'] * $item['price'], 0, ',', '.'); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="d-flex justify-content-between text-muted">
                            <p>Discount</p>
                            <p>Rp<?php echo number_format($order['discount'], 0, ',', '.'); ?></p>
                        </div>
                        <div class="d-flex justify-content-between fw-bold">
                            <p>Total</p>
                            <p>Rp<?php echo number_format($order['total'], 0, ',', '.'); ?></p>
                        </div>
                        <a href="index.php" class="btn btn-danger mt-3">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>