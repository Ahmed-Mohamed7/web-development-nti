<?php
require_once "./connections.php";
require_once "./helpers.php";

$id = $_GET['id'];
$sqlImage = "SELECT image FROM todolist WHERE id = '$id'";
$dataImage = mysqli_query($conn,$sqlImage);

$sql = "delete from todolist where id = $id";
$op = mysqli_query($conn, $sql);


$dataImage = mysqli_fetch_assoc($dataImage);

if ($op) {
   // echo $image_date['image'];
    unlink($dataImage['image']);
    $Message =  'task deleted successfully';
} else {
    $Message = 'Error Try Again';
}


$_SESSION['Message'] = $Message;

mysqli_close($conn);
header("location: ./index.php");
?>