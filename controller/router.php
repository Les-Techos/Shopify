<?php

require_once "adminController.php";
require_once "detailController.php";
require_once "panierController.php";
require_once "produitController.php";
require_once "renseignementController.php";
require_once "signInController.php";
require_once "userController.php";
require_once "HeaderController.php";

class router
{

    private $adminController;
    private $detailController;
    private $panierController;
    private $produitController;
    private $renseignementController;
    private $signInController;
    private $userController;

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
    }
    public function guideRequest()
    {
        try {
            
            if (!empty($_GET['action'])) {
                $action = $_GET['action'];
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/view/" . $action . ".php")) {
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
            throw new Exception("Erreur !: " . $e->getMessage() . "<br/>");
        }
    }

    
}
