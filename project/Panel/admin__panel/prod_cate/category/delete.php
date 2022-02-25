<?php 
require_once "../../../connections.php";
require_once "../../../header.php";

if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $delSql = "delete from `category` where id = $id";
    $delOp = mysqli_query($conn,$delSql);
    if(!$delOp)
        echo "<script> alert('Can't delete Please try again'); window.location.href='./category.php'; </script>";
    else{
        $_SESSION['emp_deleted'] = "Row Deleted Successfully";
        header("location: ./category.php?");   
    }

}
else 
{
    header("location: ./category.php");
}


?>