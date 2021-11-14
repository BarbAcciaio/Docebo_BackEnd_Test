<?php
    class Response {
        private $nodes;
        private $error;

        public function __construct($nodes, $error){
            $this->nodes = $nodes;
            $this->error = $error;
        }

        public function toJson(){
            return json_encode($this);
        }
    }
?>