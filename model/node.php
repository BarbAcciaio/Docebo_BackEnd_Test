<?php

    include_once '/model/config.php';

    class Node {
        private $config;
        private $nodeId;
        private $name;
        private $level;
        private $iLeft;
        private $iRight;
        private $childdrenCount;

        public function __construct($config, $nodeId, $name, $level, $iLeft, $iRight){
            $this->config = $config;
            $this->nodeId = $nodeId;
            $this->name = $name;
            $this->level = $level;
            $this->iLeft = $iLeft;
            $this->iRight = $iRight;
            $this->childrenCount = 0;
        }

        public function countChildren(){
            try{
                $dbConnection = $this->config->getConnection();
                $stmt = $dbConnection->prepare($this->config->getNodeChildrenQuery());
                $stmt->bindParam(':childLevel', level + 1);
                $stmt->bindParam(':iLeft', $this->iLeft);
                $stmt->bindParam(':iRight', $this->iRight);
                $stmt->execute();
                $this->childrenCount = $stmt->rowCount();
            } catch(PDOException $ex){
                echo $ex->getMessage();
            }
        }

        public static function loadNode($config, $nodeId){
            $result = null;
            try{
                $dbConnection = $config->getConnection();
                $stmt = $dbConnection->prepare($config->getSingleNodeQuery());
                $stmt->execute(['nodeId' => $nodeId]);
                list('idNode' => $idNode, 'level' => $level, 'iLeft' => $iLeft, 'iRight' => $iRight) = $stmt->fetch();

                $result = new Node($config, $idNode, $level, $iLeft, $iRight);
                $result->countChildren();
            } catch(PDOException $ex){
                echo $ex->getMessage();
            }

            return $result;
        }
    }
?>