<?php

    class MainController implements JsonSerializable {
        private Config $config;
        private Response $response;
        private $langEnum = array('english' => 'english', 'italian' => 'italian');

        public function __construct($getParams){
            $this->config = new Config();
            $this->response = new Response();
        }


        public function readData($getParams){
            try{
                $dbConnection = $this->config->getConnection();
                if(validateParams($dbConnection, $getParams)){
                    $keySearch = '%' . $getParams['search_keyword'] . '%';
                    $doSearch = (!isset($getParams['search_keyword']) || $getParams['search_keyword']  == "") ? 1 : 0;
                    $language = $langEnum[$getParams['language']];
                    $dbConnection = $this->config->getConnection();
                    $stmt = $dbConnection->prepare($this->config->getQuery());
                    $stmt->bindValue(':idNode', $getParams['node_id'], PDO::PARAM_INT);
                    $stmt->bindValue(':language', $language, PDO::PARAM_STR);
                    $stmt->bindValue(':keySearch', $keySearch, PDO::PARAM_STR);
                    $stmt->bindValue(':disableSearch', $doSearch, PDO::PARAM_INT);
                    $stmt->bindValue(':limit', $getParams['page_size'], PDO::PARAM_INT);
                    $stmt->bindValue(':offset', $getParams['page_num'], PDO::PARAM_INT);
                    $stmt->execute();
                    while (($row = $stmt->fetch())) {
                        $node = new Node($row["idNode"], $row["nodeName"], $row["childrenCount"]);
                        $this->response->addNode($node);
                    }
                }
            } catch(Exception $ex){
                echo $ex->getMessage();
            }

            return $this->response;
        }

        public function validateParams($dbConnection, $getParams){
            try{
                if(!isset($getParams['node_id']) || !isset($getParams['language'])){
                    $response->setError("Missing manadatory params");
                    return false;
                }

                $stmt = $dbConnection->prepare($this->config->getQuery());
                $stmt->bindValue(':idNode', $getParams['node_id'], PDO::PARAM_INT);
                $stmt->execute();
                if(!($nodeId = $stmt->fetch()) || $nodeId != $getParams['node_id']){
                    $response->setError("InvalidNodeId");
                }
                if(!isset($getParams['page_num']) || !is_int($getParams['page_num'] || $getParams['page_num'] < 0)){
                    $response->setError("Invalid page number requested");
                    return false;
                }
                if(!isset($getParams['page_size']) || !is_int($getParams['page_size'] || $getParams['page_size'] < 0 || $getParams > 1000)){
                    $response->setError("Invalid page size requested");
                    return false;
                }
            } catch(Exception $ex){
                $this->response->setError("Server error");
                return false;
            }

            return true;
        }


        public function jsonSerialize(){
            $doSearch = $this->keySearch != "" ? 1 : 0;
            return [
                'node_id' => $this->nodeId,
                'language' => $this->language,
                'search_keyword' => $this->keySearch,
                'page_size'=> $this->pageSize,
                'page_num' => $this->pageNum,
                'do_search' => $doSearch
            ];
        }

        public function toJson(){
            return json_encode($this);
        }
        
    }
?>