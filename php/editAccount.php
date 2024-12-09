<?php 
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

require 'config/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $username_input = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $user_bio = htmlspecialchars(trim($_POST['user_bio']));

    if (!empty($username_input) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $query = "INSERT INTO users (username, email, user_bio, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $pdo->prepare($query);

        if ($stmt) {
            $stmt->bindValue(1, $username_input, PDO::PARAM_STR);
            $stmt->bindValue(2, $email, PDO::PARAM_STR);
            $stmt->bindValue(3, $user_bio, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $message = "Data saved successfully.";
            } else {
                $message = "Failed to save data.";
            }

            $stmt = null;
        } else {
            $message = "Terjadi kesalahan pada query.";
        }
    } else {
        $message = "Invalid input. Make sure all the fields are filled correctly.";
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
  <body class="bg-primary font-montserrat">
    <div class="content md:grid grid-cols-12">
     <!-- Sidebar -->
     <div class="sidebar col-span-2 hidden md:block bg-bone h-screen">
        <ul>
          <li class="font-extrabold text-compliment text-center my-4 text-xl">
            Stockify
          </li>
          <li
            class="hover:border-b border-compliment hover:bg-secondary hover:bg-opacity-20"
          >
            <a href="index.php" class="p-4 flex items-center">
              <ion-icon
                name="file-tray-full-outline"
                class="text-2xl ml-3 mr-10"
              ></ion-icon>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="bg-secondary bg-opacity-75 border-r-4 border-compliment">
            <a href="addProduct.php" class="p-4 flex items-center">
              <ion-icon name="create" class="text-2xl ml-3 mr-10"></ion-icon>
              <p>Add Product</p>
            </a>
          </li>
          <li
            class="hover:border-b border-compliment hover:bg-secondary hover:bg-opacity-20"
          >
            <a href="account.php" class="p-4 flex items-center">
              <ion-icon
                name="cafe-outline"
                class="text-2xl ml-3 mr-10"
              ></ion-icon>
              <p>Account</p>
            </a>
          </li>
          <li
            class="hover:border-b border-compliment hover:bg-secondary hover:bg-opacity-20"
          >
            <a href="contactUs.php" class="p-4 flex items-center">
              <ion-icon
                name="chatbubbles-outline"
                class="text-2xl ml-3 mr-10"
              ></ion-icon>
              <p>Contact Us</p>
            </a>
          </li>
        </ul>
      </div>
      <!-- End Sidebar -->

      <main class="m-3 col-span-10">
        <header class="flex justify-between">
          <h1 class="greet font-extrabold text-2xl text-bone">
            Hi, <?php echo htmlspecialchars($username); ?>!
          </h1>
          <button class="bg-bone px-2 py-1 rounded-sm text-primary text-xs">
            Logout
          </button>
        </header>

        <div
          class="menu-info mt-3 flex flex-wrap justify-center md:justify-start"
        >
          <div class="profile bg-compliment rounded-sm size-64 flex">
            <ion-icon
              name="person-circle"
              class="size-full text-primary"
            ></ion-icon>
          </div>
          <div class="info md:mx-4 mr-auto pl-2 mt-2 mb-20 ml-2">
            <?php if (isset($message)): ?>
              <p class="text-bone"><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="" method="POST">
              <div class="username mb-4">
                <h2 class="text-bone font-semibold md:text-xl">Username</h2>
                <input
                  type="text"
                  name="username"
                  id="username"
                  class="bg-compliment mb-2 text-bone text-xs h-8 w-full md:w-96 p-3 md:h-12 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
                  placeholder="Username"
                />
              </div>
              <div class="email mb-4">
                <h2 class="text-bone font-semibold md:text-xl">Email</h2>
                <input
                  type="email"
                  name="email"
                  id="email"
                  class="bg-compliment mb-2 text-bone text-xs h-8 w-full md:w-96 p-3 md:h-12 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
                  placeholder="email@gmail.com"
                />
              </div>
              <div class="bio mb-4">
                <h2 class="text-bone font-semibold md:text-xl">Bio</h2>
                <textarea
                  name="user_bio"
                  id="user_bio"
                  class="bg-compliment mb-2 text-bone text-xs w-full md:w-96 p-3 md:h-24 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
                  placeholder="Write something about yourself..."
                ></textarea>
              </div>
              <div class="btn-wrapper flex">
                <button
                  type="reset"
                  class="bg-slate-300 mr-5 text-red-600 text-xs py-2 px-4 rounded-sm md:text-base flex items-center justify-between hover:bg-bone"
                >
                  <ion-icon name="close-outline"></ion-icon>
                  <p class="ml-2">Cancel</p>
                </button>
                <button
                  type="submit"
                  name="submit"
                  class="bg-bone text-primary text-xs py-2 px-4 rounded-sm md:text-base flex items-center justify-between hover:bg-slate-200"
                >
                  <ion-icon name="download"></ion-icon>
                  <p class="ml-2">Save Changes</p>
                </button>
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>

    <script
      type="module"
      src="https://cdn.jsdelivr.net/npm/ionicons@latest/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://cdn.jsdelivr.net/npm/ionicons@latest/dist/ionicons/ionicons.js"
    ></script>
  </body>
</html>
