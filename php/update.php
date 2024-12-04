<?php
session_start();

if (!isset($_SESSION["login"]) || !$_SESSION["login"]) {
  header("Location: login.php");
  exit;
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

include 'config/conn.php';

// Ambil data berdasarkan ID
$id = $_GET['id'];
$sql = "SELECT * FROM product WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $id, PDO::PARAM_INT);
$stmt->execute();
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($product) {
    // Product found
} else {
    die("Produk tidak ditemukan.");
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    // Validasi sederhana
    if (!empty($name) && !empty($category) && !empty($price) && !empty($quantity)) {
        $sql_update = "UPDATE product SET name = ?, category = ?, price = ?, quantity = ?, description = ? WHERE id = ?";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindValue(1, $name, PDO::PARAM_STR);
        $stmt_update->bindValue(2, $category, PDO::PARAM_STR);
        $stmt_update->bindValue(3, $price, PDO::PARAM_STR);
        $stmt_update->bindValue(4, $quantity, PDO::PARAM_INT);
        $stmt_update->bindValue(5, $description, PDO::PARAM_STR);
        $stmt_update->bindValue(6, $id, PDO::PARAM_INT);

        if ($stmt_update->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Gagal memperbarui data: " . $stmt_update->errorInfo()[2];
        }
    } else {
        echo "Semua field harus diisi.";
    }
}

$pdo = null;
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
            <a href="addproduct.php" class="p-4 flex items-center">
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
            class="bg-secondary bg-opacity-75 border-t-4 border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a
              href="addproduct.php"
              class="flex items-center justify-center p-5"
            >
              <ion-icon name="create" class="text-3xl"></ion-icon>
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

        <div class="menu-info mt-1">
          <h2 class="text-bone font-semibold md:text-xl md:mb-2">
            Add new product
          </h2>
          <form action="" method="post">
            <input
              type="text"
              name="name"
              id="name"
              class="bg-compliment mb-2 text-bone text-xs h-8 w-full md:w-1/2 p-3 md:h-12 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
              value="<?= htmlspecialchars($product['name']); ?>"
              placeholder="Name"
            />
            <input
              type="text"
              name="category"
              id="category"
              class="bg-compliment mb-2 text-bone text-xs h-8 w-full md:w-1/2 p-3 md:h-12 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
              value="<?= htmlspecialchars($product['category']); ?>"
              placeholder="Category"
            />
            <input
              type="number"
              name="price"
              id="price"
              class="bg-compliment mb-2 text-bone text-xs h-8 w-full md:w-1/2 p-3 md:h-12 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
              value="<?= htmlspecialchars($product['price']); ?>"
              placeholder="Price (Rp.)"
            />
            <input
              type="text"
              name="quantity"
              id="quantity"
              class="bg-compliment mb-2 text-bone text-xs h-8 w-full md:w-1/2 p-3 md:h-12 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
              value="<?= htmlspecialchars($product['quantity']); ?>"
              placeholder="Quantity"
            />
            <textarea
              name="description"
              id="description"
              class="bg-compliment mb-2 text-bone text-xs h-32 w-full md:w-1/2 p-3 md:h-40 rounded-sm focus:outline-none md:text-base md:placeholder:text-base"
              placeholder="Description"
            ><?= htmlspecialchars($product['description']); ?></textarea>

            <button
              type="submit"
              class="bg-bone text-primary text-xs py-2 px-4 rounded-sm md:text-base flex items-center justify-between hover:bg-slate-200"
            >
              <ion-icon name="add-outline"></ion-icon>
              <p class="ml-2">Add</p>
            </button>
          </form>
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
