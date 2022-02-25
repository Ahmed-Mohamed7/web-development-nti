<?php 
require_once "../../../../DbConnection.php";
require_once "../../../layouts/headers.php";
require_once "../../../../Helpers/verifyUser.php";
require_once "../../../../Helpers/Validators.php";
require_once "../../../../Helpers/helpers.php";

if(isset($_GET['id']) && isset($_GET['vid']))
{
    $id = $_GET['id'];
    $vid = $_GET['vid'];
    $delSql = "delete from `product` where id = $id";
    $delOp = mysqli_query($conn,$delSql);
    if(!$delOp)
        $_SESSION['item_del'] = "Row Deleted Successfully";
    else{
        $_SESSION['item_del'] = "Row Deleted Successfully";
    }
    $link = " ./index.php?id=".$vid;
    header("location: $link");  

}
else 
{
    header("location: ./orders.php");
}


?>