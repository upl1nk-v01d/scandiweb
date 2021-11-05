<?php 
include('mysql_connect.php');
include('mysql_decode_json.php');

$db = new sqlite3($dbname);
    //$db->exec("DROP TABLE IF EXISTS products");
	$db->query("CREATE TABLE IF NOT EXISTS products(id INTEGER PRIMARY KEY AUTOINCREMENT, sku TEXT NOT NULL UNIQUE, name TEXT NOT NULL, price TEXT NOT NULL, size TEXT, weight TEXT, height TEXT, width TEXT, length TEXT)");

	$db->query("INSERT INTO products(sku, name, price, size, weight, height, width, length) VALUES('" . $decoded['p']['sku'] . "', '" . $decoded['p']['name'] . "','" . $decoded['p']['price'] . "', '" . $decoded['p']['attr']['size'] . "','" . $decoded['p']['attr']['weight'] . "', '" . $decoded['p']['attr']['dimensions']['height'] . "','" . $decoded['p']['attr']['dimensions']['width'] . "', '" . $decoded['p']['attr']['dimensions']['length'] . "')");
?>