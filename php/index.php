<?php
session_start();

if (!isset($_SESSION["login"]) || !$_SESSION["login"]) {
  header("Location: login.php");
  exit;
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

include 'config/conn.php';

// Query untuk mendapatkan data dari tabel 'product'


// Hitung total produk (jumlah semua name)
$totalProductQuery = "SELECT COUNT(name) AS total_product FROM product";
$totalProductResult = $pdo->query($totalProductQuery);
$totalProduct = $totalProductResult->fetch(PDO::FETCH_ASSOC)['total_product'];

// Hitung total value (price * quantity)
$totalValueQuery = "SELECT SUM(price * quantity) AS total_value FROM product";
$totalValueResult = $pdo->query($totalValueQuery);
$totalValue = $totalValueResult->fetch(PDO::FETCH_ASSOC)['total_value'];

// Hitung total kategori unik
$totalCategoryQuery = "SELECT COUNT(DISTINCT category) AS total_category FROM product";
$totalCategoryResult = $pdo->query($totalCategoryQuery);
$totalCategory = $totalCategoryResult->fetch(PDO::FETCH_ASSOC)['total_category'];

$sql = "SELECT * FROM product";
$result = $pdo->query($sql);

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $delete_sql = "DELETE FROM product WHERE id = ?";
    $stmt = $pdo->prepare($delete_sql);
    $stmt->bindValue(1, $delete_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect ke halaman utama
        exit();
    } else {
        echo "Gagal menghapus data: " . $stmt->errorInfo()[2];
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
    <div class="content md:grid grid-cols-12 h-screen overflow-hidden">
      <!-- Sidebar -->
      <div class="sidebar col-span-2 hidden md:block bg-bone h-screen">
        <ul>
          <li class="font-extrabold text-compliment text-center my-4 text-xl">
            Stockify
          </li>
          <li class="bg-secondary bg-opacity-75 border-r-4 border-compliment">
            <a href="index.php" class="p-4 flex items-center">
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
      <div class="bottombar fixed bg-bone bottom-0 right-0 left-0 w-screen md:hidden">
        <ul class="flex">
          <li
            class="bg-secondary bg-opacity-75 border-t-4 border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a href="index.php" class="flex items-center justify-center p-5">
              <ion-icon name="file-tray-full" class="text-3xl"></ion-icon>
            </a>
          </li>
          <li
            class="border-compliment w-1/4 h-16 flex justify-center items-center"
          >
            <a
              href="addproduct.php"
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
              <p class="font-extrabold text-xl -mt-1 md:text-3xl"><?php echo $totalProduct; ?></p>
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
                Rp. <?php echo number_format($totalValue, 0, ',', '.'); ?>
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
              <p class="font-extrabold text-xl -mt-1 md:text-3xl"><?php echo $totalCategory; ?></p>
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
            <?php
                if ($result->rowCount() > 0) {
                    $no = 1; // Nomor urut
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td class='border text-xs md:text-base p-2'>{$no}</td>";
                        echo "<td class='border text-xs md:text-base p-2'>{$row['name']}</td>";
                        echo "<td class='border text-xs md:text-base p-2'>{$row['category']}</td>";
                        echo "<td class='border text-xs md:text-base p-2'>Rp. " . number_format($row['price'], 0, ',', '.') . "</td>";
                        echo "<td class='border text-xs md:text-base p-2'>{$row['quantity']}</td>";
                        echo "<td class='border text-xs md:text-base p-2'>
                                <button class='bg-bone text-primary text-xs px-2 py-1 rounded-sm'>
                                  <a href='update.php?id={$row['id']}'><ion-icon name='pencil-outline'></ion-icon></a>
                                </button>
                                <button class='bg-bone text-primary text-xs px-2 py-1 rounded-sm'>
                                  <a href='index.php?delete_id={$row['id']}' onclick='return confirm('Apakah Anda yakin ingin menghapus produk ini?')'><ion-icon name='trash-outline'></ion-icon></a>
                                </button>
                        </td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='6' class='border text-center p-2'>No Data Available</td></tr>";
                }
                $pdo = null;
            ?>
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
