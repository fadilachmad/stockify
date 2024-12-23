<?php
    session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }

    $username = $_SESSION['username'];

    require 'config/conn.php';
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
          <li
            class="hover:border-b border-compliment hover:bg-secondary hover:bg-opacity-20"
          >
            <a href="addProduct.php" class="p-4 flex items-center">
              <ion-icon
                name="create-outline"
                class="text-2xl ml-3 mr-10"
              ></ion-icon>
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
          <li class="bg-secondary bg-opacity-75 border-r-4 border-compliment">
            <a href="contactUs.php" class="p-4 flex items-center">
              <ion-icon
                name="chatbubbles"
                class="text-2xl ml-3 mr-10"
              ></ion-icon>
              <p>Contact Us</p>
            </a>
          </li>
        </ul>
      </div>
      <!-- End Sidebar -->

      <!-- Bottombar Mobile -->
      <div
        class="bottombar fixed bg-bone bottom-0 right-0 left-0 w-screen md:hidden"
      >
        <ul class="flex">
          <li
            class="border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a href="index.php" class="flex items-center justify-center p-5">
              <ion-icon
                name="file-tray-full-outline"
                class="text-3xl"
              ></ion-icon>
            </a>
          </li>
          <li
            class="border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a
              href="addProduct.php"
              class="flex items-center justify-center p-5"
            >
              <ion-icon name="create-outline" class="text-3xl"></ion-icon>
            </a>
          </li>
          <li
            class="border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a href="account.php" class="flex items-center justify-center p-5">
              <ion-icon name="cafe-outline" class="text-3xl"></ion-icon>
            </a>
          </li>
          <li
            class="bg-secondary bg-opacity-75 border-t-4 border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a
              href="contactUs.php"
              class="flex items-center justify-center p-5"
            >
              <ion-icon name="chatbubbles" class="text-3xl"></ion-icon>
            </a>
          </li>
        </ul>
      </div>
      <!-- End Bottombar Mobile -->

      <!-- Main Content -->
      <main class="m-3 col-span-10">
        <header class="flex justify-between">
          <h1 class="greet font-extrabold text-2xl text-bone">
            Hi, <?php echo htmlspecialchars($username); ?>!
          </h1>
          <a href="logout.php">
            <button class="bg-bone px-2 py-1 rounded-sm text-primary text-xs">
                Logout
            </button>
          </a>
        </header>

        <div class="menu-info mt-2">
          <h2 class="text-bone md:text-xl">Your reviews are important to us</h2>
          <h2 class="text-bone md:text-xl md:mb-2">
            Feel free to send us a message.
          </h2>
          <div class="contact mt-2">
            <div class="text mb-5">
              <h2 class="text-bone font-semibold md:text-xl">
                Contact Information
              </h2>
              <div class="call flex items-center mb-1">
                <ion-icon
                  name="call-outline"
                  class="text-compliment mr-2"
                ></ion-icon>
                <h3 class="text-bone text-sm md:text-lg">+62 123 456 789</h3>
              </div>
              <div class="mail flex items-center mb-1">
                <ion-icon
                  name="mail-outline"
                  class="text-compliment mr-2"
                ></ion-icon>
                <h3 class="text-bone text-sm md:text-lg">stockify@gmail.com</h3>
              </div>
              <div class="location flex items-center mb-1">
                <ion-icon
                  name="location-outline"
                  class="text-compliment mr-2"
                ></ion-icon>
                <h3 class="text-bone text-sm md:text-lg">Medan, Indonesia</h3>
              </div>
            </div>
            <form action="" method="post">
              <textarea
                name="description"
                id="description"
                class="bg-compliment mb-2 text-bone text-xs h-32 md:h-64 w-full md:w-1/2 p-3 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
                placeholder="Message..."
              ></textarea>

              <button
                type="submit"
                class="bg-bone text-primary text-xs py-2 px-4 rounded-sm md:text-base flex items-center justify-between hover:bg-slate-200"
              >
                <p>Send</p>
                <ion-icon name="send-outline" class="ml-2"></ion-icon>
              </button>
            </form>
          </div>
        </div>
      </main>
      <!-- End Main Content -->
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
