<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    
include('../config/database.php');
include('../objects/team.php');
include('../objects/errorMessage.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    if (empty($_POST['name'])) {
        array_push($errors, 'Team name is required');
    }

    if ($errors) {
        header('HTTP/1.0 400 Bad Request');
        $errorMessage = ErrorMessage::multipleErrors($errors);
        $response = $errorMessage->get();
        echo json_encode($response);
        return;
    }

    // connection
    $database = new Database();
    $connection = $database->getConnection();

    // create team
    $team = new Team($connection);
    $team->setName($_POST['name']);
    $team->setLeaderId($_POST['leader_id']);

    $result = $team->create();
    $success = $result['success'];
    if (!$success) {
        header('HTTP/1.0 500 Internal Server Error');
        if (isset($result['message'])) {
            $errorMessage = ErrorMessage::singleError($result['message']);
            $response = $errorMessage->get();
            echo json_encode($response);
            return;
        }
    }
    header('HTTP/1.0 200 O.K');
    echo json_encode($result);
}
?>

