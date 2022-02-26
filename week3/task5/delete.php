<?php

require './blog.php';

if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $student = new Blog;
    $result =  $student->remove($id);
    
    if($result){
        $_SESSION['Message'] = "Raw Removed";
    }else{
        $_SESSION['Message'] = "Error Try Again";
    }
    
    header("location: index.php");
}
else {
    $_SESSION['Message'] = "Error Try Again";
    header("location: index.php");
}





?>