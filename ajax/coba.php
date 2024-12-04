<?php 
require '../php/functions.php';
$keyword = $_GET["keyword"];

function query($keyword) {
    global $pdo;
    $sql = "SELECT * FROM product 
            WHERE LOWER(name) LIKE LOWER(:keyword) 
            OR LOWER(category) LIKE LOWER(:keyword) 
            OR LOWER(CAST(price AS TEXT)) LIKE LOWER(:keyword) 
            OR LOWER(CAST(quantity AS TEXT)) LIKE LOWER(:keyword) 
            OR LOWER(description) LIKE LOWER(:keyword)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$product = query($keyword);
?>

<table class="mt-3 w-full">
    <thead>
        <tr class="bg-compliment border-bone">
            <th class="text-bone text-xs md:text-base border p-2 md:w-14">No</th>
            <th class="text-bone text-xs md:text-base border p-2">Name</th>
            <th class="text-bone text-xs md:text-base border p-2 md:w-1/4">Category</th>
            <th class="text-bone text-xs md:text-base border p-2 md:w-1/6">Price</th>
            <th class="text-bone text-xs md:text-base border p-2 md:w-1/12">Quantity</th>
            <th class="text-bone text-xs md:text-base border p-2 md:w-1/12">Action</th>
        </tr>
    </thead>
    <tbody class="text-bone">
        <?php
            if (count($product) > 0) {
                $no = 1;
                foreach ($product as $row) {
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
                                <a href='index.php?delete_id={$row['id']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus produk ini?\")'><ion-icon name='trash-outline'></ion-icon></a>
                            </button>
                        </td>";
                    echo "</tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='6' class='border text-center p-2'>No Data Available</td></tr>";
            }
        ?>
    </tbody>
</table>
