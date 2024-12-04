<?php 
    session_start();

    if (isset($_SESSION["login"])) {
        header("Location: index.php");
        exit;
    }

    require 'connect.php';

    if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cek email
        if (count($result) === 1) {

            // Cek password
            $row = $result[0];
            if (password_verify($password, $row["password"])) {
                // Set session
                $_SESSION["login"] = true;
                header("Location: ../index.html");
                exit;
            }
        }

        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-In</title>
</head>
<body>
    <h1>Log-In</h1>

    <?php if (isset($error)) : ?>
        <p style="color: red; font-style: italic;">Username/Password Salah</p>
    <?php endif; ?>

    <form action="" method="post">
        <ul>
            <li>
                <label for="email">Email: </label>
                <input type="text" name="email" id="email">
            </li>
            <li>
                <label for="username">Username: </label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <button type="submit" name="login">Log-In</button>
            </li>
            <li>
                <p>Belum memiliki akun? Klik </p>
                <a href="signup.php" style="text-decoration: none; cursor: pointer;">Daftar</a>
            </li>
        </ul>
    </form>
</body>
</html>