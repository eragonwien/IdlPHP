<?php
// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

include_once('../config/database.php');
include_once('../objects/alias.php');

$database = new Database();
$connection = $database->getConnection();

$alias = new Alias($connection);

if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
    $aliases = $alias->getById(intval($_GET['id']));
    display($aliases, false);
    return;
}
$aliases = $alias->get();
display($aliases);

function display($result, bool $isArray = true)
{
    $count = $result->rowCount();
    if ($count <= 0) {
        header('HTTP/1.0 204 No Content');
        return;
    }

    $aliases = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $alias = array(
            'id' => $id,
            'name' => $name,
            'hero_id' => $hero_id
        );
        array_push($aliases, $alias);
    }
    header('HTTP/1.0 200 O.K');
    if ($isArray) {
        $response = json_encode($aliases);
        echo $response;
    } else {
        $response = json_encode($aliases[0]);
        echo $response;
    }
    

    
}