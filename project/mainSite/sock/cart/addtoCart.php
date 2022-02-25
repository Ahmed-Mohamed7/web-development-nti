<?php
    require_once "../../DbConnection.php";
    require_once "../../Helpers/verifyUser.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cart']))
    {
        $prod_id = $_POST['prod_id'];
        $prod_price = $_POST['prod_price'];
        $prod_amount = $_POST['amount_left'];


        #validate id 
        if(!is_numeric($prod_id))
            echo "<script> alert('invalid product'); window.location.href='../products.php'; </script>";
        else if(isset($_SESSION['cart'][$prod_id]))
            echo "<script> alert('this product is already added to your cart'); window.location.href='../products.php'; </script>";
        else {
            $_SESSION['cart'][$prod_id] = ['quantity'=>1,'price'=>$prod_price,'amount'=>$prod_amount];
            echo "<script> alert('Product added to your cart succesfully'); window.location.href='../products.php'; </script>";

        }

    }

?>