<?php
    include_once('bd.php');
    include_once('DB_Object.php');

    abstract class User extends DB_Object{
        protected $logged = FALSE;
        protected $username = '';
        protected $password_hsh = '';

        public function __construct($id_p, $data_table_p, $id_name_p){
            parent::__construct($id_p, $data_table_p, $id_name_p);
        }
    }
?>