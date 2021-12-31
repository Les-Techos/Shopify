<?php require_once "controller.php";
require_once "./models/Order.php";
require_once "./models/Order_item.php";
require_once "./models/Product.php";
require_once "./models/Address.php";

class adminController extends controller{
    public function __construct()
    {
        Order::get_data_array($this->objDatabase, "id", '%_');
        $this->controllerData  = "";
    }

    public function routerDefaultAction(){
        if($_SESSION["status"]=="admin"){
            if(!empty($_POST["valideradmin"]))
                $this->increaseState($_POST["idOrder"]);
            $this->diplayAllOrders();
            return $this->controllerData;
        }else{
            header('Location: /');
            exit();
        }
    }

    public function displayOrder($Order){

        $this->controllerData .= '<li class = "list-group-item">
        Achat du client n°'.$Order->datas->customer_id.'               Le '.$Order->datas->date.'               '
        .'<form method = "POST" action = "">'.$this->displayButton($Order->datas->status).'<input type = "hidden" name = "idOrder" value ="'.$Order->id.'" /></form>        
        <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#Details'.$Order->id.'" aria-expanded="false" aria-controls="collapseExample" >Détails achat &#9997; </button>
        <div class="collapse" id="Details'.$Order->id.'">
            <div id="address">'
                .$this->DisplayAddress($Order->datas->delivery_add_id).
            '</div>
            <ul class="list-group">
                '.$this->displayOrderProducts($Order->id).'
            </ul>
            
        </div>
        </li>';
    }

    public function diplayAllOrders(){
        foreach($this->objDatabase as $order){
            if($order->datas->status > 0 && $order->datas->status <11){
            $this->displayOrder($order);
            }
        }
    }

    public function displayOrderProducts($idOrder){
        $itemArray = [];
        Order_item::get_data_array($itemArray, "order_id", $idOrder);
        $result = "";
        foreach($itemArray as $order_product){
            $Product = new Product($order_product->datas->product_id);
            $result .= '<li class="list-group-item" >
            <img style="height:50px" src="/assets/image/' . $Product->datas->image . '">
                ' . $Product->datas->name . '
                <input type="number" name="quantity" style="min-width:25px; max-width:50px" min="0" value = "' . $order_product->datas->quantity . '" disabled/>
            </li>
        ';
        }
        return $result;
    }

    public function displayButton($state){
        $result = "";
        switch($state){
            case 1:
                $result = '<input type="submit" name="valideradmin" class="btn btn-success" value = "Valider Paiement &#x2705;"/>';
                break;
            case 2:
                $result = '<input type="submit" name="valideradmin" class="btn btn-success" value ="Valider achat &#x2705; "/>';
                break;
            case 3:
                $result = '<input type="submit" name="valideradmin" class="btn btn-success" value="Valider achat &#x2705;" >';
                break;
            default:
                break;
        }
        return $result;
    }

    public function displayAddress($idAddress) {
        $result = "";
        $Address = new Address($idAddress);
        foreach ($Address->datas as $key=> $parameters){
            if($key != "id")
                $result.='<h6>'.$key." : ".$parameters."</h6>";
        }
        return $result;
        
    }

    public function increaseState($Orderid){
        $Order = new Order($Orderid);
        if($Order->datas->status == 1){
            $Order->datas->status ++;
        }elseif($Order->datas->status >1 && $Order->datas->status <10){
            $Order->datas->status = 10;
        }
        $Order->set_data();
    }

}
