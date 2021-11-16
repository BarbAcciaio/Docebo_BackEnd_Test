<?php
    /**
     * Main controller to handle GET request
     */
    class MainController {
        /**
         * Configuration object
         */
        private $config;
        /**
         * Response object
         */
        private $response;

        /**
         * Intialization of configuration and response objects
         */
        public function __construct(){
            $this->config = new Config();
            $this->response = new Response();
        }

        /**
         * Function to read requested data from database
         * Returns json representing requested data
         */
        public function readData($params){
            try{
                $dbConnection = $this->config->getConnection();
                // Excracting GET params
                $getParams = GetParams::extractParams($params);
                // Parameters validation
                if($this->validateParams($getParams)){
                    // Query on db and setting result
                    $keySearch = '%' . $getParams->getKeySearch() . '%';
                    $disableSearch = $getParams->getDisabledSearch();
                    $language = $this->config->getLanguage($getParams->getLanguage());
                    $pageNum = $getParams->getPageNum();
                    $pageSize = $getParams->getPageSize();
                    $offset = $pageNum * $pageSize;
                    $stmt = $dbConnection->prepare($this->config->getQuery());
                    // Binding params to prepared statement
                    $stmt->bindValue(':idNode', $getParams->getNodeId(), PDO::PARAM_INT);
                    $stmt->bindValue(':language', $language, PDO::PARAM_STR);
                    $stmt->bindValue(':keySearch', $keySearch, PDO::PARAM_STR);
                    $stmt->bindValue(':disableSearch', $disableSearch, PDO::PARAM_INT);
                    $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
                    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                    $stmt->execute();
                    // Fetching data
                    while (($row = $stmt->fetch())) {
                        $node = new Node($row["idNode"], $row["nodeName"], $row["childrenCount"]);
                        $this->response->addNode($node);
                    }
                }
            } catch(Exception $ex){
                $this->response->setError("Server error");
            }

            return $this->response->toJson();
        }

        /**
         * Function that validates params.
         * Returns boolean. If any problem is found sets response error message and returns false
         */
        private function validateParams($getParams){
            try{
                $nodeId = $getParams->getNodeId();
                $language = $getParams->getLanguage();
                $pageNum  = $getParams->getPageNum();
                $pageSize = $getParams->getPageSize();
                if(!isset($nodeId) || !isset($language)){
                    $this->response->setError("Missing manadatory params");
                    return false;
                }
                $lang = $this->config->getLanguage($language);
                if(!isset($lang)){
                    $this->response->setError("Unsupported language " . $language);
                }
                $dbConnection = $this->config->getConnection();
                $stmt = $dbConnection->prepare($this->config->getCheckParentQuery());
                $stmt->bindValue(':idNode', $nodeId, PDO::PARAM_INT);
                $stmt->execute();
                
                $dbNodeId = $stmt->fetchColumn();
                if($nodeId != $dbNodeId){
                    $this->response->setError("Invalid Node Id");
                }

                if(!isset($pageNum) || $pageNum < 0){
                    $this->response->setError("Invalid page number requested");
                    return false;
                }
                if(!isset($pageSize) || $pageSize < GetParams::MIN_PAGE_SIZE || $pageSize > GetParams::MAX_PAGE_SIZE){
                    $this->response->setError("Invalid page size requested");
                    return false;
                }
            } catch(Exception $ex){
                $this->response->setError("Server error");
                return false;
            }

            return true;
        }        
    }
?>