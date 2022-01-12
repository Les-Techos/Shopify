<?php require_once "controller.php";

/**
 * Controller for the header display
 */
class HeaderController extends controller
{
    public $ConnectionButton = "";
    public $HeaderPanier = "";
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
        $this->displayCartButton();
        $this->displayCart();
    }


    /**
     * changes the buttons in the view. Depends on the user connection. 
     */
    public function displayConnectionBtn()
    {
        if (!empty($_SESSION["connection_id"])) {
            $this->ConnectionButton = '
                <li>
                    <form method="post" action="./?action=signIn">
                        <input type="submit" name="deconnexion" value = "Déconnexion"  id="Mobile_Btn" class="btn btn-primary"/>
                    </form>
                </li>
                ';
            if ($_SESSION['status'] == "admin") {
                $this->ConnectionButton .= '<li>
                    <a href="./?action=admin" class="btn btn-primary" id="Mobile_Btn">
                        Admin
                    </a>
                </li>';
            } else {
                $this->ConnectionButton .= '<li>
                <a href="./?action=user" class="btn btn-primary" id="Mobile_Btn">
                    Mon compte
                </a>
            </li>';
            }
        } else {
            $this->ConnectionButton = '<li>
                    <a href="./?action=signIn" class="btn btn-primary" id="Mobile_Btn">
                        Se connecter
                    </a>
                </li>';
        }
    }

    /**
     * Display a button to show the cart on every webpage except, the cart, the admin page, the command validation, and the  end of command
     */
    public function displayCartButton()
    {

        if ((empty($_SESSION["status"]) || ("admin" != $_SESSION["status"])) && (empty($this->action) || (($this->action != 'panier') && ($this->action != 'renseignement') && ($this->action != 'fin')))) {
            $this->ConnectionButton .= '<li>
                <strongbutton class="btn btn-primary" id="Mobile_Btn" type="button" data-bs-toggle="collapse" data-bs-target="#Panier" aria-expanded="false" aria-controls="collapseExample">
                    Panier
                    </button>
            </li>';
        }
    }

    /**
     * Display the cart on every webpage except, the cart, the admin page, the command validation, and the  end of command
     */
    public function displayCart()
    {
        if (empty($_SESSION["status"]) || ("admin" != $_SESSION["status"])) {
            if (empty($this->action)) {
                $this->HeaderPanier =  $this->panierController->routerDefaultAction()["list"] . '<a href="./?action=panier" class="btn btn-success" "> Voir mon panier</a>';
            } elseif (($this->action != 'panier') && ($this->action != 'renseignement') && ($this->action != 'fin')) {
                $this->HeaderPanier =  $this->panierController->routerDefaultAction()["list"] . '<a href="./?action=panier" class="btn btn-success" "> Voir mon panier</a>';
            } else {
                $this->HeaderPanier =  "";
            }
        } else {
            $this->HeaderPanier = "Vous êtes administrateur, vous n'avez pas accès aux commandes";
        }
    }
}
