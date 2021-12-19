<?php
    include_once("DB_Object.php");
    class Order_item extends DB_Object{
        public static $data_table = "orderitems";

        public function __construct($id = -1){
            parent::__construct($id);
        }
    }

?>