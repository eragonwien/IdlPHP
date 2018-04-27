<?php
// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

include_once('../config/database.php');
include_once('../objects/relation.php');

$database = new Database();
$connection = $database->getConnection();

$relation = new Relation($connection);

if (empty($_GET['heroId1']) && empty($_GET['heroId2']) ) {
    $relations = $relation->get();
    display($relations);
    return;
}

$errors = array();

if (empty($_GET['heroId1']) && !empty($_GET['heroId2']) ) {
    array_push($errors, 'Id of first hero is required');
}

if (!empty($_GET['heroId1']) && empty($_GET['heroId2']) ) {
    array_push($errors, 'Id of second hero is required');
}

if (!ctype_digit($_GET['heroId1'])) {
    array_push($errors, 'Id of first hero must be a number');
}

if (!ctype_digit($_GET['heroId2'])) {
    array_push($errors, 'Id of second hero must be a number');
}


if ($errors) {
    header('HTTP/1.0 400 Bad Request');
    $errorMessage = ErrorMessage::multipleErrors($errors);
    $response = $errorMessage->get();
    echo json_encode($response);
    return;
}

$relations = $relation->getById(intval($_GET['heroId1']), intval( $_GET['heroId2']));
display($relations, false);

function display($result, bool $isArray = true)
{
    $count = $result->rowCount();
    if ($count <= 0) {
        header('HTTP/1.0 204 No Content');
        return;
    }

    $relations = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $relation = array(
            'hero_id_1' => $hero_id_1,
            'hero_id_2' => $hero_id_2,
            'is_friendly' => $is_friendly
        );
        array_push($relations, $relation);
    }
    header('HTTP/1.0 200 O.K');
    if ($isArray) {
        $response = json_encode($relations);
        echo $response;
    } else {
        $response = json_encode($relations[0]);
        echo $response;
    }
}