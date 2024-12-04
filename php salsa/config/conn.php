<?php

$sname = "aws-0-ap-southeast-1.pooler.supabase.com";
$unmae = "postgres.fjvtnxhiaroqysyiwtcl";
$password = "pbasdatkel5";
$port = 6543;

$db_name = "postgres";

try {
    $dsn = "pgsql:host=$sname;port=$port;dbname=$db_name";
    $pdo = new PDO($dsn, $unmae, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}