<?php require_once "controller.php";

class panierController extends controller{


    public function __construct()
    {
        Product::get_data_array($this->objDatabase, "id", '%_');
        $this->controllerData  = "";
    }

    public function routerDefaultAction(){
        if(empty($_SESSION['PANIER'])){
            $this->controllerData ="<h2> Votre panier est tristement vide :( </h2>";
        }else{
            $this->returnCards();
        }
        return $this->controllerData;
    }

    public function returnCards(){
        $this->controllerData .= '
        <li class="list-group-item">
            <input type="checkbox" value="" id="product A">
            <img src="..\assets\image\assortimentBiscuitsSec.jpg">
            Product name
            <input type="number" style="min-width:25px; max-width:50px"/>
        </li>
        ' ;
    }
}

?>