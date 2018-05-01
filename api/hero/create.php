<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    
include('../config/database.php');
include('../objects/hero.php');
include_once('../objects/image.php');
include('../objects/errorMessage.php');
include_once('../shared/helper.php');

$helper = new Helper();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    if (empty($_POST['username'])) {
        array_push($errors, 'Username is required');
    }

    if (empty($_POST['firstname'])) {
        array_push($errors, 'Firstname is required');
    }

    if (empty($_POST['lastname'])) {
        array_push($errors, 'Lastname is required');
    }


    if (!empty($_FILES["image"]["tmp_name"]) && !$helper->isFileValidImage($_FILES["image"]["tmp_name"])) {
        array_push($errors, 'Image is missing or invalid');
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
    $hero = new Hero($connection);
    $hero->setUsername($_POST['username']);
    $hero->setFirstname($_POST['firstname']);
    $hero->setLastname($_POST['lastname']);
    $hero->setGender($_POST['gender']);

    $result = $hero->create();
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

    if (!empty($_FILES["image"]["tmp_name"])) {
        // upload the image with the new ID
        $file = $_FILES["image"]["tmp_name"];
        $image = new Image($result['id']);
        $uploadSuccess = $image->create($file);

        if (!$uploadSuccess) {
            header('HTTP/1.0 500 Internal Server Error');
            $errorMessage = ErrorMessage::singleError('Unable to upload image');
            $response = $errorMessage->get();
            echo json_encode($response);
            return;
        }
    }
    

    header('HTTP/1.0 200 O.K');
    echo json_encode($result);
}
?>

