<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $sql = mysqli_query($conn, $query);

    $result = mysqli_fetch_assoc($sql);

    if ($result) {
        if (password_verify($password, $result['password'])) {
            $_SESSION['email'] = $email;
            header('location: index.php');
            exit;
        } else {
            echo "
                <script>
                    alert('password tidak sesuai');
                    window.location.href = 'login.php';
                </script>";
        }
    } else {
        echo "
            <script>
                alert('email tidak tersedia');
                window.location.href = 'login.php';
            </script>";
    }
}
