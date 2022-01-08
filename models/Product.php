<?php
    include_once("Order_item.php");
    include_once("DB_Object.php");
    include_once("Review.php");

    class Product extends DB_Object{
        public static $data_table = "products";

        public function __construct($id = -1){
            parent::__construct($id);
            $this->linked_datas_infos = (new class extends DB_linked_datas_infos{
                public Order_item $orderitems;
                public Review $reviews;
            });

            $this->linked_column_infos = (new class extends DB_linked_column_infos{
                public $orderitems = "product_id";
                public $reviews = "id_product";
            });
            
        }
    }