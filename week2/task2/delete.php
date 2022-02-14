<?php

require_once 'connections.php';

$id = $_GET['id'];

$sql = "delete from posts where id = $id";

$op = mysqli_query($conn, $sql);

$image_sql = "select image from posts where id = $id";
$image = mysqli_query($conn, $image_sql);
$image = mysqli_fetch_assoc($image);
if ($op) {
    unlink($image);
    $Message =  'posts deleted successfully';
} else {
    $Message = 'Error Try Again';
}


$_SESSION['Message'] = $Message;

mysqli_close($conn);
header("location: ./index.php");
