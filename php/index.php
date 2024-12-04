<?php 
    session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    };

    $username = $_SESSION['username'];
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
    <div class="content md:grid grid-cols-12 h-screen overflow-hidden">
      <!-- Sidebar -->
      <div class="sidebar col-span-2 hidden md:block bg-bone h-screen">
        <ul>
          <li class="font-extrabold text-compliment text-center my-4 text-xl">
            Stockify
          </li>
          <li class="bg-secondary bg-opacity-75 border-r-4 border-compliment">
            <a href="index.html" class="p-4 flex items-center">
              <ion-icon
                name="file-tray-full"
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
          <li
            class="hover:border-b border-compliment hover:bg-secondary hover:bg-opacity-20"
          >
            <a href="account.html" class="p-4 flex items-center">
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
            class="bg-secondary bg-opacity-75 border-t-4 border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a href="index.html" class="flex items-center justify-center p-5">
              <ion-icon name="file-tray-full" class="text-3xl"></ion-icon>
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
            class="border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a href="account.html" class="flex items-center justify-center p-5">
              <ion-icon name="cafe-outline" class="text-3xl"></ion-icon>
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
      <main class="m-3 col-span-10 overflow-auto">
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
        <section class="mt-1 md:grid grid-cols-3 gap-3">
          <div
            class="card bg-secondary text-primary flex items-center mt-2 md:h-24"
          >
            <ion-icon
              name="cube-outline"
              class="text-3xl my-3 mx-3 md:text-[48px]"
            ></ion-icon>
            <div class="text">
              <h2 class="text-sm font-medium md:text-xl">Total Product</h2>
              <p class="font-extrabold text-xl -mt-1 md:text-3xl">5</p>
            </div>
          </div>
          <div class="card bg-secondary text-primary flex items-center mt-2">
            <ion-icon
              name="journal-outline"
              class="text-3xl my-3 mx-3 md:text-[48px]"
            ></ion-icon>
            <div class="text">
              <h2 class="text-sm font-medium md:text-xl">Total Value</h2>
              <p class="font-extrabold text-xl -mt-1 md:text-3xl">
                Rp. 35,000,000
              </p>
            </div>
          </div>
          <div class="card bg-secondary text-primary flex items-center mt-2">
            <ion-icon
              name="shapes-outline"
              class="text-3xl my-3 mx-3 md:text-[48px]"
            ></ion-icon>
            <div class="text">
              <h2 class="text-sm font-medium md:text-xl">Total Category</h2>
              <p class="font-extrabold text-xl -mt-1 md:text-3xl">2</p>
            </div>
          </div>
        </section>
        <div class="menu-info mt-3">
          <h2 class="text-bone font-semibold md:text-xl md:mb-2">Inventory</h2>
          <div class="feature flex items-center justify-between">
            <button
              class="bg-bone text-primary text-xs p-1 rounded-sm md:text-base flex items-center justify-between"
            >
              <ion-icon name="funnel-outline"></ion-icon>
              <p class="ml-2">Default</p>
            </button>
            <input
              type="text"
              class="rounded-full px-2 py-1 text-primary text-xs placeholder:text-primary placeholder:text-xs focus:outline-none md:text-base md:placeholder:text-base"
              placeholder="Search items..."
            />
          </div>
        </div>
        <div class="data overflow-auto">
          <table class="mt-3 w-full">
            <thead>
              <tr class="bg-compliment border-bone">
                <th class="text-bone text-xs md:text-base border p-2 md:w-14">
                  No
                </th>
                <th class="text-bone text-xs md:text-base border p-2">Name</th>
                <th class="text-bone text-xs md:text-base border p-2 md:w-1/4">
                  Category
                </th>
                <th class="text-bone text-xs md:text-base border p-2 md:w-1/6">
                  Price
                </th>
                <th class="text-bone text-xs md:text-base border p-2 md:w-1/12">
                  Quantity
                </th>
                <th class="text-bone text-xs md:text-base border p-2 md:w-1/12">
                  Action
                </th>
              </tr>
            </thead>
            <tbody class="text-bone">
              <tr>
                <td class="border text-xs md:text-base p-2">1</td>
                <td class="border text-xs md:text-base p-2">Product 1</td>
                <td class="border text-xs md:text-base p-2">Category 1</td>
                <td class="border text-xs md:text-base p-2">Rp. 100000</td>
                <td class="border text-xs md:text-base p-2">10</td>
                <td class="border text-xs md:text-base p-2">Edit</td>
              </tr>
            </tbody>
          </table>
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
