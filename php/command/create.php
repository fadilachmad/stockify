<?php
include 'php/config/conn.php';

function createItem($pdo, $uid, $name, $category, $quantity, $price)
{

    $sql = "INSERT INTO product (user_id, name, category, quantity, price) VALUES (:uid, :name, :category, :quantity, :price)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":uid", $uid);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":category", $category);
    $stmt->bindParam(":quantity", $quantity);
    $stmt->bindParam(":price", $price);

    if ($stmt->execute()) {
        echo "New item created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
}

function createCategory($pdo, $uid, $category)
{
    $sql = "INSERT INTO category (user_id, category) VALUES (:uid, :category)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":uid", $uid);
    $stmt->bindParam(":category", $category);

    if ($stmt->execute()) {
        echo "New category created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $uid = $_POST['uid'];
    $newCategory = $_POST['newCategory'];

    createItem($pdo, $uid, $name, $category, $quantity, $price);
    // createCategory($pdo, $uid, $newCategory);
}
