<?php require_once "controller.php";
require_once "./models/order.php";

class panierController extends controller
{


    public function __construct()
    {
        $this->controllerData  = "";
    }

    public function routerDefaultAction()
    {
        if (!empty($_POST['changevalue'])) {
            $this->changevalue($_POST['idProduct'], $_POST['quantity']);
        }elseif(!empty($_POST['delete'])){
            
            $this->changevalue($_POST['idProduct'], 0);
        }
        elseif (!empty($_POST['idProduct'])) {
            if(empty($_POST['quantity']))
                $this->addToCart($_POST['idProduct']);
            else
                $this->addToCart($_POST['idProduct'], $_POST['quantity']);
        }
       return $this->displayAllCart();
       
    }

    public function displayAllCart(){
        $this->controllerData  = "";
        if (empty($_SESSION['PANIER'])) {
            $this->controllerData = "<h2> Votre panier est tristement vide :( </h2>";
        } else {

            foreach ($_SESSION['PANIER'] as $ProductData) {
                $this->returnCards(new Product($ProductData["product_id"]), $ProductData["quantity"]);
            }
        }
        return $this->controllerData;
    }

    public function returnCards($Product, $quantity)
    {
        $this->controllerData .= '
        <li class="list-group-item" >
           <form method="post" class="form-example">                
                <img style="height:50px" src="..\assets\image\\' . $Product->datas->image . '">
                ' . $Product->datas->name . '
                <input type="number" name="quantity" style="min-width:25px; max-width:50px" min="0" value = "' . $quantity . '"/>
                <input type="hidden" id ="idProduct" name="idProduct" value="' . $Product->datas->id . '"/>
                <input type="submit" name="changevalue" class="btn btn-success check" value="&#10004"/>
                <input type="reset" class="btn btn-primary" value="&#8617"/>
                <input type="submit" name="delete" class="btn btn-danger" value="&#10060;"/>
            </form>
        </li>
        ';
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
                    } else {echo($quantity."  ".$offset);
                        $_SESSION['PANIER'][$offset]["quantity"] = $_SESSION['PANIER'][$offset]["quantity"]-$quantity;
                    }
                }
                $offset++;
            }
        }
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
}
