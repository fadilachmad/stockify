<?php
include 'php/config/conn.php';

function readProduct($pdo, $uid)
{
    $sql = "SELECT * FROM product WHERE user_id = :uid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":uid", $uid);

    if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($result)) {
            echo $result["name"];
        }
    }
}

$uid = $_POST["uid"];
readProduct($pdo, $uid);