<?php
// Koneksi ke database
$servername = "localhost"; // Sesuaikan dengan konfigurasi Anda
$username = "root";        // Sesuaikan dengan username database Anda
$password = "";            // Sesuaikan dengan password database Anda
$dbname = "tesaja";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}