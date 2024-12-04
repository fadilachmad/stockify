<?php
require 'connect.php';

function signup($data) {
    global $conn;

    // Ambil dan sanitasi input
    $email = strtolower(stripslashes($data["email"]));
    $username = strtolower(stripslashes($data["username"]));
    $password = $data["password"];
    $confirmPassword = $data["confirmPassword"];

    // Cek apakah email sudah terdaftar
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {
        echo "<script>
                alert('Email already registered.');
            </script>";
        return false;
    }

    // Cek apakah username sudah terdaftar
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {
        echo "<script>
                alert('Username already registered.');
            </script>";
        return false;
    }

    // Cek apakah password dan konfirmasi password cocok
    if ($password !== $confirmPassword) {
        echo "<script>
                alert('Passwords do not match.');
            </script>";
        return false;
    }

    // Enkripsi password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan user baru ke database
    $stmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>
                alert('User registered successfully!');
            </script>";
        return true;
    } else {
        echo "<script>
                alert('Registration failed.');
            </script>";
        return false;
    }
}
?>
