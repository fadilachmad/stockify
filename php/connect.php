<?php 
    $host = 'aws-0-ap-southeast-1.pooler.supabase.com';
    $user = 'postgres.fjvtnxhiaroqysyiwtcl';
    $password = 'pbasdatkel5';
    $dbname = 'dbbooks';
    $port = '6543';
    $dbname = 'postgres';

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn -> connect_error) {
        die ("Connection Failed: ". $conn -> connect_error);
    } else {
        echo "Connection Success.";
    }
?>