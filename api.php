<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');
    
    include_once './controller/mainController.php';
    include_once './config/config.php';
    include_once './model/node.php';
    include_once './model/response.php';
    include_once './model/getParams.php';
    // echo(json_encode($_GET));

    // Instance of MainController to handle GET request
    $mainController = new MainController();
    // Retrieving data
    $response = $mainController->readData($_GET);
    // Returning data
    echo $response;
?>