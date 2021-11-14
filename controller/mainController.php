<?php

    class MainController implements JsonSerializable {
        private Config $config;
        private int $nodeId;
        private string $language;
        private string $keySearch;
        private int $pageNum;
        private int $pageSize;
        private Response $response;

        public function __construct($getParams){
            $this->config = new Config();
            $this->nodeId = $getParams['node_id'];
            $this->language = $getParams['language'];
            $this->response = new Response();
            $this->keySearch = isset($getParams['search_keyword']) ? $getParams['search_keyword'] : "";
            $this->pageNum = isset($getParams['page_num']) ? $getParams['page_num'] : 0;
            $this->pageSize = isset($getParams['page_size']) ? $getParams['page_size'] : 100;
        }

        public function readData(){
            $response = new Response();
            try{
                echo json_encode($this);
                $doSearch = $this->keySearch != "" ? 1 : 0;
                $dbConnection = $this->config->getConnection();
                $stmt = $dbConnection->prepare($this->config->getQuery());
                $stmt->bindValue(':idNode', $this->nodeId);
                $stmt->bindValue(':language', $this->language);
                // $stmt->bindValue(':keySearch', $this->keySearch);
                // $stmt->bindValue(':disableSearch', $doSearch);
                $stmt->bindValue(':limit', $this->pageSize);
                $stmt->bindValue(':offset', $this->pageNum);
                $stmt->execute();
                // $stmt->execute([
                //     ':idNode' => $this->nodeId,
                //     ':language' => $this->language,
                //     ':keySearch' => $this->keySearch,
                //     ':disableSearch' => $keySearch,
                //     ':limit' => $this->pageSize,
                //     ':offset' => $this->pageNum
                // ]);
                // echo $stmt->rowCount();
                echo json_encode($stmt->fetchAll());
                // $currentNode = $stmt->fetchObject();
                // while($currentNode != false){
                //     echo $currentNode->toJson();
                //     // $response->addNode($currentNode);
                // }
                // for($currentNode = $stmt->fetchObject(); $currentNode != false; $response->addNode($currentNode), $currentNode->fetchObject());

            } catch(Exception $ex){
                echo $ex->getMessage();
            }

            return $response;
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