<?php
    /**
     * Class containing all configuration params
     */
    class Config {
        private $host = "127.0.0.1";
        private $database_name = "test_organization";
        private $username = "root";
        private $password = "qazwsx159753";
        private $treeTable = 'node_tree';
        private $nodeNameTable = 'node_tree_names';
        private $connectionString = 'mysql:host={host};dbname={dbName}';
        /**
         * Main Query
         */
        private $query = 'SELECT nodes.idNode
                                ,names.nodeName
                                ,(SELECT COUNT(*)
                                    FROM {treeTable} children
                                   WHERE children.iLeft BETWEEN nodes.iLeft AND nodes.iRight
                                     AND children.level = nodes.level + 1) childrenCount
                            FROM {treeTable} nodes
                            LEFT JOIN {nodeNameTable} names ON nodes.idNode = names.idNode
                           INNER JOIN(SELECT f.level, f.iLeft, f.iRight
                                        FROM {treeTable} f
                                       WHERE f.idNode = :idNode) father
                           WHERE nodes.level = father.level + 1
                             AND nodes.iLeft BETWEEN father.iLeft AND father.iRight
                             AND names.language = :language
                             AND (names.nodeName like :keySearch OR :disableSearch = 1)
                           LIMIT :limit OFFSET :offset';
        /**
         * Query to check parent existance
         */
        private $checkParentQuery = 'SELECT idNode
                                       FROM {treeTable}
                                      WHERE idNode = :idNode';

        /**
         *  "Enum" containing supported language
         */ 
        private $langEnum = array('english' => 'english', 'italian' => 'italian');

        public $conn;

        public function __construct(){
            $this->connectionString = str_replace('{host}', $this->host, $this->connectionString);
            $this->connectionString = str_replace('{dbName}', $this->database_name, $this->connectionString);
            $this->checkParentQuery = str_replace('{treeTable}', $this->treeTable, $this->checkParentQuery);
            $this->query = str_replace('{treeTable}', $this->treeTable, $this->query);
            $this->query = str_replace('{nodeNameTable}', $this->nodeNameTable, $this->query);
        }
        /**
         * Returns connection to database
         */
        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO($this->connectionString, $this->username, $this->password);
                $this->conn->exec("set names utf8");
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $ex){
                $this->conn = null;
                echo $ex->getMessage();
            }

            return $this->conn;
        }

        public function getQuery(){
            return $this->query;
        }

        public function getCheckParentQuery(){
            return $this->checkParentQuery;
        }

        public function getLanguage($idLanguage){
            return $this->langEnum[$idLanguage];
        }

    }
?>