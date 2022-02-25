<?php
require_once "./connections.php";
require_once "./helpers/helpers.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = Clean($_POST['email']);
    $pass = $_POST['password'];
    $error = [];
    #validate email
    if (empty($email))
        $error['email'] = errorFormat('email can\'t be empty');
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $error['email'] = errorFormat('INVALID EMAIL');


    #validate password
    if (empty($pass))
        $error['password'] = errorFormat('password can\'t be empty');

    if (count($error) == 0) {
        $hashedPass = md5($pass);
        $sql = "select * from admins where email='$email' and password = '$hashedPass' ";
        $data = mysqli_query($conn, $sql);

        if (mysqli_num_rows($data) > 0) {
            $data = mysqli_fetch_assoc($data);
            $_SESSION['admin'] = $data;
            // print_r($_SESSION['admin']);
            // exit;
            header("location:./admin_panel.php");
        } else {
            $error['email'] = 'email or password is not correct';
            $_SESSION['error'] = $error;
            header("location:./login.php");
        }
    } else {
        $_SESSION['error'] = $error;
        header("location:./login.php");
    }
}
