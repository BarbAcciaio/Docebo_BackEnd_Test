<?php
    // Class representing Node model
    class Node implements JsonSerializable {
        private $nodeId;
        private $name;
        private $childrenCount;

        // Constructor
        public function __construct($nodeId, $name, $childrenCount){
            $this->nodeId = $nodeId;
            $this->name = $name;
            $this->childrenCount = $childrenCount;
        }

        public function jsonSerialize(){
            return [
                'node_id' => $this->nodeId,
                'name' => $this->name,
                'children_count' => $this->childrenCount
            ];
        }

        public function toJson(){
            return json_encode($this);
        }

    }
?>