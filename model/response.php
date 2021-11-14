<?php
    class Response {
        private $nodes;
        private $error;

        public function __construct(){
            $this->nodes = array();
            $this->error = "";
        }

        public function toJson(){
            return json_encode($this);
        }

        public function setError($error){
            $this->error = $error;
        }

        public function addNode($node){
            if(!is_array($nodes))
                $this->nodes = array();
            return array_push($this->nodes, $node);
        }
    }
?>