<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-biru-m">
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4" style="width: 100%; max-width: 400px">
      <div class="text-center">
        <h4 class="fw-bold">Welcome</h4>
        <p>Please login to your account</p>
      </div>

      <!-- Login Form -->
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
          <label for="login-email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" id="login-email" placeholder="Enter your email" required />
        </div>
        <div class="mb-3">
          <label for="login-password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" id="login-password" placeholder="Enter your password" required />
        </div>
        <button type="submit" class="btn-confirm w-100">Login</button>
        <div class="text-center mt-3">
          <p>
            Don't have an account?
            <a href="#" class="link-light" data-bs-toggle="modal" data-bs-target="#register-modal">Register</a>
          </p>
          <a href="#" class="link-light" data-bs-toggle="modal" data-bs-target="#forgot-password-modal">
            Forgot Password?
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Register Modal -->
  <div class="modal fade" id="register-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Register</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
              <label for="register-name" class="form-label">Name</label>
              <input type="text" name="name" class="form-control" id="register-name" placeholder="Enter your name" required />
            </div>
            <div class="mb-3">
              <label for="register-email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="register-email" placeholder="Enter your email" required />
            </div>
            <div class="mb-3">
              <label for="register-password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="register-password" placeholder="Enter your password" required />
            </div>
            <button type="submit" class="btn-confirm w-100">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Forgot Password Modal -->
  <div class="modal fade" id="forgot-password-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Forgot Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
              <label for="forgot-email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="forgot-email" placeholder="Enter your email" required />
            </div>
            <button type="submit" class="btn-confirm w-100">Send Reset Link</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
