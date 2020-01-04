<?php
    session_start();
    include_once("../includes/authentication/User.php");
    User::logout();
    header('Location: login.php');
?>