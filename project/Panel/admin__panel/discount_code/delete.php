<?php 
require_once "../../connections.php";
require_once "../../header.php";

if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $delSql = "delete from vouchercode where id = $id";
    $delOp = mysqli_query($conn,$delSql);
    if(!$delOp)
        echo "<script> alert('Can't delete Please try again'); window.location.href='./index.php'; </script>";
    else{
        $_SESSION['emp_deleted'] = "Row Deleted Successfully";
        header("location: ./index.php?");   
    }

}
else 
{
    header("location: ./index.php");
}


?>