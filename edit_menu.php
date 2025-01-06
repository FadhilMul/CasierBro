<?php
session_start();
require 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$editMode = isset($_GET['id']); // Jika ada ID di query string, berarti mode edit
$menuItem = null;

// Handle delete request
if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Failed to delete menu item.";
    }
}

if ($editMode) {
    $stmt = $conn->prepare("SELECT * FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $menuItem = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    if ($editMode) {
        $stmt = $conn->prepare("UPDATE menu_items SET name = ?, price = ?, category = ? WHERE id = ?");
        $stmt->bind_param("sdsi", $name, $price, $category, $_GET['id']);
    } else {
        $stmt = $conn->prepare("INSERT INTO menu_items (name, price, category) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $name, $price, $category);
    }

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Failed to save data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $editMode ? "Edit Menu" : "Add Menu"; ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #252836;
            color: #fff;
        }

        .btn-primary {
            background-color: #f2575b !important;
            border-color: #f2575b !important;
        }

        .btn-primary:hover {
            background-color: #e94e4e !important;
            border-color: #e94e4e !important;
        }

        .custom-form .form-control {
            background-color: #252836 !important;
            border-color: #6c757d;
            color: #fff !important;
        }

        .custom-form .form-control:focus {
            border-color: #f2575b;
            box-shadow: 0 0 0 0.2rem rgba(242, 87, 91, 0.25);
            background-color: #fff;
        }

        .custom-form .form-control:hover {
            border-color: #f2575b;
            box-shadow: 0 0 0 0.2rem rgba(242, 87, 91, 0.25);
            background-color: #fff;
        }

        .custom-form .form-select {
            background-color: #252836 !important;
            border-color: #6c757d;
            color: #fff !important;
        }

        .custom-form .form-select:focus {
            border-color: #f2575b !important;
            box-shadow: 0 0 0 0.2rem rgba(242, 87, 91, 0.25);
        }

        .modal-content {
            background-color: #252836 !important;
            border-color: #6c757d;
            color: #fff !important;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1><?php echo $editMode ? "Edit Menu" : "Add Menu"; ?></h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" class="custom-form">
            <div class="mb-3">
                <label for="name" class="form-label">Menu Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($menuItem['name'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($menuItem['price'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="" disabled <?php echo empty($menuItem['category']) ? 'selected' : ''; ?>>Choose Category</option>
                    <option value="promo" <?php echo ($menuItem['category'] ?? '') === 'promo' ? 'selected' : ''; ?>>Promo</option>
                    <option value="foods" <?php echo ($menuItem['category'] ?? '') === 'foods' ? 'selected' : ''; ?>>Foods</option>
                    <option value="snacks" <?php echo ($menuItem['category'] ?? '') === 'snacks' ? 'selected' : ''; ?>>Snacks</option>
                    <option value="drinks" <?php echo ($menuItem['category'] ?? '') === 'drinks' ? 'selected' : ''; ?>>Drinks</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo $editMode ? "Save Changes" : "Add Menu"; ?></button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
            <?php if ($editMode): ?>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    Delete Menu
                </button>
            <?php endif; ?>
        </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <?php if ($editMode): ?>
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this menu item?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form method="POST" style="display: inline;">
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
