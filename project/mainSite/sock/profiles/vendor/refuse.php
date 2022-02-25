<?php 
require_once "../../../DbConnection.php";
require_once "../../layouts/headers.php";
require_once "../../../Helpers/verifyUser.php";
require_once "../../../Helpers/Validators.php";
require_once "../../../Helpers/helpers.php";

vertifyVendor();
$id = $_SESSION['user']['id'];
$link = "./index?id=".$id;
if(isset($_GET['or_id']) && isset($_GET['prod_id']) )
{
    $order_id = $_GET['or_id'];
    $prod_id = $_GET['prod_id'];

    # get order item
    $item_sql = "select * from orderitem where product_id = $prod_id and order_id = $order_id";
    $item_op = mysqli_query($conn,$item_sql);
    if(!$item_op)
    {
        echo mysqli_error($conn);
        header("location: $link");
    }
    $quantity = mysqli_fetch_array($item_op)['quantity'];

    ## get product 
    $prod_sql = "select * from product where id = $prod_id";
    $prod_op = mysqli_query($conn,$prod_sql);
    if(!$prod_op)
    {
        echo mysqli_error($conn);
        header("location: $link");
    }
    $prod_data = mysqli_fetch_array($prod_op);

    ## set new amount
    $new_amount = $prod_data['amount_left']+$quantity ;
    $new_amount_sql = "UPDATE `product` SET `amount_left`=$new_amount WHERE id = $prod_id";
    $new_amount_op = mysqli_query($conn,$new_amount_sql);
    if(!$new_amount_op)
    {
        header("location: $link");
        echo mysqli_error($conn);
    }

    ## del orderitem
    $item_del_sql = "DELETE FROM `orderitem` WHERE product_id = $prod_id and order_id = $order_id";
    $item_del_op = mysqli_query($conn,$item_del_sql);
    if(!$item_del_op)
        echo mysqli_error($conn);
}
header("location: $link");

