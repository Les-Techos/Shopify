<?php
    Class user{
        private $nom_user;
        private $mdp_user;

        protected function __construct($n,$m)
        {
            $this->nom_user = $n;
            $this->mdp_user = $m;
        }

    }

?>