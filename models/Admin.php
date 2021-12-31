<?php
    include_once('DB_Object.php');

    class Admin extends DB_Object{
        public static $data_table = "admin";

        public function __construct($id_p = -1){

            parent::__construct($id_p);
        }
    }
?>