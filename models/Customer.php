<?php
    include_once('User.php');
    include_once('Order.php');

    class Customer extends User{
        public static $data_table = 'customers';

        public function __construct($id_p= -1){
            $this->linked_datas_infos = (new class extends DB_linked_datas_infos{
                public Order $orders;
                //public string $orders_idcol = "customer_id";
            });

            parent::__construct($id_p);
        }
    }
?>