<?php 
require_once "../../DbConnection.php";
require_once "../layouts/headers.php";
require_once "../../Helpers/verifyUser.php";

print_r($_GET);

 if(isset($_GET['id']) && isset($_GET['action']))
{
    $id = intval($_GET['id']);
    $action = $_GET['action'];
    if(!isset($_SESSION['cart'][$id])){
        echo "<script> alert('error while modify item'); window.location.href='./cart.php'; </script>";
    }
    else{
        if($action == 'inc'){
            //TODO: CHECK AMOUNT LEFT
            if($_SESSION['cart'][$id]['quantity'] == 10)
                echo "<script> alert('you can only purchase 10 items of each product'); window.location.href='./cart.php'; </script>";
            else{
            $_SESSION['cart'][$id]['quantity']+=1;
            header("location: ./cart.php");
            }
        }
        else if($action == 'dec'){
            //TODO: CHECK IF REACH 0 DELETE

            $_SESSION['cart'][$id]['quantity']-=1;
            if($_SESSION['cart'][$id]['quantity'] == 0)
                unset($_SESSION['cart'][$id]);
            header("location: ./cart.php");
        }
        else{
            echo "<script> alert('error while modify item1'); window.location.href='./cart.php'; </script>";
        }
        
    }

} 
else{

}
