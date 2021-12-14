<?php
    include_once('User.php');

    class Customer extends User{
        public function __construct($id_p= -1){
            self::$data_table = 'customers';
            parent::__construct($id_p);
        }
    }
?>