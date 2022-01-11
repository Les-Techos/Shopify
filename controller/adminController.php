<?php require_once "controller.php";
require_once "./models/Order.php";
require_once "./models/Order_item.php";
require_once "./models/Product.php";
require_once "./models/Address.php";

class adminController extends controller
{
    public function __construct()
    {

        $this->controllerData["order"] = "";
        $this->controllerData["username"] = "";
    }

    public function routerDefaultAction()
    {
        try {
            Order::get_data_array($this->objDatabase, "id", '%_');
        } catch (Exception $e) {
            throw $e;
        }

        if ($_SESSION["status"] == "admin") {
            if (!empty($_POST["valideradmin"]))
                $this->increaseState($_POST["idOrder"]);
                try{
                    $Admin = new Admin($_SESSION["connection_id"]);
                }catch (Exception $e){
                    throw $e;
                }
                
            if (!empty($_POST["modify"])) {
                $this->updateInfos($Admin);
            }
            $this->controllerData["username"] = $Admin->datas->username;
            $this->diplayAllOrders();
            return $this->controllerData;
        } else {
            header('Location: ./');
            exit();
        }
    }

    public function displayOrder($Order)
    {

        $this->controllerData["order"] .= '<li class = "list-group-item">
        Achat du client n°' . $Order->datas->customer_id . '               Le ' . $Order->datas->date . '               '
            . '<form method = "POST" action = "">' . $this->displayButton($Order->datas->status) . '<input type = "hidden" name = "idOrder" value ="' . $Order->id . '" /></form>        
        <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#Details' . $Order->id . '" aria-expanded="false" aria-controls="collapseExample" >Détails achat &#9997; </button>
        <div class="collapse" id="Details' . $Order->id . '">
            <div id="address">'
            . $this->DisplayAddress($Order->datas->delivery_add_id) .
            '</div>
            <ul class="list-group">
                ' . $this->displayOrderProducts($Order->id) . '
            </ul>
            
        </div>
        </li>';
    }

    public function diplayAllOrders()
    {
        foreach ($this->objDatabase as $order) {
            if (($order->datas->status > 0) && ($order->datas->status < 10)) {
                $this->displayOrder($order);
            }
        }
    }

    public function displayOrderProducts($idOrder)
    {
        $itemArray = [];
        try{
            Order_item::get_data_array($itemArray, "order_id", $idOrder);
        }catch(Exception $e){
            throw $e;
        }
        
        $result = "";
        foreach ($itemArray as $order_product) {
            try{
                $Product = new Product($order_product->datas->product_id);
            }catch(Exception $e){
                throw $e;
            }
            
            $result .= '<li class="list-group-item" >
            <img style="height:50px" src="./assets/image/' . $Product->datas->image . '">
                ' . $Product->datas->name . '
                <input type="number" name="quantity" style="min-width:25px; max-width:50px" min="0" value = "' . $order_product->datas->quantity . '" disabled/>
            </li>
        ';
        }
        return $result;
    }

    public function displayButton($state)
    {
        $result = "";
        switch ($state) {
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

    public function displayAddress($idAddress)
    {
        $result = "";
        try{
            $Address = new Address($idAddress);
            foreach ($Address->datas as $key => $parameters) {
                if ($key != "id")
                    $result .= '<h6>' . $key . " : " . $parameters . "</h6>";
            }
            return $result;
        }catch(Exception $e){
            throw $e;
        }
        
        
    }

    public function increaseState($Orderid)
    {
        try{
                $Order = new Order($Orderid);
            if ($Order->datas->status == 1) {
                $Order->datas->status++;
            } elseif ($Order->datas->status > 1 && $Order->datas->status < 10) {
                $Order->datas->status = 10;
            }
            $Order->set_data();
        }catch(Exception $e){
            throw $e;
        }
        
    }

    public function updateInfos(&$l)
    {
        $username = $_POST["username"];
        $users = [];
        $admins = [];

        try{
            Login::get_data_array($users, "username", $username);
            Admin::get_data_array($admins, "username", $username);
        }catch(Exception $e){
            throw $e;
        }


        $d_l = &$l->datas;

        if (!empty($_POST["password"])) {
            if ($_POST["password"] != $_POST["cpassword"]) {
                $this->controllerData["message"] = '<div class="alert alert-danger" role="alert"> Les mots de passe ne correspondent pas</div>';
            } else {
                $d_l->password = hash("sha1", $_POST["password"]);
            }
        }

        if ((empty($users) && empty($admins)) || ($username == $l->datas->username)) {
            $d_l->username = $_POST["username"];
            try{
                $l->set_data();
            }catch(Exception $e){ throw $e; }
            
        } else {
            $this->controllerData["message"] = '<div class="alert alert-danger" role="alert"> Le login existe déjà</div>';
        }
    }
}
