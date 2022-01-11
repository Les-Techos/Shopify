<?php require_once "controller.php";
require_once "./models/Order.php";
require_once "./models/Order_item.php";

class panierController extends controller
{


    public function __construct()
    {
        $this->controllerData["list"] = "";
        $this->controllerData["Total"] = 0;
        $this->controllerData["nbArticles"] = 0;
        $this->controllerData["ValidateButton"] = "";
    }

    public function routerDefaultAction()
    {
        $this->throwAdmin();
        if (!empty($_POST['changevalue'])) {
            $this->changevalue($_POST['idProduct'], $_POST['quantity']);
            $this->cloudSave();
        } elseif (!empty($_POST['delete'])) {
            $this->changevalue($_POST['idProduct'], 0);
            $this->cloudSave();
        } elseif (!empty($_POST['idProduct'])) {
            if (empty($_POST['quantity']))
                $this->addToCart($_POST['idProduct']);
            else
                $this->addToCart($_POST['idProduct'], $_POST['quantity']);

            $this->cloudSave();
        }

        return $this->displayAllCart();
    }

    public function displayAllCart()
    {
        $this->getCartFromCloud();
        $this->controllerData["list"] = "";
        if (empty($_SESSION['PANIER'])) {
            $this->controllerData["list"] = "<h2> Votre panier est tristement vide :( </h2>";
        } else {

            foreach ($_SESSION['PANIER'] as $ProductData) {
                try{
                    $this->returnCards(new Product($ProductData["product_id"]), $ProductData["quantity"]);
                }catch(Exception $e){
                    throw $e;
                }
            }
            $this->controllerData["ValidateButton"] = '<a href="/?action=renseignement" class="btn btn-success" style="width:100%">Procéder au Paiement</a>';
        }
        return $this->controllerData;
    }

    public function returnCards($Product, $quantity)
    {
        $this->controllerData["list"] .= '
        <li class="list-group-item" >
        <div class="row">
            <div class=" float-left" style="width:90%">
           <form method="post" class="form-example">                
                <img style="height:50px" src="..\assets\image\\' . $Product->datas->image . '">
                ' . $Product->datas->name . '
                <input type="number" name="quantity" style="min-width:25px; max-width:50px" min="0" value = "' . $quantity . '"/>
                <input type="hidden" id ="idProduct" name="idProduct" value="' . $Product->datas->id . '"/>
                <input type="submit" name="changevalue" class="btn btn-success check" value="&#10004"/>
                <input type="reset" class="btn btn-primary" value="&#8617"/>
                <input type="submit" name="delete" class="btn btn-danger" value="&#10060;"/>
                
            </form>
            </div>
            <div style="text-align:right; width:10%">' . $quantity * $Product->datas->price . ' €</div>
            </div>           
        </li>
        ';
        $this->controllerData["nbArticles"] += $quantity;
        $this->controllerData["Total"] += $quantity * $Product->datas->price;
    }

    public function addToCart($Product, $quantity = 1)
    {
        $alreadyIn = array("bool" => false, "row" => 0);
        if (empty($_SESSION['PANIER'])) {
            $_SESSION['PANIER'] = [];
        } else {
            foreach ($_SESSION['PANIER'] as $cartProduct) {
                if ($cartProduct["product_id"] == $Product) {
                    $alreadyIn["bool"] = true;
                } elseif (!($alreadyIn["bool"])) {
                    $alreadyIn["row"]++;
                }
            }
        }
        if (!($alreadyIn["bool"])) {
            $objectDatas = [
                "product_id" =>  $Product,
                "quantity" => $quantity
            ];
            array_push($_SESSION['PANIER'], $objectDatas);
        } else {
            $objectToAdd = &$_SESSION['PANIER'][$alreadyIn["row"]];
            $objectToAdd["quantity"] = $objectToAdd["quantity"] + $quantity;
        }
    }

    public function removeFromCart($product_id, $quantity = 1)
    {
        if (!empty($_SESSION['PANIER'])) {
            $offset = 0;
            foreach ($_SESSION['PANIER'] as $Product) {
                if ($Product['product_id'] == $product_id) {

                    if ($quantity >= $Product['quantity']) {
                        array_splice($_SESSION['PANIER'], $offset, 1);
                    } else {
                        $_SESSION['PANIER'][$offset]["quantity"] = $_SESSION['PANIER'][$offset]["quantity"] - $quantity;
                    }
                }
                $offset++;
            }
        }
        $this->cloudSave();
    }

    public function changeValue($product_id, $newQuantity)
    {
        if (!empty($_SESSION['PANIER'])) {
            $offset = 0;
            foreach ($_SESSION['PANIER'] as $Product) {
                if ($Product['product_id'] == $product_id) {
                    if ($Product["quantity"] < $newQuantity) {
                        $this->addToCart($Product['product_id'], ($newQuantity - $Product['quantity']));
                    } elseif ($Product["quantity"] > $newQuantity) {
                        $this->removeFromCart($Product['product_id'], ($Product['quantity'] - $newQuantity));
                    }
                }
            }
        }
    }

    public function selectOrder()
    {
        if (!empty($_SESSION["connection_id"]) && empty($_SESSION["OrderNumber"]) && ($_SESSION["status"]=="user")) {
            $arrayUnachievedOrders = [];
            try{  
                Order::get_data_array($arrayUnachievedOrders, "customer_id", $_SESSION["connection_id"]);
            }catch(Exception $e){
                throw $e;
            }
            if (!empty($arrayUnachievedOrders)) {
                $offset = 0;
                foreach ($arrayUnachievedOrders as $Order) {
                    if (($Order->datas->status > 0) || ($Order->datas->customer_id != $_SESSION["connection_id"]))  {
                        unset($arrayUnachievedOrders[$offset]);
                    }
                    $offset++;
                }
            }
            if (empty($arrayUnachievedOrders)) {
                try{  
                    $this->objDatabase["order"] = Order::get_new_fresh_obj();
                }catch(Exception $e){
                    throw $e;
                }
                $this->objDatabase["order"]->datas->delivery_add_id = "NULL";
                $this->objDatabase["order"]->datas->payment_type = "NULL";
                $this->objDatabase["order"]->datas->date = "'" . date('Y-m-d', time()) . "'";
                $this->objDatabase["order"]->datas->status = 0;
                $this->objDatabase["order"]->datas->session = "'" . session_id() . "'";
                $this->objDatabase["order"]->datas->total = "NULL";
                $this->objDatabase["order"]->datas->customer_id = $_SESSION["connection_id"];
                $this->objDatabase["order"]->datas->registered = 1;
            } else {
                foreach ($arrayUnachievedOrders as $ord) {
                    try{$this->objDatabase["order"] = new Order($ord->id);}catch(Exception $e){throw $e;};
                }
                $this->objDatabase["order"]->datas->delivery_add_id = "NULL";
                $this->objDatabase["order"]->datas->payment_type = "NULL";
            }
        }
    }

    public function cleanDatabase()
    {
        $orderitems = [];
        try{Order_item::get_data_array($orderitems, "order_id", $this->objDatabase["order"]->datas->id);}catch(Exception $e){throw $e;};
        if (!empty($orderitems)) {
            foreach ($orderitems as $order_item) {
                $order_item->apoptose();
            }
        }
    }

    public function setCartInCloud()
    {
        $this->selectOrder();
        $this->objDatabase["order"]->datas->status = 0;
        $this->cleanDatabase();
        $this->objDatabase["order"]->datas->total = $this->controllerData["Total"];
        $this->objDatabase["order"]->set_data();
        if (!empty($_SESSION['PANIER'])) {
            foreach ($_SESSION['PANIER'] as $Product) {
                
                try{$Cart_products = Order_item::get_new_fresh_obj();}catch(Exception $e){throw $e;}
                $Cart_products->datas->order_id = $this->objDatabase["order"]->datas->id;
                $Cart_products->datas->product_id = $Product['product_id'];
                $Cart_products->datas->quantity = $Product['quantity'];
                $Cart_products->set_data();
            }
        }
        
    }

    public function cloudSave()
    {
        if (!empty($_SESSION["connection_id"])) {
            $this->setCartInCloud();
        }
    }

    public function getCartFromCloud()
    {
        if (!empty($_SESSION["connection_id"])) {
            $this->selectOrder();
            $orderitems = [];
            try{Order_item::get_data_array($orderitems, "order_id", $this->objDatabase["order"]->datas->id);}catch(Exception $e){throw $e;};
            if (!$_SESSION["justConnected"])
                unset($_SESSION["PANIER"]);
            if (!empty($orderitems)) {
                foreach ($orderitems as $order_item) {
                    $this->addToCart($order_item->datas->product_id, $order_item->datas->quantity);
                }
            }
            if ($_SESSION["justConnected"])
                $this->cloudSave();
            $_SESSION["justConnected"] = false;
        }
    }
}
