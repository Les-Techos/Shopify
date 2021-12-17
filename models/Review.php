<?php 
    include_once("DB_Object.php");
    
    class Review extends DB_Object{
        public static $data_table = "reviews";
        public function __construct($id = -1){
            parent::__construct($id);
        }
    }
?>