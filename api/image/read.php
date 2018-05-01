<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: image/jpeg");
include_once("../objects/image.php");

if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('HTTP/1.0 400 Bad Request');
    return;
}

$id = intval($_GET['id']);
$image = new Image($id);
$result = $image->get();
header('HTTP/1.0 200 O.K');
echo $result;
