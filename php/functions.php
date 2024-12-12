<?php
require 'config/conn.php';

function signup($data) {
    global $pdo;

    $email = strtolower(trim($data["email"]));
    $username = strtolower(trim($data["username"]));
    $password = $data["password"];
    $confirmPassword = $data["confirmPassword"];

    // Cek email
    $stmt = $pdo->prepare("SELECT email FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->fetch()) {
        echo "<script>
                alert('Email already registered.');
            </script>";
        return false;
    }

    // Cek username
    $stmt = $pdo->prepare("SELECT username FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    if ($stmt->fetch()) {
        echo "<script>
                alert('Username already registered.');
            </script>";
        return false;
    }

    // Cek password
    if ($password !== $confirmPassword) {
        echo "<script>
                alert('Passwords do not match.');
            </script>";
        return false;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user ke database
    $stmt = $pdo->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>
                alert('Successfully added new user.');
            </script>";
        return true;
    } else {
        // echo "<script>
        //         alert('Registration failed.');
        //     </script>";
        return false;
    }
}

function search($keyword) {
    global $pdo;
    $sql = "SELECT * FROM product 
            WHERE LOWER(name) LIKE LOWER(:keyword) 
            OR LOWER(category) LIKE LOWER(:keyword) 
            OR LOWER(CAST(price AS TEXT)) LIKE LOWER(:keyword) 
            OR LOWER(CAST(quantity AS TEXT)) LIKE LOWER(:keyword) 
            OR LOWER(description) LIKE LOWER(:keyword)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isStrongPassword($password) {
    $errors = [];
    
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter.";
    }
    if (!preg_match('/\d/', $password)) {
        $errors[] = "Password must contain at least one digit.";
    }
    if (!preg_match('/[\W_]/', $password)) {
        $errors[] = "Password must contain at least one special character.";
    }

    return $errors;
}

?>
