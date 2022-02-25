<?php
require_once "./Helpers/verifyUser.php";
require_once "./Helpers/helpers.php";
require_once "./DbConnection.php";

if (isset($_SESSION['user']))
    unset($_SESSION['user']);

if (isset($_SESSION['type']))
    unset($_SESSION['type']);

if(isset($_SESSION['cart']))
    unset($_SESSION['cart']);

header("location: ./CustomerLoginSystem/login.php");
