<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    
include('../config/database.php');
include('../objects/relation.php');
include('../objects/errorMessage.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    if (empty($_POST['heroId1'])) {
        array_push($errors, 'Id of first hero is required');
    }

    if (empty($_POST['heroId2'])) {
        array_push($errors, 'Id of second hero is required');
    }

    if (empty($_POST['isFriendly'])) {
        array_push($errors, 'is friendly parameter is required');
    }

    if (!ctype_digit($_POST['heroId1'])) {
        array_push($errors, 'Id of first hero must be a number');
    }
    
    if (!ctype_digit($_POST['heroId2'])) {
        array_push($errors, 'Id of second hero must be a number');
    }

    if (!ctype_digit($_POST['isFriendly']) || (intval($_POST['isFriendly']) != 0 && intval($_POST['isFriendly']) != 1)) {
        array_push($errors, 'Is Friendly must be a number of either 0 or 1');
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

    // create hero
    $relation = new Relation($connection);
    $relation->setHeroId1($_POST['heroId1']);
    $relation->setHeroId2($_POST['heroId2']);
    $relation->setIsFriendly($_POST['isFriendly']);;

    $result = $relation->update();
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

