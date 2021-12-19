<?php
    include_once('DB_Object.php');
    include_once('Address.php');

    class Address extends DB_Object{
        public static $data_table = "delivery_addresses";

        public function __construct($id = -1){
            parent::__construct($id);
            $this->linked_datas_infos = (new class extends DB_linked_datas_infos{
                public Order $orders;
            });
            $this->linked_column_infos = (new class extends DB_linked_column_infos{
                public $orders = "delivery_add_id";
            });
            $this->order_66();
        }
    }
?>