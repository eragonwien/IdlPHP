<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once("../config/database.php");
include_once("../objects/hero.php");
include_once("../objects/errorMessage.php");

if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("HTTP/1.0 400 Bad Request");
    return;
}

$id = intval($_GET['id']);

$database = new Database();
$connection = $database->getConnection();

$hero = new Hero($connection);


$result = $hero->getById($id);
display($result);

function display($result)
{
    $count = $result->rowCount();
    if ($count <= 0) {
        header("HTTP/1.0 204 No Content");
        return;
    }

    $row = $result->fetch(PDO::FETCH_ASSOC);
    extract($row);
    
    $hero = array(
        "id" => $id,
        "username" => $username,
        "firstname" => $firstname,
        "lastname" => $lastname,
        "gender" => $gender,           
        "image" => $image  
    );

    $response = json_encode($hero);
    header("HTTP/1.0 200 O.K");
    echo $response;
}