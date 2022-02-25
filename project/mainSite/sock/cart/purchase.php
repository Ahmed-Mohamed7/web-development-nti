<?php 
require_once "../../DbConnection.php";
require_once "../../Helpers/verifyUser.php";
vertifyCustomer();
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['purchase']))
{
    $payment_id = $_POST['payment'];
    $total_price = 0;
    if(!isset($_SESSION['cart']))
        echo "";
    else{
        $customer_id = $_SESSION['user']['id'];
        $customer_address = $_SESSION['user']['address'];
        $order_date = time();
        $order_shiped = strtotime("+7 day", $order_date);
        $order_date = date("Y-m-d",$order_date);
        $order_shiped = date("Y-m-d",$order_shiped);
        if(isset($_SESSION['voucher_code']))
        {
            $is_voucher = 1;
            $voucher_id = $_SESSION['voucher_code']['id'];
        }
        else{
            $is_voucher = 0;
            $voucher_id = NULL;
        }
        //echo $order_date." ".$order_shiped;
        $create_order_sql = "insert into `order` ( `customer_id`, `totalprice`, `order_date`, `shipped_date`, `is_vouchered`, `order_address`, `is_approved`, `voucher_id`, `payment_id`)
                             values ($customer_id,0,'$order_date','$order_shiped', $is_voucher,'$customer_address',0,$voucher_id,$payment_id)";
        $create_order_op = mysqli_query($conn,$create_order_sql);
        if(!$create_order_op)
        {
            echo "order=> ".mysqli_error($conn);
        }
        else{
            $order_id =  mysqli_insert_id($conn);
            foreach ($_SESSION['cart'] as $prod_id => $prod_data) {
                if(!$prod_id)
                    continue;
                $quanity = $prod_data['quantity'];
                $price = $quanity * $prod_data['price'];
                $total_price += $price;
                $insert_orderitem_sql = "INSERT INTO `orderitem`(`order_id`, `product_id`, `quantity`, `totalprice`) VALUES ($order_id,$prod_id,$quanity, $price)";
                $insert_orderitem_op = mysqli_query($conn,$insert_orderitem_sql);
                if(!$insert_orderitem_op)
                    echo "orderitems=>".mysqli_error($conn);
                else{
                    $amount_left = $prod_data['amount'] - $prod_data['quantity'];
                    # now set order total price
                    $update_order_sql = "UPDATE `order` SET totalprice = $total_price where id = $order_id";
                    $update_order_op = mysqli_query($conn,$update_order_sql);
                    #decrease the amount left of product
                    $update_product_sql = "UPDATE `product` SET amount_left = $amount_left where id = $prod_id";
                    $update_product_op = mysqli_query($conn,$update_product_sql);

                    if(! $update_order_op)
                        echo "order update=>".mysqli_error($conn);
                    else if(!$update_product_op)
                         echo "product update=>".mysqli_error($conn);
                    else {
                        unset($_SESSION['cart']);
                        echo "<script> alert('your purchase done :) '); window.location.href='./cart.php'; </script>";
                    }
                }
            }
        }
    }
}
else{

}


?>