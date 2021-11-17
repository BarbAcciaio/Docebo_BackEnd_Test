<?php
    /**
     * Class representing expected params from client
     */
    class GetParams{
        /**
         * Default page number
         */
        const DEFAULT_PAGE_NUM = 0;
        /**
         * Default page size
         */
        const DEFAULT_PAGE_SIZE = 100;
        /**
         * Max page size
         */
        const MAX_PAGE_SIZE = 1000;
        /**
         * Min page size
         */
        const MIN_PAGE_SIZE = 0;


        private $nodeId;
        private $language;
        private $keySearch;
        private $disableSearch;
        private $pageNum;
        private $pageSize;

        // public function __construct($nodeId, $language, $disableSearch, $keySearch, $pageNum, $pageSize){
        //     $this->nodeId = $nodeId;
        //     $this->language = $language;
        //     $this->disableSearch = $disableSearch;
        //     $this->keySearch = $keySearch;
        //     $this->pageNum = $pageNum;
        //     $this->pageSize = $pageSize;
        // }

        public function getNodeId(){
            return $this->nodeId;
        }

        public function getLanguage(){
            return $this->language;
        }

        public function getKeySearch(){
            return $this->keySearch;
        }

        public function getDisabledSearch(){
            return $this->disableSearch;
        }

        public function getPageNum(){
            return $this->pageNum;
        }

        public function getPageSize(){
            return $this->pageSize;
        }

        public static function extractParams($getParams){
            try{
                // $nodeId = isset($getParams['node_id']) ? $getParams['node_id'] : null;
                // $language = isset$getParams['language'];
                // $keySearch = isset($getParams['search_keyword']) ? $getParams['search_keyword'] : "NO SEARCH";
                // $disableSearch = (!isset($getParams['search_keyword']) || $getParams['search_keyword']  == "") ? 1 : 0;
                // $pageNum = isset($getParams['page_num']) ? $getParams['page_num'] : GetParams::DEFAULT_PAGE_NUM;
                // $pageSize = isset($getParams['page_size']) ? $getParams['page_size'] : GetParams::DEFAULT_PAGE_SIZE;
                $result = new GetParams();
                $result->nodeId = isset($getParams['node_id']) ? $getParams['node_id'] : null;
                $result->language = isset($getParams['language']) ? $getParams['language'] : null;
                $result->keySearch = isset($getParams['search_keyword']) ? $getParams['search_keyword'] : "NO SEARCH";
                $result->disableSearch = (!isset($getParams['search_keyword']) || $getParams['search_keyword']  == "") ? 1 : 0;
                $result->pageNum = isset($getParams['page_num']) ? $getParams['page_num'] : GetParams::DEFAULT_PAGE_NUM;
                $result->pageSize = isset($getParams['page_size']) ? $getParams['page_size'] : GetParams::DEFAULT_PAGE_SIZE;
                return $result;
            } catch(Exception $ex){
                http_response_code(500);
            }
        }
    }
?>