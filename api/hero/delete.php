<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
include("../config/database.php");
include("../objects/hero.php");
include("../objects/errorMessage.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    if (empty($_POST['id'])) {
        array_push($errors, "id is required");
    }

    if ($errors) {
        header("HTTP/1.0 400 Bad Request");
        $errorMessage = ErrorMessage::multipleErrors($errors);
        $response = $errorMessage->get();
        echo json_encode($response);
        return;
    }

    // connection
    $database = new Database();
    $connection = $database->getConnection();

    // create hero
    $hero = new Hero($connection);

    $result = $hero->deleteById($_POST['id']);
    $success = $result['success'];
    if (!$success) {
        header("HTTP/1.0 500 Internal Server Error");
        if (isset($result['message'])) {
            $errorMessage = ErrorMessage::singleError($result['message']);
            $response = $errorMessage->get();
            echo json_encode($response);
            return;
        }
    }
    header("HTTP/1.0 200 O.K");
    echo json_encode($result);
}
?>