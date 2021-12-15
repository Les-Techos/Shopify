<?php
include_once("DB_Object.php");

class Order extends DB_Object{
    public static $data_table = 'orders';

    public function __construct($id_p= -1){
        parent::__construct($id_p);
    }
}

?>