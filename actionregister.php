<?php

require('db.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $confirm_password = $_POST['confirm_password'];

    // echo $username . " - " . $email . " - " . $password . " - " . $confirm_password;
    $query = "INSERT INTO users(username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($query) == TRUE) {
        // echo "akun berhasil didaftarkan";
        echo "
            <script>
                alert('akun berhasil didaftarkan, silahkan login!');
                window.location.href = 'login.php';
            </script>";
    }
    $conn->close();
}
?>
