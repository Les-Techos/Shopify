<?php
    include_once('User.php');
    class Customer extends User{
        public $forname = '';
        public $surname = '';
        public $add1 = '';
        public $add2 = '';
        public $add3 = '';
        public $postcode = '';
        public $phone = '';
        public $email = '';
        public $registered = '';

        
        public function __construct($id_p){
            parent::__construct($id_p,'customers', 'id');
            $this->get_data();
        }
    }

?>