<?php
session_start();

if (isset($_SESSION['email'])) {
  header("Location: index.php");
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <style>
    body {
      background-color: #1f1d2b;
      color: #fff;
    }

    .card {
      background-color: #252836;
      color: #fff;
      border: none;
      border-radius: 10px;
    }

    .form-control {
      background-color: #1f1d2b;
      color: #fff;
      border: 1px solid #6c757d;
    }

    .form-control:focus {
      background-color: #1f1d2b;
      border-color: #f2575b;
      color: #fff;
      box-shadow: 0 0 0 0.2rem rgba(242, 87, 91, 0.25);
    }

    .btn-confirm {
      background-color: #f2575b;
      color: #fff;
      border: 1px solid #f2575b;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-confirm:hover {
      background-color: #e94e4e;
    }

    .link-light {
      color: #f2575b;
      text-decoration: none;
    }

    .link-light:hover {
      color: #e94e4e;
      text-decoration: underline;
    }

    .form-control::placeholder {
      color: #6c757d;
    }
  </style>
</head>

<body>
  <div
    class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4" style="width: 100%; max-width: 400px">
      <div class="text-center">
        <h4 class="fw-bold">Welcome</h4>
        <p>Please login to your account</p>
      </div>

      <!-- Login Form -->
      <form id="login-form" action="actionlogin.php" method="POST">
        <input type="hidden" name="action" value="login" />
        <div class="mb-3">
          <label for="login-email" class="form-label">Email</label>
          <input type="email" class="form-control" id="login-email" name="email" placeholder="Enter your email" required />
        </div>
        <div class="mb-3">
          <label for="login-password" class="form-label">Password</label>
          <input type="password" class="form-control" id="login-password" name="password" placeholder="Enter your password" required />
        </div>
        <button type="submit" class="btn-confirm w-100">Login</button>
        <div class="text-center mt-3">
          <p>Don't have an account?<a href="register.php" class="link-light">Register</a></p>
          <a href="#" class="link-light">Forgot Password?</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
