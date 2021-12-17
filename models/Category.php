<?php
    include_once('DB_Object.php');
    include_once('Product.php');
    class Category extends DB_Object{
        public static $data_table = 'categories';

        public function __construct($id = -1){
            parent::__construct($id);
            $this->linked_datas_infos = (new class extends DB_linked_datas_infos{
                public Product $products;
            });
            $this->linked_column_infos = (new class extends DB_linked_column_infos{
                public $products = "cat_id";
            });

            $this->order_66();
        }
    }
?>