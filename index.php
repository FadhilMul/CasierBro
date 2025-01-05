<?php
session_start();
require 'db.php';

if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}

$stmt = $conn->query("SELECT * FROM menu_items");
$menuItems = $stmt->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MENU</title>
  <link rel="stylesheet" href="style.css" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous" />
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
    rel="stylesheet" />
</head>

<body>
  <div class="d-flex">
    <!-- Left Sidebar -->
    <div class="left-sidebar bg-biru-t" id="sidebar">
      <!-- Logo -->
      <div class="logo-container">
        <div class="logo">LOGO</div>
      </div>
      <div class="nav-content">
        <div class="nav flex-column mt-3">
          <a href="#" class="sidebar-link active">
            <i class="bi bi-shop fs-5"></i>
            <span>Menu</span>
          </a>
          <a href="#" class="sidebar-link">
            <i class="bi bi-pie-chart fs-5"></i>
            <span>Dashboard</span>
          </a>
          <a href="#" class="sidebar-link">
            <i class="bi bi-clock-history fs-5"></i>
            <span>History</span>
          </a>
          <a href="#" class="sidebar-link">
            <i class="bi bi-gear fs-5"></i>
            <span>Setting</span>
          </a>
        </div>

        <!-- Logout Button -->
        <div class="logout-container mt-auto">
          <a href="logout.php" class="logout-button"> <!-- Logout link -->
            <i class="bi bi-box-arrow-right fs-5"></i>
            <span>Logout</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="bg-biru-m main-content flex-grow-1">
      <!-- Header with Title, Date, and Search -->
      <div class="header-container bg-biru-m">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <h3 class="mb-1">Dashboard</h3>
            <div class="date-text">
              <span id="current-date"></span>
            </div>
          </div>
          <form role="search">
            <div class="search-container">
              <div class="input-group">
                <input
                  type="text"
                  id="menu-search"
                  class="form-control"
                  placeholder="Cari..." />
                <button class="btn btn-outline-secondary" type="button">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Rest of the content -->
      <div class="p-3">
        <div class="category-container">
          <h5>Category</h5>
          <div class="d-flex flex-wrap gap-2">
            <button class="category-btn active" data-category="all">
              All
            </button>
            <button class="category-btn" data-category="promo">Promo</button>
            <button class="category-btn" data-category="foods">Foods</button>
            <button class="category-btn" data-category="snacks">
              Snacks
            </button>
            <button class="category-btn" data-category="drinks">
              Drinks
            </button>
          </div>
        </div>
        <div class="d-flex" style="justify-content: space-between;">
          <h5 class="mt-2">Choose Menu</h5>
          <a href="edit_menu.php" class="btn btn-secondary me-3">Add Menu</a>
        </div>

        <div class="menu-container mt-4">
          <?php foreach ($menuItems as $item): ?>
            <div class="menu-item-card" data-category="<?php echo htmlspecialchars($item['category']); ?>">
              <div class="menu-image"></div>
              <div class="d-flex justify-content-around">
                <div class="menu-details text-start pe-4">
                  <p class="menu-name"><?php echo htmlspecialchars($item['name']); ?></p>
                  <p class="menu-price">Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></p>
                </div>
                <button class="add-to-cart-btn">
                  <span>+</span>
                </button>
              </div>
              <div class="mt-2">
                <button class="btn btn-secondary btn-sm px-5" onclick="location.href='edit_menu.php?id=<?php echo $item['id']; ?>';">Edit</button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Right Sidebar -->
    <div class="right-sidebar">
      <h5>Orders</h5>
      <div class="d-flex flex-wrap gap-2 mb-3">
        <button class="type-order-btn">Dine In</button>
        <button class="type-order-btn">Take Away</button>
      </div>

      <!-- Wrapper untuk order content dan summary -->
      <div class="order-wrapper">
        <!-- Scrollable area -->
        <div class="order-content">
          <div class="order-items-container">
            <!-- order pake javascript -->
          </div>
        </div>

        <!-- Summary section -->
        <div class="order-summary">
          <div class="d-flex justify-content-between">
            <span>Discount</span>
            <span class="discount-value">Rp 0</span>
          </div>
          <div class="d-flex justify-content-between">
            <span>Sub Total</span>
            <span class="subtotal-value">Rp 0</span>
          </div>
        </div>
      </div>

      <a href="order-confirmation.php" class="continue-btn w-100 mt-4">
        Continue to Payment
      </a>
    </div>
  </div>

  <script src="script.js"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>