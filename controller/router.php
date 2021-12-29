<?php

require_once "adminController.php";
require_once "detailController.php";
require_once "panierController.php";
require_once "produitController.php";
require_once "renseignementController.php";
require_once "sign-inController.php";
require_once "userController.php";

class router
{

    private $adminController;
    private $detailController;
    private $panierController;
    private $produitController;
    private $renseignementController;
    private $sigInController;
    private $userController;

    public function __construct()
    {
        $this->adminController = new adminController();
        $this->detailController = new detailController();
        $this->panierController = new panierController();
        $this->produitController = new produitController();
        $this->renseignementController = new renseignementController();
        $this->sigInController = new signInController();
        $this->userController = new userController();
    }
    public function guideRequest()
    {
        try {

            if (isset($_GET['action']) && !empty($_GET['action'])) {
                $action = $_GET['action'];
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/view/" . $action . ".php")) {
                    include($action . "Controller.php");
                    $contents = $action . ".php";
                } else {
                    throw new Exception("action invalide");
                }
                require_once("./view/template.php");
            } else {
                $contents = "produit.php";
                $this->produitController->home();
                $controllerData = $this->produitController->controllerData;
                require_once("./view/template.php");
            }
        } catch (Exception $e) {
            throw new Exception("Erreur !: " . $e->getMessage() . "<br/>");
        }
    }
}
