<?php require_once "controller.php";
require_once "./models/Customer.php";
require_once "./models/Login.php";

class userController extends controller
{

    public function __construct()
    {

        $this->controllerData  = [];
        $this->controllerData["commandes"] = "";
        $this->controllerData["message"] = "";
    }

    public function routerDefaultAction()
    {
        try{
                if (!empty($_SESSION["connection_id"]))
                Order::get_data_array($this->objDatabase, "customer_id", $_SESSION["connection_id"]);
            $this->throwAdmin();
            $user = new Customer($_SESSION["connection_id"]);
            $login = [];
            Login::get_data_array($login, "customer_id", $_SESSION["connection_id"]);
            if (!empty($_POST["modify"])) {
                $this->updateInfos($user, $login[0]);
            }
            $this->getCustomerInfo($user, $login[0]);
            $this->diplayAllOrders();
        }catch(Exception $e){ throw $e;}

        return $this->controllerData;
    }

    public function getCustomerInfo(&$customer, &$login)
    {
        $this->controllerData["nom"] = $customer->datas->surname;
        $this->controllerData["prenom"] = $customer->datas->forname;
        $this->controllerData["username"] = $login->datas->username;
        $this->controllerData["addr1"] = $customer->datas->add1;
        $this->controllerData["addr2"] = $customer->datas->add2;
        $this->controllerData["addr3"] = $customer->datas->add3;
        $this->controllerData["postalcode"] = $customer->datas->postcode;
        $this->controllerData["mail"]  = $customer->datas->email;
        $this->controllerData["phone"]  = $customer->datas->phone;
    }


    public function diplayAllOrders()
    {
        foreach ($this->objDatabase as $order) {
            if ($order->datas->status > 0 && $order->datas->status < 11) {
                $this->displayOrder($order);
            }
        }
    }

    public function displayOrderProducts($idOrder)
    {
        $itemArray = [];
        Order_item::get_data_array($itemArray, "order_id", $idOrder);
        $result = "";
        foreach ($itemArray as $order_product) {
            $Product = new Product($order_product->datas->product_id);
            $result .= '<li class="list-group-item" >
            <img style="height:50px" src="./assets/image/' . $Product->datas->image . '">
                ' . $Product->datas->name . '
                <input type="number" name="quantity" style="min-width:25px; max-width:50px" min="0" value = "' . $order_product->datas->quantity . '" disabled/>
            </li>
        ';
        }
        return $result;
    }

    public function displayOrder($Order)
    {

        $this->controllerData["commandes"] .= '<li class = "list-group-item">
        Achat  le ' . $Order->datas->date . '
        <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#Details' . $Order->id . '" aria-expanded="false" aria-controls="collapseExample" >Détails achat &#9997; </button>';
        if (file_exists('./assets/bills/'.$Order->datas->session.$Order->id.'.pdf'))
            $this->controllerData["commandes"] .= '<a href="./assets/bills/' . $Order->datas->session . $Order->id . '.pdf" class="btn btn-warning">Télécharger la facture</a>';
        $this->controllerData["commandes"] .= '<div class="collapse" id="Details' . $Order->id . '">
            <ul class="list-group">
                ' . $this->displayOrderProducts($Order->id) . '
            </ul>
            
        </div>
        </li>';
    }

    public function updateInfos(&$b, &$l)
    {
        $username = $_POST["username"];
        $users = [];
        $admins = [];
        Login::get_data_array($users, "username", $username);
        Admin::get_data_array($admins, "username", $username);


        $d = &$b->datas; //On se réfère à ses données dans la DB
        $d->forname = $_POST["prenom"];
        $d->surname = $_POST["nom"];
        $d->registered = "1";
        $d->add1 = $_POST["adresse1"];
        $d->add2 = $_POST["adresse2"];
        $d->add3 = $_POST["adresse3"];
        $d->postcode = $_POST["postalcode"];
        $d->phone = $_POST["phone"];
        $d->email = $_POST["mail"];
        $d_l = &$l->datas;

        if (!empty($_POST["password"])) {
            if ($_POST["password"] != $_POST["cpassword"]) {
                $this->controllerData["message"] = '<div class="alert alert-danger" role="alert"> Les mots de passe ne correspondent pas</div>';
            } else {
                $d_l->password = hash("sha1", $_POST["password"]);
            }
        }
        $b->linked_datas->logins[0] = $l; //On dit à l'utilisateur qu'il a un login
        if ((empty($users) && empty($admins)) || ($username == $l->datas->username)) {
            $d_l->username = $_POST["username"];
            $b->set_data();
        } else {
            $this->controllerData["message"] = '<div class="alert alert-danger" role="alert"> Le login existe déjà</div>';
        }
    }
}
