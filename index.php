<?php
session_start();
require_once 'controller/router.php';
$Router = new router();
$Router->guideRequest();
?>