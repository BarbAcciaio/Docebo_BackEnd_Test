<?php
    class Config {
        private $host = "127.0.0.1";
        private $database_name = "test_organization";
        private $username = "root";
        private $password = "qazwsx159753";
        private $treeTable = 'node_tree';
        private $nodeNameTable = 'node_tree_names';
        private $singleNodeQuery = 'SELECT idNode, level, iLeft, iRight
                                      FROM %s.%s nodes 
                                      LEFT JOIN %s.%s names
                                      WHERE nodes.idNode = :nodeId';
        private $nodeChildrenQuery = 'SELECT idNode
                                        FROM $s.%s
                                       WHERE level = :childLevel
                                         AND iLeft BETWEEN :fatherLeft AND :fatherRight';

        public $conn;

        public function __construct(){
            $this->singleNodeQuery = printf($this->singleNodeQuery, $this->database_name, $this->treeTable, $this->database_name, $this->nodeNameTable);
            $this->nodeChildrenQuery = printf($this->nodeChildrenQuery, $this->database_name, $this->treeTable);
        }

        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $ex){
                echo "Could not connect to database: " . $ex->getMessage();
            }

            return $this->conn;
        }

        public function getSingleNodeQuery(){
            return $this->singleNodeQuery;
        }

        public function getNodeChildrenQuery(){
            return $this->nodeChildrenQuery;
        }
    }
?>