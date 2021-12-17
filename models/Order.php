<?php
include_once("DB_Object.php");
include_once("Order_item.php");

class Order extends DB_Object{
    public static $data_table = 'orders';

    public function __construct($id_p= -1){
        parent::__construct($id_p);
        $this->linked_datas_info = (new class extends DB_linked_datas_infos{
            public Order_item $orderitems;
        });

        $this->linked_column_info = (new class extends DB_linked_column_infos{
            public $orderitems = "order_id";
        });
        $this->order_66();
    }
}

?>