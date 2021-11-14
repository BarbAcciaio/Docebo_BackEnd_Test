<?php
    include_once '../config/config.php';

    class MainController{
        private $dbConnection;
        private $getParams;
        private $response;

        public function __construct($getParams){
            $config = new Config();
            $this->dbConnection = $config->getConnection();
            $this->getParams = $getParams;
        }
        
    }
?>