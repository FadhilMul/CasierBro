<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Items</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
        rel="stylesheet"
    />
</head>
<body class="bg-biru-m">
    <!-- Sidebar -->
    <div class="left-sidebar bg-biru-t">
        <div class="logo-container">
            <div class="logo">LOGO</div>
        </div>
        <div class="nav-content">
            <a href="#" class="sidebar-link active"><i class="bi bi-shop fs-5"></i> Menu</a>
            <a href="#" class="sidebar-link"><i class="bi bi-pie-chart fs-5"></i> Dashboard</a>
            <a href="#" class="sidebar-link"><i class="bi bi-clock-history fs-5"></i> History</a>
            <a href="#" class="sidebar-link"><i class="bi bi-gear fs-5"></i> Settings</a>
        </div>
        <div class="logout-container">
            <a href="#" class="logout-button">
                <i class="bi bi-box-arrow-right fs-5"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header-container">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="mb-1">Menu Items</h3>
                    <div class="date-text"><span id="current-date"></span></div>
                </div>
                <form role="search">
                    <div class="search-container">
                        <div class="input-group">
                            <input type="text" id="menu-search" class="form-control" placeholder="Search..." />
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Category Section -->
        <div class="category-container">
            <div class="d-flex flex-wrap gap-2">
                <button class="category-btn active" data-category="all">All</button>
                <button class="category-btn" data-category="foods">Foods</button>
                <button class="category-btn" data-category="drinks">Drinks</button>
                <button class="category-btn" data-category="snacks">Snacks</button>
                <button class="category-btn" data-category="promo">Promo    </button>
            </div>
        </div>

        <!-- Menu Items -->
        <div class="menu-container">
            @foreach ($menuItems as $item)
                <div class="menu-item-card" data-category="{{ $item->category }}">
                    <div class="menu-image"></div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="menu-name">{{ $item->name }}</p>
                            <p class="menu-price">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <button class="add-to-cart-btn">+</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="right-sidebar">
        <h5>Orders</h5>
        <div class="d-flex flex-wrap gap-2 mb-3">
            <button class="type-order-btn">Dine In</button>
            <button class="type-order-btn">Take Away</button>
        </div>

        <!-- Order Items -->
        <div class="order-wrapper">
            <div class="order-content">
                <div class="order-items-container"></div>
            </div>
            <div class="order-summary">
                <div class="d-flex justify-content-between">
                    <span>Discount</span>
                    <span class="discount-value">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <span class="subtotal-value">Rp 0</span>
                </div>
            </div>
        </div>
        <a href="{{ route('order-confirmation') }}" class="continue-btn w-100 mt-4">Continue to Payment</a>
    </div>

    <!-- Include Script -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
