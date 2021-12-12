<?php
    include_once('DB_Object.php');

    abstract class User extends DB_Object{

        public function __construct($id_p, $data_table_p){
            parent::__construct($id_p, $data_table_p);
        }
    }
?>