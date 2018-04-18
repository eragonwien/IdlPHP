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
        echo json_encode(
            array("message" => "No products found.")
        );
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
            "teamId" => $teamId,           
            "teamName" => $teamName,           
        );
        array_push($heroes, $hero);
    }
    echo json_encode($heroes);
}