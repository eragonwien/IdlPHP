<?php
// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

include_once('../config/database.php');
include_once('../objects/hero.php');

$database = new Database();
$connection = $database->getConnection();

$hero = new Hero($connection);

if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
    $heroes = $hero->getById(intval($_GET['id']));
    display($heroes, false);
    return;
}
$heroes = $hero->get();
display($heroes);

function display($result, bool $isArray = true)
{
    $count = $result->rowCount();
    if ($count <= 0) {
        header('HTTP/1.0 204 No Content');
        return;
    }

    $heroes = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $hero = array(
            'id' => $id,
            'username' => $username,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'gender' => $gender,           
            'image' => $image
        );
        array_push($heroes, $hero);
    }
    header('HTTP/1.0 200 O.K');
    if ($isArray) {
        $response = json_encode($heroes);
        echo $response;
    } else {
        $response = json_encode($heroes[0]);
        echo $response;
    }
}