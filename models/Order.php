<?php
include_once("DB_Object.php");

class Order extends DB_Object{
    public function __construct($id_p= -1){
        self::$data_table = 'orders';
        parent::__construct($id_p);
    }
}

?>