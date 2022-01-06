<?php require_once "controller.php";

class renseignementController extends controller
{

    public function __construct()
    {
        $this->controllerData["nbArticles"] = 0;
        $this->controllerData["prenom"] = "";
        $this->controllerData["nom"] = "";
        $this->controllerData["mail"] = "";
        $this->controllerData["add1"] = "";
        $this->controllerData["add2"] = "";
        $this->controllerData["add3"] = "";
        $this->controllerData["codepostal"] = "";
        $this->controllerData["Total"] = 0;
    }

    public function routerDefaultAction()
    {
        $this->throwAdmin();
        if (!empty($_SESSION["PANIER"])) {
            $this->getCustomerInfo();
            $this->getCartInfos();
            return $this->controllerData;
        } else {
            header('Location: /');
            exit();
        }
    }

    public function getCustomerInfo()
    {
        if (!empty($_SESSION["connection_id"])) {
            $customer = new Customer($_SESSION["connection_id"]);
            $this->controllerData["nom"]  = $customer->datas->surname;
            $this->controllerData["prenom"] = $customer->datas->forname;
            $this->controllerData["add1"] = $customer->datas->add1;
            $this->controllerData["add2"] = $customer->datas->add2;
            $this->controllerData["add3"] = $customer->datas->add3;
            $this->controllerData["codepostal"] = $customer->datas->postcode;
            $this->controllerData["mail"]  = $customer->datas->email;
        }
    }

    public function getCartInfos()
    {
        foreach ($_SESSION['PANIER'] as $ProductData) {
            $Product  = new Product($ProductData["product_id"]);
            $this->controllerData["nbArticles"] += $ProductData["quantity"];
            $this->controllerData["Total"] +=  $ProductData["quantity"] * $Product->datas->price;
        }
    }
}
