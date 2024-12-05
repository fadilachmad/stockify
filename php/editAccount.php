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
          <li class="bg-secondary bg-opacity-75 border-r-4 border-compliment">
            <a href="account.php" class="p-4 flex items-center">
              <ion-icon name="cafe" class="text-2xl ml-3 mr-10"></ion-icon>
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
            class="bg-secondary bg-opacity-75 border-t-4 border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a href="account.php" class="flex items-center justify-center p-5">
              <ion-icon name="cafe" class="text-3xl"></ion-icon>
            </a>
          </li>
          <li
            class="border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a
              href="contactUs.php"
              class="flex items-center justify-center p-5"
            >
              <ion-icon name="chatbubbles-outline" class="text-3xl"></ion-icon>
            </a>
          </li>
        </ul>
      </div>

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
  <form action="">
    <div class="username mb-4">
      <h2 class="text-bone font-semibold md:text-xl">Username</h2>
      <input
        type="text"
        name="name"
        id="name"
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
        name="bio"
        id="bio"
        class="bg-compliment mb-2 text-bone text-xs w-full md:w-96 p-3 md:h-24 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
        placeholder="Write something about yourself..."
      ></textarea>
    </div>
    <div class="btn-wrapper flex">
      <button
        type="reset"
        class="bg-slate-300 mr-5 text-red-600 text-xs py-2 px-4 rounded-sm md:text-base flex items-center justify-between hover:bg-bone"
        onclick="location.href='account.php'"
      >
        <ion-icon name="close-outline"></ion-icon>
        <p class="ml-2">Cancel</p>
      </button>
      <button
        type="submit"
        class="bg-bone text-primary text-xs py-2 px-4 rounded-sm md:text-base flex items-center justify-between hover:bg-slate-200"
        onclick="location.href='account.php'"
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
