<?php

require_once 'connections.php';

$id = $_GET['id'];

$image_sql = "select image from posts where id = $id";
$image = mysqli_query($conn, $image_sql);

$sql = "delete from posts where id = $id";
$op = mysqli_query($conn, $sql);


$image_date = mysqli_fetch_assoc($image);

if ($op) {
   // echo $image_date['image'];
    unlink($image_date['image']);
    $Message =  'posts deleted successfully';
} else {
    $Message = 'Error Try Again';
}


$_SESSION['Message'] = $Message;

mysqli_close($conn);
header("location: ./index.php");
