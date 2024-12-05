<?php 
session_start();

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

require 'config/conn.php';

if (isset($_POST["login"])) {
    $emailOrUsername = $_POST["emailOrUsername"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :emailOrUsername OR email = :emailOrUsername");
    $stmt->bindParam(':emailOrUsername', $emailOrUsername);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if (password_verify($password, $result["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["username"] = $result["username"];
            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              montserrat: ["Montserrat", "sans-serif"],
            },
            colors: {
              primary: "#1A2BC3",
              secondary: "#FFDE59",
              compliment: "#0E0F52",
              bone: "#FEFDF8",
            },
          },
        },
      };
    </script>
  </head>
  <body>
    <main
      class="bg-primary font-montserrat h-screen flex items-center justify-center flex-col px-2"
    >
      <h1 class="text-2xl md:text-3xl font-semibold text-bone mb-5">
        Log In to Stockify
      </h1>

      <?php if (isset($error)) : ?>
        <p style="color: red; font-style: italic;"> Invalid Username/Password</p>
      <?php endif; ?>

      <form action="" method="post" class="md:w-1/4">
        <input
          type="text"
          name="emailOrUsername"
          id="emailOrUsername"
          class="bg-compliment mb-2 text-bone text-xs h-10 w-full p-3 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
          placeholder="Email or Username"
        />
        <input
          type="password"
          name="password"
          id="password"
          class="bg-compliment mb-2 text-bone text-xs h-10 w-full p-3 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
          placeholder="Password"
        />
        <button
          type="submit" name="login"
          class="bg-bone text-primary w-full text-xs py-2 px-4 rounded-sm md:text-base flex items-center justify-center hover:bg-slate-200"
        >
          Login
        </button>
      </form>
      <p class="text-xs md:text-sm text-bone text-center md:w-1/2 mt-2">
        Don't have an account?
        <a href="signup.php" class="text-secondary">Register</a>
      </p>
    </main>
  </body>
</html>