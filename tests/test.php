<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');
    
    include_once '../api/controller/mainController.php';
    include_once '../api/config/config.php';
    include_once '../api/model/node.php';
    include_once '../api/model/response.php';
    include_once '../api/model/getParams.php';
    // echo(json_encode($_GET));
    class Test{
        const TOTAL = 15;
        public $config;

        public function executeTests(){
            $testCounter = 0;
            try{
                // Testing Config
                echo "Testing Config\r\n";
                $config = new Config();
                if(!isset($config)){
                    echo "Config constructor not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n";
                    return;
                }
                else{
                    $testCounter++;
                }

                // Testing Config::getConnection
                echo "Testing Config::getConnection\r\n";
                $dbConn = $config->getConnection();
                if(!isset($dbConn)){
                    echo "Config::getConnection method not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n";
                    return;
                }
                else{
                    $testCounter++;
                }

                // Testing database connection
                echo "Testing database connection\r\n";
                $stmt = $dbConn->prepare($config->getCheckParentQuery());
                $stmt->bindValue(':idNode', 5);
                $stmt->execute();
                $data = $stmt->fetchAll();
                if(!isset($data)){
                    echo "DB connection not set correctly\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n";
                    return;
                }
                else{
                    $testCounter++;
                }

                // Testing language configuration
                echo "Testing language configuration\r\n";
                $lang = $config->getLanguage('english');
                if(!isset($lang)){
                    echo "Config language configuration not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n";
                    return;
                }
                else{
                    $testCounter++;
                }

                // Testing language configuration
                echo "Testing language configuration\r\n";
                $lang = $config->getLanguage('italian');
                if(!isset($lang)){
                    echo "Config language configuration not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n";
                    return;
                }
                else{
                    $testCounter++;
                }
                
                // Testing language configuration
                echo "Testing language configuration\r\n";
                $lang = $config->getLanguage('noLanguage');
                if(isset($lang)){
                    echo "Config language configuration not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n";
                    return;
                }
                else{
                    $testCounter++;
                }
                
                // Testing MainController
                echo "Testing MainController\r\n";
                $controller = new MainController();
                if(!isset($controller)){
                    echo "MainController constructor not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n";
                    return;
                }
                else{
                    $testCounter++;
                }

                // Testing MainController::readData response
                echo "Testing MainController::readData\r\n";
                $controller = new MainController();
                $testJsonResponse = '{"nodes":[{"node_id":"8","name":"Italia","children_count":"0"},{"node_id":"9","name":"Europa","children_count":"0"},{"node_id":"11","name":"Nord America","children_count":"0"}],"error":""}';
                $testResponseObj = json_decode($testJsonResponse);
                $params = null;
                $response = null;
                $params = ['node_id' => 7, 'language'=> 'italian'];
                $response = $controller->readData($params);
                if(!isset($response)){
                    echo "1.MainController::readData not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n";
                    return;

                }
                else{
                    $testCounter++;
                    if($response != $testJsonResponse){
                        echo "2.MainController::readData not working\r\n";
                        echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n";   
                        return; 
                    }
                    else {
                        $testCounter++;
                    }
                }

                // Testing MainController::readData parameters validation
                echo "Testing MainController::readData parameters validation\r\n";
                $controller = new MainController();
                $params = null;
                $response = null;
                $params = ['language'=> 'italian'];
                $response = $controller->readData($params);
                $responseObj = json_decode($response);
                if(!isset($response) || $responseObj->error != "Missing manadatory params"){
                    echo "3.MainController::readData not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n";
                    return;
                }
                else {
                    $testCounter++;
                }

                // Testing MainController::readData parameters validation
                echo "Testing MainController::readData parameters validation\r\n";
                $controller = new MainController();
                $params = null;
                $response = null;
                $params = ['node_id' => 7];
                $response = $controller->readData($params);
                $responseObj = json_decode($response);
                if(!isset($response) || $responseObj->error != "Missing manadatory params"){
                    echo "4.MainController::readData not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n"; 
                    return;   
                }
                else {
                    $testCounter++;
                }

                // Testing MainController::readData parameters validation
                echo "Testing MainController::readData parameters validation\r\n";
                $controller = new MainController();
                $params = null;
                $response = null;
                $testJsonResponse = '{"nodes":[{"node_id":"11","name":"Nord America","children_count":"0"}],"error":""}';
                $params = ['node_id' => 7, 'language'=> 'italian', 'search_keyword' => 'america'];
                $response = $controller->readData($params);
                if(!isset($response) || $testJsonResponse != $response){
                    echo "5.MainController::readData not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n"; 
                     return;   
                }
                else {
                    $testCounter++;
                }

                // Testing MainController::readData parameters validation
                echo "Testing MainController::readData parameters validation\r\n";
                $controller = new MainController();
                $params = null;
                $response = null;
                $params = ['node_id' => 100, 'language'=> 'italian'];
                $response = $controller->readData($params);
                $responseObj = json_decode($response);
                if(!isset($response) || $responseObj->error != "Invalid Node Id"){
                    echo "6.MainController::readData not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n"; 
                    return;   
                }
                else {
                    $testCounter++;
                }

                // Testing MainController::readData parameters validation
                echo "Testing MainController::readData parameters validation\r\n";
                $controller = new MainController();
                $params = null;
                $response = null;
                $params = ['node_id' => 7, 'language'=> 'italian', 'page_num' => -1];
                $response = $controller->readData($params);
                $responseObj = json_decode($response);
                if(!isset($response) || $responseObj->error != "Invalid page number requested"){
                    echo "7.MainController::readData not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n"; 
                     return;   
                }
                else {
                    $testCounter++;
                }

                // Testing MainController::readData parameters validation
                echo "Testing MainController::readData parameters validation\r\n";
                $controller = new MainController();
                $params = null;
                $response = null;
                $params = ['node_id' => 7, 'language'=> 'italian', 'page_size' => -1];
                $response = $controller->readData($params);
                $responseObj = json_decode($response);
                if(!isset($response) || $responseObj->error != "Invalid page size requested"){
                    echo "8.MainController::readData not working\r\n";
                    echo "Passed tests: $testCounter / " . Test::TOTAL . "\r\n";
                     return;   
                }
                else {
                    $testCounter++;
                }        
            } catch(Exception $ex){
                echo $ex->getMessage();
            }

            echo "Passed tests: $testCounter / " . Test::TOTAL;

            return;
        }
    }

    $testObj = new Test();

    $testObj->executeTests();
?>