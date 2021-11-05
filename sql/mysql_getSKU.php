<?php 
include('mysql_connect.php');

$db = new sqlite3($dbname);
    $fetch = $db->query("SELECT MAX(sku) FROM products");
    $numrows = $fetch->fetchArray();
    $o = $numrows[0];$o++;
    echo $o;
?>