<?php
    /**
     * Class that represents data to be returned to client
     */
    class Response implements JsonSerializable {
        /**
         * Node list
         */
        private $nodes;
        private $error;

        public function __construct(){
            $this->nodes = array();
            $this->error = "";
        }

        public function setNodes($nodeList){
            $this->nodes = $nodeList;
        }

        public function setError($error){
            $this->error = $error;
        }

        public function addNode($node){
            if(!is_array($this->nodes))
                $this->nodes = array();
            return array_push($this->nodes, $node);
        }


        public function jsonSerialize(){
            return [
                'nodes' => $this->nodes,
                'error' => $this->error
            ];
        }

        public function toJson(){
            return json_encode($this);
        }

    }
?>