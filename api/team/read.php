<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once("../config/database.php");
include_once("../objects/team.php");

$database = new Database();
$connection = $database->getConnection();

$team = new Team($connection);

if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
    $teams = $team->getById(intval($_GET['id']));
    display($teams, false);
    return;
}
$teams = $team->get();
display($teams);

function display($result, bool $isArray = true)
{
    $count = $result->rowCount();
    if ($count <= 0) {
        header("HTTP/1.0 204 No Content");
        return;
    }

    $teams = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $team = array(
            "id" => $id,
            "name" => $name,
            "leader_id" => $leader_id
        );
        array_push($teams, $team);
    }
    header("HTTP/1.0 200 O.K");
    if ($isArray) {
        $response = json_encode($teams);
        echo $response;
    } else {
        $response = json_encode($teams[0]);
        echo $response;
    }
}