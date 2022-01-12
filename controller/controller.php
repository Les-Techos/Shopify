<?php

/**
 * This class is a model for every controller in the application
 */
abstract class Controller
{
    public $objDatabase; //object(s) from the DB the controller can use
    public $controllerData; //Datas sent to the view

    /**
     * This function is called mainly in the router in order for him to execute the good flow of action when a page is called
     * @return $controllerData
     */
    abstract public function routerDefaultAction();

    /**
     * This function redirects admin on the page. You have to call it in routerDefaultAction() for it to make an effect
     */
    public function throwAdmin()
    {
        if (!empty($_SESSION["status"]) && ("admin" == $_SESSION["status"])) {
            header('Location: ./?action=admin');
            exit();
            
        }
    }
}
