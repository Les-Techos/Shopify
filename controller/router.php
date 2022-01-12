<?php

require_once "adminController.php";
require_once "detailController.php";
require_once "panierController.php";
require_once "produitController.php";
require_once "renseignementController.php";
require_once "signInController.php";
require_once "userController.php";
require_once "HeaderController.php";
require_once "errorController.php";
require_once "finController.php";

/**
 * This class is the router. It calls the appropriate methods and controllers whenever a page is called.
 */
class router
{

    private $adminController;
    private $detailController;
    private $panierController;
    private $produitController;
    private $renseignementController;
    private $signInController;
    private $userController;
    private $errorController;

    public function __construct()
    {
        $this->adminController = new adminController();
        $this->detailController = new detailController();
        $this->panierController = new panierController();
        $this->produitController = new produitController();
        $this->renseignementController = new renseignementController();
        $this->signInController = new signInController();
        $this->userController = new userController();
        $this->HeaderController = new HeaderController($_GET['action'], $this->panierController);
        $this->errorController = new errorController();
        $this->finController = new finController();
    }
    /**
     * This method is called whenever a page is loaded and routes the request to the appropriate controller and view.
     * @return void
     */
    public function guideRequest()
    {
        try {
            
            if (!empty($_GET['action'])) {
                $action = $_GET['action'];
                if (file_exists('.' . "/view/" . $action . ".php")) {
                    $contents = $action . ".php";
                    $controllerData = $this->{$action . 'Controller'}->routerDefaultAction();
                } else {
                    throw new Exception("action invalide");
                }$this->HeaderController->routerDefaultAction();
                $HeaderPanier = $this->HeaderController->HeaderPanier;
                $ConnectionButton = $this->HeaderController->ConnectionButton;
                require_once("./view/template.php");
            } else {
                $contents = "produit.php";
                $controllerData = $this->produitController->routerDefaultAction();
                $this->HeaderController->routerDefaultAction();
                $HeaderPanier = $this->HeaderController->HeaderPanier;
                $ConnectionButton = $this->HeaderController->ConnectionButton;
                require_once("./view/template.php");
            }
            
        } catch (Exception $e) {
            echo "<br/>". $this->MakePrettyException($e);
        }
    }

    /**
     * @param Exception $e
     * this function is used for debug purposes only and allow to show the exceptions in a prettier way.
     * @return [type]
     */
    public function MakePrettyException(Exception $e) {
        $trace = $e->getTrace();
    
        $result = 'Exception: "';
        $result .= $e->getMessage();
        $result .= '" @ ';
        if($trace[0]['class'] != '') {
          $result .= $trace[0]['class'];
          $result .= '->';
        }
        $result .= $trace[0]['function'];
        $result .= '();<br />';
    
        return $result;
      }

    
}
