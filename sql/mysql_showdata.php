<?php 
include('mysql_connect.php');

$db = new sqlite3($dbname);
    $fetch = $db->query("SELECT * FROM products ORDER BY sku ASC");
    $numrows = $fetch->fetchArray();
    $result = array();
    if($numrows > 0)
    {
        while($rows = $fetch->fetchArray())
        {
            $sku = $rows['sku'];
            $name = $rows['name'];
            $price = $rows['price'];
            $size = $rows['size'];
            $weight = $rows['weight'];
            $height = $rows['height'];
            $width = $rows['width'];
            $length = $rows['length'];
    
            $result[] = array('sku' => $sku, 'name' => $name, 'price' => $price, 'size' => $size, 'weight' => $weight, 'height' => $height, 'width' => $width, 'length' => $length);
        }
    }
    echo(json_encode($result));
?>