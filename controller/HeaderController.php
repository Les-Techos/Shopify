<?php require_once "controller.php";

class HeaderController extends controller{
    public $ConnectionButton = "";
    public $HeaderPanier="";
    public $action;
    public $panierController;

    public function __construct(&$action, &$panierController)
    {
        $this->action = $action;
        $this->panierController = $panierController;
    }

    public function routerDefaultAction()
    {    
        $this->displayConnectionBtn();
        $this->displayCart();
    }


    public function displayConnectionBtn(){
        if(!empty($_SESSION["connection_id"])){
            $this->ConnectionButton ='<li>
                    <a href="/?action=user" class="btn btn-primary">
                        Mon compte
                    </a>
                </li>
                <li>
                    <form method="post" action="/?action=signIn">
                        <input type="submit" name="deconnexion" value = "Déconnexion" class="btn btn-primary"/>
                    </form>
                </li>
                ';
                if($_SESSION['status']=="admin"){
                $this->ConnectionButton .='<li>
                    <a href="/?action=admin" class="btn btn-primary">
                        Admin
                    </a>
                </li>';
            }
            }else{
                $this->ConnectionButton ='<li>
                    <a href="/?action=signIn" class="btn btn-primary">
                        Se connecter
                    </a>
                </li>';
            }
            

    }

    public function displayCart()
    {
        if (empty($this->action)) {
            $this->HeaderPanier =  $this->panierController->routerDefaultAction()["list"].'<a href="/?action=panier" class="btn btn-success"> Voir mon panier</a>';
        } elseif ($this->action != 'panier') {
            $this->HeaderPanier =  $this->panierController->routerDefaultAction()["list"].'<a href="/?action=panier" class="btn btn-success"> Voir mon panier</a>';
        } else {
            $this->HeaderPanier =  "";
        }
    }
}
