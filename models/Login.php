<?php
    include_once('DB_Object.php');

    class Login extends DB_Object{
        public static $data_table = "logins";

        public function __construct($id_p = -1){

            parent::__construct($id_p);
        }
    }
?>