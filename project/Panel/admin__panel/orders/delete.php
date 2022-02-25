<?php 
require_once "../../connections.php";
require_once "../../header.php";

if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $delSql = "delete from `order` where id = $id";
    $delOp = mysqli_query($conn,$delSql);
    if(!$delOp)
        echo "<script> alert('Can't delete Please try again'); window.location.href='./orders.php'; </script>";
    else{
        $_SESSION['emp_deleted'] = "Row Deleted Successfully";
        header("location: ./orders.php?");   
    }

}
else 
{
    header("location: ./orders.php");
}


?>