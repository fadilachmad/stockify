<?php
    require 'functions.php';

    if (isset($_POST["signup"])) {
        try {
            if (signup($_POST) > 0) {
                session_start();
                echo "<script>
                        alert('Successfully added new user.');
                    </script>";

                $_SESSION["login"] = true;
                $_SESSION["username"] = $_POST["username"];
                header("Location: index.php");
                exit;
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
        Sign Up to Stockify
      </h1>
      <form action="signup.php" method="post" class="md:w-1/4">
        <input
          type="text"
          name="username"
          id="username"
          class="bg-compliment mb-2 text-bone text-xs h-10 w-full p-3 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
          placeholder="Username"
        />
        <input
          type="email"
          name="email"
          id="email"
          class="bg-compliment mb-2 text-bone text-xs h-10 w-full p-3 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
          placeholder="Email"
        />
        <input
          type="password"
          name="password"
          id="password"
          class="bg-compliment mb-2 text-bone text-xs h-10 w-full p-3 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
          placeholder="Password"
        />
        <input
          type="password"
          name="confirmPassword"
          id="confirmPassword"
          class="bg-compliment mb-2 text-bone text-xs h-10 w-full p-3 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
          placeholder="Confirm Password"
        />
        <button
          type="submit" name="signup"
          class="bg-bone text-primary w-full text-xs py-2 px-4 rounded-sm md:text-base flex items-center justify-center hover:bg-slate-200"
        >
          Register
        </button>
      </form>
      <p class="text-xs md:text-sm text-bone text-center md:w-1/2 mt-2">
        Already have an account?
        <a href="login.php" class="text-secondary">Login</a>
      </p>
    </main>
  </body>
</html>
