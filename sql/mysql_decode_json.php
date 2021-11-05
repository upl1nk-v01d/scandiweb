<?php
$decoded = null;
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if ($contentType === "application/json") {
    $content = file_get_contents("php://input");
    $decoded = json_decode($content,true);
    //$decoded = json_decode($decoded['p'],true);
    //echo $decoded['p']['name'];
}
?>