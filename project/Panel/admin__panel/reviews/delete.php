<?php 
require_once "../../connections.php";
require_once "../../header.php";

if(isset($_GET['cid']) && isset($_GET['pid']))
{
    $cus_id = $_GET['cid'];
    $prod_id = $_GET['pid'];
    $delSql = "delete from `review` where customer_id = $cus_id and  product_id=$prod_id";
    $delOp = mysqli_query($conn,$delSql);
    if(!$delOp)
        echo "<script> alert('Can't delete Please try again'); window.location.href='./products.php'; </script>";
    else{
        $_SESSION['emp_deleted'] = "Row Deleted Successfully";
        header("location: ./product.php");   
    }

}
else 
{
    header("location: ./orders.php");
}


?>