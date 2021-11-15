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
    // echo(json_encode($_GET));

    $mainController = new MainController($_GET);
    $response = $mainController->readData();
    // echo $response->toJson();
    // $mainController->start();
    http_response_code(200);

?>