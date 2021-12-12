<?php
    include_once('User.php');

    class Customer extends User{
        public function __construct($id_p){
            parent::__construct($id_p,'customers');
        }
    }
?>