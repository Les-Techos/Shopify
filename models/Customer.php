<?php
    include_once('User.php');
    include_once('Login.php');

    class Customer extends User{
              
        public function __construct($id_p){
            parent::__construct($id_p,'customers', 'id');
            $this->datas = (new class extends DB_datas{
                public $forname = '';
                public $surname = '';
                public $add1 = '';
                public $add2 = '';
                public $add3 = '';
                public $postcode = '';
                public $phone = '';
                public $email = '';
                public $registered = '';
                public Login $log;
            });
            $this->get_data();
        }
    }

?>