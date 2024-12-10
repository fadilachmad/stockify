<?php
session_start();

if (!isset($_SESSION["login"]) || !$_SESSION["login"]) {
  header("Location: login.php");
  exit;
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

include 'config/conn.php';
require 'functions.php';

if (isset($_POST["search"])) {
  $keyword = trim($_POST["keyword"]); // ngilangin spasi
  if (!empty($keyword)) {
    $product = search($keyword) ?? [];
  } else {
    $product = [];
  }
} else {
  $sql = "SELECT * FROM product";
  $product = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

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

if (isset($_POST["search"]) && !empty($_POST["keyword"])) {
  $keyword = trim($_POST["keyword"]);
  $sql = "SELECT * FROM product WHERE LOWER(name) LIKE LOWER(:keyword)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt;
} else {
  $sql = "SELECT * FROM product";
  $result = $pdo->query($sql);
}

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

// Pagination setup
$limit = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Hitung offset

// Query untuk mengambil total jumlah data
$totalRowsQuery = "SELECT COUNT(*) as total FROM product";
$totalRowsResult = $pdo->query($totalRowsQuery)->fetch(PDO::FETCH_ASSOC);
$totalRows = $totalRowsResult['total'];
$totalPages = ceil($totalRows / $limit); // Total halaman

// Tangkap parameter filter dan pagination
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'default';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Tentukan jumlah data per halaman
$limit = 5;
$offset = ($page - 1) * $limit;

// Query dengan LIMIT dan OFFSET
$sql = "SELECT * FROM product ";
switch ($filter) {
    case 'abjad':
        $sql .= "ORDER BY name ASC ";
        break;
    case 'harga':
        $sql .= "ORDER BY price ASC ";
        break;
    case 'kuantitas':
        $sql .= "ORDER BY quantity DESC ";
        break;
    default:
        $sql .= "ORDER BY id ASC ";
        break;
}
$sql .= "LIMIT :limit OFFSET :offset";

// Persiapkan dan eksekusi query
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hitung total data untuk pagination
$totalQuery = "SELECT COUNT(*) AS total FROM product";
$totalResult = $pdo->query($totalQuery)->fetch(PDO::FETCH_ASSOC);
$totalData = $totalResult['total'];

// Hitung total halaman
$totalPages = ceil($totalData / $limit);

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />
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
  <style>
.pagination a {
  margin: 0 2px;
  text-decoration: none;
  font-size: 14px;
}
.pagination a:hover {
  background-color: #ddd;
}
</style>

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
              class="text-2xl ml-3 mr-10"></ion-icon>
            <p>Dashboard</p>
          </a>
        </li>
        <li
          class="hover:border-b border-compliment hover:bg-secondary hover:bg-opacity-20">
          <a href="addProduct.php" class="p-4 flex items-center">
            <ion-icon
              name="create-outline"
              class="text-2xl ml-3 mr-10"></ion-icon>
            <p>Add Product</p>
          </a>
        </li>
        <li
          class="hover:border-b border-compliment hover:bg-secondary hover:bg-opacity-20">
          <a href="account.php" class="p-4 flex items-center">
            <ion-icon
              name="cafe-outline"
              class="text-2xl ml-3 mr-10"></ion-icon>
            <p>Account</p>
          </a>
        </li>
        <li
          class="hover:border-b border-compliment hover:bg-secondary hover:bg-opacity-20">
          <a href="contactUs.php" class="p-4 flex items-center">
            <ion-icon
              name="chatbubbles-outline"
              class="text-2xl ml-3 mr-10"></ion-icon>
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
          class="bg-secondary bg-opacity-75 border-t-4 border-compliment w-1/4 h-16 flex justify-center items-center">
          <a href="index.php" class="flex items-center justify-center p-5">
            <ion-icon name="file-tray-full" class="text-3xl"></ion-icon>
          </a>
        </li>
        <li
          class="border-compliment w-1/4 h-16 flex justify-center items-center">
          <a
            href="addProduct.php"
            class="flex items-center justify-center p-5">
            <ion-icon name="create-outline" class="text-3xl"></ion-icon>
          </a>
        </li>
        <li
          class="border-compliment w-1/4 h-16 flex justify-center items-center">
          <a href="account.php" class="flex items-center justify-center p-5">
            <ion-icon name="cafe-outline" class="text-3xl"></ion-icon>
          </a>
        </li>
        <li
          class="border-compliment w-1/4 h-16 flex justify-center items-center">
          <a
            href="contactUs.php"
            class="flex items-center justify-center p-5">
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
          class="card bg-secondary text-primary flex items-center mt-2 md:h-24">
          <ion-icon
            name="cube-outline"
            class="text-3xl my-3 mx-3 md:text-[48px]"></ion-icon>
          <div class="text">
            <h2 class="text-sm font-medium md:text-xl">Total Product</h2>
            <p class="font-extrabold text-xl -mt-1 md:text-3xl"><?php echo $totalProduct; ?></p>
          </div>
        </div>
        <div class="card bg-secondary text-primary flex items-center mt-2">
          <ion-icon
            name="journal-outline"
            class="text-3xl my-3 mx-3 md:text-[48px]"></ion-icon>
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
            class="text-3xl my-3 mx-3 md:text-[48px]"></ion-icon>
          <div class="text">
            <h2 class="text-sm font-medium md:text-xl">Total Category</h2>
            <p class="font-extrabold text-xl -mt-1 md:text-3xl"><?php echo $totalCategory; ?></p>
          </div>
        </div>
      </section>
      <div class="menu-info mt-3">
        <h2 class="text-bone font-semibold md:text-xl md:mb-2">Inventory</h2>
        <div class="feature flex items-center justify-between">
        <div class="relative inline-block text-right">
              <button
                onclick="toggleDropdown()"
                id="dropdownButton"
                class="bg-bone text-primary text-xs p-1 rounded-sm md:text-base flex items-center justify-between"
              >
                <ion-icon name="funnel-outline"></ion-icon>
                <p class="ml-2" id="dropdownButtonText">Filter</p>
              </button>

              <!-- Dropdown Menu -->
              <div
                id="dropdownMenu"
                class="absolute left-0 z-10 mt-2 md:w-40 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none text-left hidden"
              >
                <div class="py-1" role="menu">
              <a
                  href="?filter=default"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 <?= $filter === 'default' ? 'bg-gray-200 font-bold' : '' ?>"
                  role="menuitem"
                  id="default"
              >
                  Default
              </a>
              <a
                  href="?filter=abjad"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 <?= $filter === 'abjad' ? 'bg-gray-200 font-bold' : '' ?>"
                  role="menuitem"
                  id="abjad"
              >
                  Abjad
              </a>
              <a
                  href="?filter=harga"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 <?= $filter === 'harga' ? 'bg-gray-200 font-bold' : '' ?>"
                  role="menuitem"
                  id="harga"
              >
                  Harga
              </a>
              <a
                  href="?filter=kuantitas"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 <?= $filter === 'kuantitas' ? 'bg-gray-200 font-bold' : '' ?>"
                  role="menuitem"
                  id="kuantitas"
              >
                  Kuantitas
              </a>

                </div>
              </div>
            </div>

          <form action="" method="post">
            <b action="" method="post">
              <input
                type="text" name="keyword" id="keyword"
                class="rounded-full px-2 py-1 text-primary text-xs placeholder:text-primary placeholder:text-xs focus:outline-none md:text-base md:placeholder:text-base"
                placeholder="Search items..." autofocus autocomplete="off" />
            </b>
          </form>

        </div>
      </div>
      <div class="data overflow-auto" id="container">
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
                Unit
              </th>
              <th class="text-bone text-xs md:text-base border p-2 md:w-[120px]">
                Action
              </th>
            </tr>
          </thead>
          <tbody class="text-bone">
          <?php
          if (count($product) > 0) {
              $no = 1; // Nomor urut
              foreach ($product as $row) {
                  echo "<tr>";
                  echo "<td class='border text-xs md:text-base p-2'>{$no}</td>";
                  echo "<td class='border text-xs md:text-base p-2'>{$row['name']}</td>";
                  echo "<td class='border text-xs md:text-base p-2'>{$row['category']}</td>";
                  echo "<td class='border text-xs md:text-base p-2'>Rp. " . number_format($row['price'], 0, ',', '.') . "</td>";
                  echo "<td class='border text-xs md:text-base p-2'>{$row['quantity']}</td>";
                  echo "<td class='border text-xs md:text-base p-2'>{$row['unit']}</td>";
                  echo "
                      <td class='border text-xs md:text-base p-2'>
                          <button class='bg-bone text-primary text-xs px-2 py-1 rounded-sm' onclick='openEditForm(`{$row['id']}`, `{$row['name']}`, `{$row['category']}`, `{$row['price']}`, `{$row['quantity']}`, `{$row['unit']}`, `{$row['description']}`);'>
                              <ion-icon name='information-circle-outline'></ion-icon>
                          </button>
                          <button class='bg-bone text-primary text-xs px-2 py-1 rounded-sm'>
                              <a href='update.php?id={$row['id']}'><ion-icon name='pencil-outline'></ion-icon></a>
                          </button>
                          <button class='bg-bone text-primary text-xs px-2 py-1 rounded-sm'>
                              <a href='index.php?delete_id={$row['id']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus produk ini?\")'><ion-icon name='trash-outline'></ion-icon></a>
                          </button>
                      </td>";
                  echo "</tr>";
                  $no++;
              }
          } else {
              echo "<tr><td colspan='7' class='border text-center p-2'>No Data Available</td></tr>";
          }
          ?>
          </tbody>
        </table>

        <div class="pagination mt-4 flex justify-center items-center">
          <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&filter=<?= $filter ?>" class="bg-secondary text-primary px-3 py-2 rounded-l">
              Previous
            </a>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&filter=<?= $filter ?>"
              class="px-3 py-2 <?= $i === $page ? 'bg-primary text-white' : 'bg-secondary text-primary' ?>"><?= $i ?></a>
          <?php endfor; ?>

          <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&filter=<?= $filter ?>" class="bg-secondary text-primary px-3 py-2 rounded-r">
              Next
            </a>
          <?php endif; ?>
        </div>
        


        <div id="edit-form" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="overflow: auto; ; padding: 10px">
          <div class="bg-white p-8 rounded-lg w-auto" style="max-height: 90%; overflow-y:auto; margin-top: 20px; position: absolute; top: 0; left: 50%; transform: translateX(-50%)">
            <h2 class="text-2xl font-bold mb-4 text-center text-black">Product Information</h2>
            <form id="view-inventory">
              <input type="hidden" id="view-id" name="view-id" />

              <div class="mb-4">
                <label for="view-name" class="block text-black font-bold mb-2">Product Name</label>
                <input type="text" id="view-name" readonly
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black" />
              </div>
              <div class="mb-4">
                <label for="view-category" class="block font-bold mb-2 text-black">Category</label>
                <input id="view-category" rows="4" readonly
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black"></input>
              </div>
              <div class="mb-4">
                <label for="view-price" class="block text-black font-bold mb-2">Price</label>
                <input type="number" id="view-price" readonly
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
              </div>
              <div class="mb-4">
                <label for="view-quantity" class="block text-black font-bold mb-2">Quantity</label>
                <input type="number" id="view-quantity" readonly
                  class="w-auto px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black" />
                <input type="text" id="view-unit" readonly
                  class="w-20 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black" />
              </div>
              <div class="mb-4">
                <label for="view-description" class="block text-black font-bold mb-2">Description</label>
                <textarea id="view-description" rows="4" readonly
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black"></textarea>
              </div>
              <div class="flex justify-center">
                <button type="button" class="bg-primary text-white px-4 py-2 rounded-lg mr-2" onclick="closeEditForm()">
                  Back
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
    <!-- End Main Content -->
  </div>
  
  <script>
      function toggleDropdown() {
        const menu = document.getElementById("dropdownMenu");
        menu.classList.toggle("hidden");
      }

      // Menutup dropdown jika klik di luar
      document.addEventListener("click", function (e) {
        const button = document.getElementById("dropdownButton");
        const menu = document.getElementById("dropdownMenu");
        if (!button.contains(e.target)) {
          menu.classList.add("hidden");
        }
      });
    </script>
  <script
    type="module"
    src="https://cdn.jsdelivr.net/npm/ionicons@latest/dist/ionicons/ionicons.esm.js"></script>
  <script
    nomodule
    src="https://cdn.jsdelivr.net/npm/ionicons@latest/dist/ionicons/ionicons.js"></script>

  <script src="../js/script.js"></script>
</body>

</html>
