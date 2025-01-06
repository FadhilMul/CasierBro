<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body class="bg-biru-m">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Confirmation Section -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Confirmation</h5>
                        <p class="text-muted">Order #00001</p>
                        <ul class="list-group list-group-flush mb-3">
                            @foreach ($orderData['items'] as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item['name'] }} x {{ $item['quantity'] }}
                                    <span>Rp{{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="d-flex justify-content-between text-muted">
                            <p>Discount</p>
                            <p>Rp{{ number_format($orderData['discount'], 0, ',', '.') }}</p>
                        </div>
                        <div class="d-flex justify-content-between fw-bold">
                            <p>Subtotal</p>
                            <p>Rp{{ number_format($orderData['subtotal'] - $orderData['discount'], 0, ',', '.') }}</p>
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
                        <form id="payment-form">
                            <div class="btn-group w-100 mb-3">
                                <button type="button" class="btn btn-outline-secondary payment-button" data-method="Cash" onclick="toggleActive(this)">
                                    Cash
                                </button>
                                <button type="button" class="btn btn-outline-secondary payment-button" data-method="QRIS" onclick="toggleActive(this)">
                                    QRIS
                                </button>
                            </div>
                            <input type="hidden" id="payment-method" name="payment-method" />
                            <div class="mb-3">
                                <label for="customer-name" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="customer-name" name="customer-name" placeholder="Enter customer name" required />
                            </div>
                            <div class="mb-3">
                                <label for="phone-number" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone-number" name="phone-number" placeholder="Enter phone number" pattern="[0-9]+" required />
                            </div>
                            <div class="mb-3">
                                <label for="order-type" class="form-label">Order Type</label>
                                <select class="form-select" id="order-type" name="order-type" required>
                                    <option value="Dine In">Dine In</option>
                                    <option value="Take Away">Take Away</option>
                                </select>
                            </div>
                            <div class="d-flex">
                                <button type="button" class="btn btn-secondary me-2 flex-grow-1" onclick="window.location.href='{{ url('/') }}'">Cancel</button>
                                <button type="submit" class="btn btn-danger flex-grow-1" id="confirm-button" disabled>Confirm Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Payment Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your payment has been confirmed successfully!</p>
                    <p>Payment Method: <span id="modal-payment-method"></span></p>
                    <p>Customer Name: <span id="modal-customer-name"></span></p>
                    <p>Phone Number: <span id="modal-phone-number"></span></p>
                    <p>Order Type: <span id="modal-order-type"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="modal-finish-button">Selesai</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
