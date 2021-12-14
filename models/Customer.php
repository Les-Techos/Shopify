<?php
    include_once('User.php');

    class Customer extends User{
        public function __construct($id_p= -1, $id_name = "id"){
            parent::__construct($id_p,'customers', $id_name);
        }
    }
?>