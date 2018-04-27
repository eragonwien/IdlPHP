<?php
// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

include_once('../config/database.php');
include_once('../objects/ability.php');

$database = new Database();
$connection = $database->getConnection();

$ability = new Ability($connection);

if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
    $abilities = $ability->getById(intval($_GET['id']));
    display($abilities, false);
    return;
}
$abilities = $ability->get();
display($abilities);

function display($result, bool $isArray = true)
{
    $count = $result->rowCount();
    if ($count <= 0) {
        header('HTTP/1.0 204 No Content');
        return;
    }

    $abilities = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $ability = array(
            'id' => $id,
            'name' => $name,
            'description' => $description
        );
        array_push($abilities, $ability);
    }
    header('HTTP/1.0 200 O.K');
    if ($isArray) {
        $response = json_encode($abilities);
        echo $response;
    } else {
        $response = json_encode($abilities[0]);
        echo $response;
    }
}