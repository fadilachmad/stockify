<?php
    session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }

    require 'connect.php';
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
            <a href="index.html" class="p-4 flex items-center">
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
            <a href="addProduct.html" class="p-4 flex items-center">
              <ion-icon
                name="create-outline"
                class="text-2xl ml-3 mr-10"
              ></ion-icon>
              <p>Add Product</p>
            </a>
          </li>
          <li class="bg-secondary bg-opacity-75 border-r-4 border-compliment">
            <a href="account.html" class="p-4 flex items-center">
              <ion-icon name="cafe" class="text-2xl ml-3 mr-10"></ion-icon>
              <p>Account</p>
            </a>
          </li>
          <li
            class="hover:border-b border-compliment hover:bg-secondary hover:bg-opacity-20"
          >
            <a href="contactUs.html" class="p-4 flex items-center">
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

      <!-- Bottombar Mobile -->
      <div
        class="bottombar fixed bg-bone bottom-0 right-0 left-0 w-screen md:hidden"
      >
        <ul class="flex">
          <li
            class="border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a href="index.html" class="flex items-center justify-center p-5">
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
              href="addProduct.html"
              class="flex items-center justify-center p-5"
            >
              <ion-icon name="create-outline" class="text-3xl"></ion-icon>
            </a>
          </li>
          <li
            class="bg-secondary bg-opacity-75 border-t-4 border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a href="account.html" class="flex items-center justify-center p-5">
              <ion-icon name="cafe" class="text-3xl"></ion-icon>
            </a>
          </li>
          <li
            class="border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a
              href="contactUs.html"
              class="flex items-center justify-center p-5"
            >
              <ion-icon name="chatbubbles-outline" class="text-3xl"></ion-icon>
            </a>
          </li>
        </ul>
      </div>
      <!-- End Bottombar Mobile -->

      <!-- Main Content -->
      <main class="m-3 col-span-10">
        <header class="flex justify-between">
          <h1 class="greet font-extrabold text-2xl text-bone">Hi, Username</h1>
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
            <div class="username mb-4">
              <h2 class="text-bone font-semibold md:text-xl">Username</h2>
              <h3 class="text-bone text-sm md:text-lg md:mb-2">
                Username User
              </h3>
            </div>
            <div class="email mb-4">
              <h2 class="text-bone font-semibold md:text-xl">Email</h2>
              <h3 class="text-bone text-sm md:text-lg md:mb-2">
                email@gmail.com
              </h3>
            </div>
            <div class="username mb-4">
              <h2 class="text-bone font-semibold md:text-xl">Bio</h2>
              <h3 class="text-bone text-sm md:text-lg md:mb-2">-</h3>
            </div>
            <button
              type="submit"
              class="bg-bone text-primary text-xs py-2 px-4 rounded-sm md:text-base flex items-center justify-between hover:bg-slate-200"
            >
              <ion-icon name="pencil"></ion-icon>
              <p class="ml-2">Edit Profile</p>
            </button>
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
