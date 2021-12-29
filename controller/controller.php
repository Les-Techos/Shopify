<?php

abstract class Controller{
    public $objDatabase; //objet(s) de la base de donnée auquels accède le controlleur
    public $controllerData; //Données envoyées à la vue pour l'affichage

    abstract public function routerDefaultAction();

}
