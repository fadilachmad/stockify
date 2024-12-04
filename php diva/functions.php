<?php
    require 'connect.php';

    function signup($data) {
        global $conn;

        $email = strtolower(stripslashes($data["email"]));
        $username = strtolower(stripslashes($data["username"]));
        $password = mysqli_real_escape_string($conn, $data["password"]);
        $password2 = mysqli_real_escape_string($conn, $data["password2"]);

        // Cek email dan username sudah ada atau belum
        $result = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");

        if (mysqli_fetch_assoc ($result)) {
            echo "<script>
                    alert('Email already registered.');
                </script>";
            return false;
        }

        $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

        if (mysqli_fetch_assoc ($result)) {
            echo "<script>
                    alert('Username already registered.');
                </script>";
            return false;
        }

        // Cek konfirmasi password
        if ($password !== $password2) {
            echo "<script>
                    alert('Password doesn't match.');
                </script>";
            return false;
        }

        // Enkripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Tambahkan user baru ke database
        mysqli_query($conn, "INSERT INTO users VALUES ('', '$email', '$username', '$password')");

        return mysqli_affected_rows($conn);
    }
?>