<?php 
include('mysql_connect.php');
include('mysql_decode_json.php');

//echo $decoded['p'][0]['sku'];
//echo count($decoded['p']);

$db = new sqlite3($dbname);

for($i=0;$i<count($decoded['p']); $i++) {
    if($decoded['p'][$i]['checked']){
        $db->query("DELETE FROM products WHERE sku = '" . $decoded['p'][$i]['sku'] . "'");
    }
}


?>