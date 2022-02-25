<?php 
require_once "../../DbConnection.php";
require_once "../layouts/headers.php";
require_once "../../Helpers/verifyUser.php";

//print_r($_GET);

if(isset($_GET['id']))
{
    $id = $_GET['id'];
    if(isset($_SESSION['cart'][$id])){
        unset($_SESSION['cart'][$id]);
        echo "<script> alert('item deleted successfully'); window.location.href='./cart.php'; </script>";
    }
    else{
        echo "<script> alert('error while deleting item'); window.location.href='./cart.php'; </script>";
    }

}
?>