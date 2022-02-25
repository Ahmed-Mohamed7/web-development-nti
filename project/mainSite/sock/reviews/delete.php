<?php 
require_once "../../DbConnection.php";
require_once "../../Helpers/verifyUser.php";
require_once "../../Helpers/Validators.php";

vertifyCustomer();

if(isset($_GET['cus_id']) && isset($_GET['prod_id']))
{
    $cus_id = $_GET['cus_id'];
    $prod_id = $_GET['prod_id'];
    $delSql = "delete from `review` where customer_id = $cus_id and product_id = $prod_id";
    $delOp = mysqli_query($conn,$delSql);
    if(!$delOp)
        echo "<script> alert('Can't delete Please try again'); window.location.href='../product.php?product_id=$prod_id'; </script>";
    else{
        echo "<script> alert('your review deleted successfully'); window.location.href='../product.php?product_id=$prod_id'; </script>";
    }

}
else 
{
    header("location: ./orders.php");
}


?>