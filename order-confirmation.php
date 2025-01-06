<?php
session_start();
require 'db.php'; // Pastikan file ini memiliki koneksi MySQLi.

$orderData = ['items' => [], 'discount' => 0, 'subtotal' => 0];
if (isset($_GET['order'])) {
  $orderData = json_decode($_GET['order'], true);
  if (!$orderData || !is_array($orderData['items'])) {
    $orderData = ['items' => [], 'discount' => 0, 'subtotal' => 0];
  }
} else {
  die("Invalid order data.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Ambil data dari form
  $customerName = htmlspecialchars($_POST['customer-name']);
  $phoneNumber = htmlspecialchars($_POST['phone-number']);
  $orderType = htmlspecialchars($_POST['order-type']);
  $paymentMethod = htmlspecialchars($_POST['payment-method']);
  $discount = $orderData['discount'];
  $subtotal = $orderData['subtotal'];
  $total = $subtotal - $discount;

  // Generate nomor pesanan unik
  $orderNumber = 'ORD' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

  $mysqli->begin_transaction();

  try {
    // Simpan ke tabel orders
    $stmt = $mysqli->prepare("
            INSERT INTO orders (order_number, customer_name, phone_number, order_type, payment_method, discount, subtotal, total)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
    $stmt->bind_param(
      'ssssdddi',
      $orderNumber,
      $customerName,
      $phoneNumber,
      $orderType,
      $paymentMethod,
      $discount,
      $subtotal,
      $total
    );
    $stmt->execute();

    // Ambil ID order yang baru disimpan
    $orderId = $stmt->insert_id;

    // Simpan data ke tabel order_items
    $stmtItems = $mysqli->prepare("
            INSERT INTO order_items (order_id, item_name, quantity, price, menu_id)
            VALUES (?, ?, ?, ?, ?)
        ");
    foreach ($orderData['items'] as $item) {
      $stmtItems->bind_param(
        'isidi',
        $orderId,
        $item['name'],
        $item['quantity'],
        $item['price'],
        $item['id']
      );
      $stmtItems->execute();
    }

    // Commit transaksi
    $mysqli->commit();

    // Redirect ke halaman sukses
    header("Location: success.php?order=$orderNumber");
    exit;
  } catch (Exception $e) {
    // Rollback jika ada error
    $mysqli->rollback();
    die("Failed to save order: " . $e->getMessage());
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Order Confirmation</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #252836;
      color: #ffffff;
    }

    .card {
      background-color: #1f1d2b;
      color: #ffffff;
    }

    .list-group {
      background-color: #1f1d2b;
      color: #ffffff;
    }

    .btn-danger {
      background-color: #f2575b;
      border: none;
    }

    .btn-danger:hover {
      background-color: #e94e4e;
    }

    .btn-secondary {
      background-color: #6c757d;
      border: none;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
    }

    .text-muted {
      color: #b0b0b0 !important;
    }

    .form-control,
    .form-select {
      background-color: #252836;
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .form-control::placeholder {
      color: #b0b0b0;
    }

    .form-control:focus,
    .form-select:focus {
      background-color: #252836;
      color: white;
      box-shadow: none;
      border-color: #f2575b;
    }

    .btn-primary {
      background-color: #f2575b !important;
      color: #ffffff;
      border-color: #f2575b !important;
    }

    .modal-content {
      background-color: #1f1d2b !important;
      color: #ffffff;
      font-family: "Poppins", sans-serif;
    }
  </style>
</head>

<body>
  <div class="container py-5">
    <div class="row g-4">
      <!-- Confirmation Section -->
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Confirmation</h5>
            <p class="text-muted">Order #<?php echo $orderData['order_number'] ?? '00001'; ?></p>
            <ul class="list-group list-group-flush mb-3">
              <?php foreach ($orderData['items'] as $item): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <?php echo htmlspecialchars($item['name'] . ' x ' . $item['quantity']); ?>
                  <span>Rp<?php echo number_format($item['quantity'] * $item['price'], 0, ',', '.'); ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
            <div class="d-flex justify-content-between text-muted">
              <p>Discount</p>
              <p>Rp<?php echo number_format($orderData['discount'], 0, ',', '.'); ?></p>
            </div>
            <div class="d-flex justify-content-between fw-bold">
              <p>Subtotal</p>
              <p>Rp<?php echo number_format($orderData['subtotal'] - $orderData['discount'], 0, ',', '.'); ?></p>
            </div>
          </div>
        </div>
      </div>
      <!-- Payment Section -->
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Payment</h5>
            <p class="text-muted">Select a payment method</p>
            <form id="payment-form" method="POST" action="success.php">
              <div class="">
                <label for="payment-method" class="form-label">Payment Method</label>
                <input
                  type="hidden"
                  id="payment-method"
                  name="payment-method" />
                <div class="btn-group w-100 mb-3">
                  <button
                    type="button"
                    class="btn btn-outline-secondary payment-button"
                    data-method="Cash"
                    onclick="setPaymentMethod(this)">
                    Cash
                  </button>
                  <button
                    type="button"
                    class="btn btn-outline-secondary payment-button"
                    data-method="QRIS"
                    onclick="setPaymentMethod(this)">
                    QRIS
                  </button>
                </div>
              </div>
              <div class="mb-3">
                <label for="customer-name" class="form-label">Customer Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="customer-name"
                  name="customer-name"
                  placeholder="Enter customer name"
                  required />
              </div>
              <div class="mb-3">
                <label for="phone-number" class="form-label">Phone Number</label>
                <input
                  type="tel"
                  class="form-control"
                  id="phone-number"
                  name="phone-number"
                  placeholder="Enter phone number"
                  pattern="[0-9]+" />
              </div>
              <div class="mb-3">
                <label for="order-type" class="form-label">Order Type</label>
                <select
                  class="form-select"
                  id="order-type"
                  name="order-type"
                  required>
                  <option value="Dine In">Dine In</option>
                  <option value="Take Away">Take Away</option>
                </select>
              </div>
              <div class="d-flex" >
                <a href="index.php" class="btn btn-secondary px-5">Cancel</a>
                <button
                  type="submit"
                  class="btn btn-primary ms-2"
                  id="confirm-button">
                  Confirm Payment
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function setPaymentMethod(button) {
      // Hapus kelas 'active' dari semua tombol
      document.querySelectorAll('.btn-outline-secondary').forEach(btn => btn.classList.remove('active'));

      // Tambahkan kelas 'active' ke tombol yang dipilih
      button.classList.add('active');

      // Simpan metode pembayaran ke input hidden
      document.getElementById('payment-method').value = button.getAttribute('data-method');

      // Validasi ulang form
      checkFormValidity();
    }

    document.getElementById('payment-form').addEventListener('submit', function(event) {
      event.preventDefault(); // Mencegah form submit secara default

      // Tambahkan spinner pada tombol
      const confirmButton = document.getElementById('confirm-button');
      confirmButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
      confirmButton.disabled = true;

      // Kirim data menggunakan fetch API
      const formData = new FormData(this);
      fetch('order-confirmation.php', {
          method: 'POST',
          body: formData,
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showModal(data); // Tampilkan modal jika sukses
          } else {
            alert(data.message || 'Payment failed. Please try again.');
          }
        })
        .catch(error => {
          alert('An error occurred. Please try again later.');
        })
        .finally(() => {
          // Reset tombol setelah selesai
          confirmButton.innerHTML = 'Confirm Payment';
          confirmButton.disabled = false;
        });
    });

    function showModal(data) {
      // Isi modal dengan data dari server
      document.getElementById('modal-payment-method').innerText = data.paymentMethod;
      document.getElementById('modal-customer-name').innerText = data.customerName;
      document.getElementById('modal-phone-number').innerText = data.phoneNumber;
      document.getElementById('modal-order-type').innerText = data.orderType;

      // Tampilkan modal
      const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
      confirmationModal.show();
    }

    // Event listener untuk tombol selesai pada modal
    document.getElementById('modal-finish-button').addEventListener('click', function() {
      window.location.href = 'index.php'; // Arahkan kembali ke halaman utama
    });

    function checkFormValidity() {
      const paymentMethod = document.getElementById('payment-method').value;
      const customerName = document.getElementById('customer-name').value.trim();
      const orderType = document.getElementById('order-type').value;

      const confirmButton = document.getElementById('confirm-button');
      confirmButton.disabled = !(paymentMethod && customerName && orderType);
    }

    // Tambahkan event listener untuk validasi form
    document.querySelectorAll('#payment-form input, #payment-form select').forEach(input => {
      input.addEventListener('input', checkFormValidity);
    });
  </script>
  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>