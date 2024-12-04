<?php
    require 'functions.php';

    if (isset($_POST["signup"])) {
        try {
            if (signup($_POST) > 0) {
                echo "<script>
                        alert('Successfully added new user.');
                    </script>";
            } else {
                echo "<script>
                        alert('Failed to add new user.');
                    </script>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up</title>
</head>
<body>
    <h1>Sign-Up</h1>

    <form action="" method="post">
        <ul>
            <li>
                <label for="email">E-Mail: </label>
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
                <label for="confirmPassword">Confirm Password: </label>
                <input type="password" name="confirmPassword" id="confirmPassword">
            </li>
            <li>
                <button type="submit" name="signup">Sign-Up</button>
            </li>
        </ul>
    </form>
</body>
</html>