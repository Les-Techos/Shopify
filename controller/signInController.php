<?php require_once "controller.php";
require_once "./models/Login.php";
require_once "./models/Admin.php";
require_once "./models/Customer.php";

class signInController extends controller
{

    //$_SESSION["connection_id"] "status"
    public function __construct()
    {
        $this->controllerData  = "";
    }

    public function routerDefaultAction()
    {
        if (!empty($_POST["submit"])) {
            $this->verifyConnection();
        } elseif (!empty($_POST["signupsubmit"])) {
            $this->signup();
        } elseif (!empty($_POST["deconnexion"])) {
            $this->disconnect();
        }
        return $this->controllerData;
    }

    public function verifyConnection()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $password = hash("sha1", $password);
        $users = [];
        $admin = [];
        Login::get_data_array($users, "username", $username);
        Admin::get_data_array($admin, "username", $username);
        if (empty($admin[0])) {
            if (empty($users[0])) {
                $this->controllerData = '<div class="alert alert-danger" role="alert"> Identifiant non reconnu </div>';
            } elseif (($users[0]->datas->username == $username) && ($password == $users[0]->datas->password)) {
                $_SESSION["connection_id"] = $users[0]->datas->id;
                $_SESSION["status"] = "user";
                header('Location: /');
                exit();
            } else {
                $this->controllerData = '<div class="alert alert-danger" role="alert"> Identifiant ou mot de passe incorrect</div>';
            }
        } else {
            if (($admin[0]->datas->username == $username) && ($password == $admin[0]->datas->password)) {
                $_SESSION["connection_id"] = $admin[0]->datas->id;
                $_SESSION["status"] = "admin";
                header('Location: /');
                exit();
            } else {
                $this->controllerData = '<div class="alert alert-danger" role="alert"> Identifiant ou mot de passe incorrect</div>';
            }
        }
    }

    public function disconnect()
    {
        session_unset();
        header('Location: /');
        exit();
    }

    public function signup()
    {
        $username = $_POST["signupusername"];
        $users = [];
        Login::get_data_array($users, "username", $username);
        if (!empty($users)) {
            $this->controllerData = '<div class="alert alert-danger" role="alert"> Identifiant ou mot de passe incorrect</div>';
        } elseif ($_POST["signuppassword"] != $_POST["signupcpassword"]) {
            $this->controllerData = '<div class="alert alert-danger" role="alert"> Les mots de passe ne correspondent pas</div>';
        } else {
            $b = Customer::get_new_fresh_obj(); //Créer un tout nouveau objet avec un nouvel id
            $d = &$b->datas; //On se réfère à ses données dans la DB
            $d->forname = $_POST["signupforname"];
            $d->surname = $_POST["signupname"];
            $d->registered = "1";
            $d->add1 = $_POST["signupAddress"];
            $d->add2 = $_POST["signupCA"];
            $d->add3 = $_POST["signupCity"];
            $d->postcode = $_POST["signupCP"];
            $d->phone = $_POST["signupphone"];
            $d->email = $_POST["signupemail"];

            $l = Login::get_new_fresh_obj(); //On crée un nouveau login
            $d_l = &$l->datas; //" "
            $d_l->customer_id = $b->id;
            $d_l->username = $_POST["signupusername"];
            $d_l->password = hash("sha1", $_POST["signuppassword"]);
            $b->linked_datas->logins[0] = $l; //On dit à l'utilisateur qu'il a un login

            $b->set_data();

            $_SESSION["connection_id"] = $l->datas->id;
            $_SESSION["status"] = "user";
            header('Location: /');
            exit();
        }
    }
}
