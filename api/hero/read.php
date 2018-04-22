<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once("../config/database.php");
include_once("../objects/hero.php");

$database = new Database();
$connection = $database->getConnection();

$hero = new Hero($connection);

$heroes = $hero->get();
display($heroes);

function display($result)
{
    $count = $result->rowCount();
    if ($count <= 0) {
        header("HTTP/1.0 204 No Content");
        return;
    }

    $heroes = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $hero = array(
            "id" => $id,
            "username" => $username,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "gender" => $gender,           
            "image" => $image
        );
        array_push($heroes, $hero);
    }
    $response = json_encode($heroes);
    header("HTTP/1.0 200 O.K");
    echo $response;
}