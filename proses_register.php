<?php
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $status = 'active';

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $password, $role, $status);

    if ($stmt->execute()) {
        // Redirect ke halaman login setelah registrasi berhasil
        header("Location: index.php?register=success");
        exit;
    } else {
        // Jika gagal, tetap di halaman ini dan tampilkan pesan
        echo "Registrasi gagal: " . $stmt->error;
    }
    $stmt->close();
}
?>
