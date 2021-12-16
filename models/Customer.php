<?php
    include_once('User.php');
    include_once('Order.php');
    include_once('Login.php');

    class Customer extends User{
        public static $data_table = 'customers';

        public function __construct($id_p= -1){
            parent::__construct($id_p);
            $this->linked_datas_infos = (new class extends DB_linked_datas_infos{
                public Order $orders;
                public Login $logins;
            });

            $this->linked_column_infos = (new class extends DB_linked_column_infos{
                public $orders = "customer_id";
                public $logins = "customer_id";
            });
            $this->order_66();
        }
    }
?>