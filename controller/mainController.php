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
                $keySearch = '%' . $this->keySearch . '%';
                $doSearch = $this->keySearch == "" ? 1 : 0;
                $dbConnection = $this->config->getConnection();
                $stmt = $dbConnection->prepare($this->config->getQuery());
                $stmt->bindValue(':idNode', $this->nodeId, PDO::PARAM_INT);
                $stmt->bindValue(':language', $this->language, PDO::PARAM_STR);
                $stmt->bindValue(':keySearch', $this->keySearch, PDO::PARAM_STR);
                $stmt->bindValue(':disableSearch', $doSearch, PDO::PARAM_INT);
                $stmt->bindValue(':limit', $this->pageSize, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $this->pageNum, PDO::PARAM_INT);
                $stmt->execute();
                // $stmt->bind_result($idNode, $nodeName, $childrenCount);
                // while ($stmt->fetch()) {
                //     $node = new Node($idNode, $nodeName, $childrenCount);
                // }
                for($currentNode = $stmt->fetchObject('Node'); !$end; $stmt->fetchObject('Node')){
                    if(isset($currentNode) && $currentNode != false){
                        $response->addNode($currentNode);
                    }
                    else{
                        $end = true;
                    }
                }

                $stmt->close();

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