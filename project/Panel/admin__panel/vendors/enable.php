<?php
require_once '../../connections.php';
require_once "../../header.php";


if(!isset($_GET['id']) || !isset($_GET['action']))
    header("location:./index.php");

else {
    if($_GET['action'] == 'enable')
        $action = 1;
    else $action = 0;

    $id = $_GET['id'];
    $sql = "UPDATE vendor SET is_verified = $action WHERE id = $id";
    $op = mysqli_query($conn,$sql);
    if(!$op)
        echo "<script> alert('error occurs please try again'); window.location.href='./index.php'; </script>";
    else{
        echo "<script> alert('update done successfully'); window.location.href='./index.php'; </script>";
    }

}
?>