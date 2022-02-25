<?php


if (!isset($_SESSION))
    session_start();

function loginPath($flag=1)
{
    if ($flag == 1)
        $s = "CustomerLoginSystem";
    else $s = "VendorLoginSystem";
    return "http://" . $_SERVER['HTTP_HOST'] . "/nti_course/project/mainSite/".$s."/login.php";
}

if (!isset($_SESSION['user'])) {
    $link = loginPath();
    echo "<script> alert('you should register first'); window.location.href='$link'; </script>";
}
function vertifyCustomer(){
    $link = loginPath();
    if(! (isset($_SESSION['type']) && $_SESSION['type'] == 'customer'))
        echo "<script> alert('you should register as customer first'); window.location.href='$link'; </script>";
}

function vertifyVendor(){
    $link = loginPath(2);
    if(! (isset($_SESSION['type']) && $_SESSION['type'] == 'vendor'))
        echo "<script> alert('you should register as vendor first'); window.location.href='$link'; </script>";
}