<?php

require './connections.php';
require './helpers.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $password = Clean($_POST['password'], 1);
    $email    = Clean($_POST['email']);


    # Validate ...... 

    $errors = [];

    # validate email 
    if (empty($email)) {
        $errors['email'] = "Field Required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['Email']   = "Invalid Email";
    }


    # validate password 
    if (empty($password)) {
        $errors['password'] = "Field Required";
    } elseif (strlen($password) < 6) {
        $errors['Password'] = "Length Must be >= 6 chars";
    }






    # Check ...... 
    if (count($errors) > 0) {

        foreach ($errors as $key => $value) {
            echo '* ' . $key . ' : ' . $value . '<br>';
        }
    } else {

  

          $email_sql = "select  * from users where email = '$email'";
          $email_check  = mysqli_query($conn,$email_sql); 

       
          if( mysqli_num_rows($email_check) == 0){
            
            $password = md5($password);
            $sql = "insert into users (email,`password`) values ('$email','$password')"; 
            $result  = mysqli_query($conn,$sql); 
            if(!$result)
                echo 'error while creating user please try again';
            else {
                echo "<script> alert('user created successfully'); window.location.href='./login.php'; </script>";
            }
          


          }else{
              echo 'this email is already exist ';
          }



    }
}




?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2 class="text-primary">Register</h2>

        <form action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" >

            <div class="form-group">
                <label for="exampleInputEmail">Email </label>
                <input type="email" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Password</label>
                <input type="password" class="form-control" required id="exampleInputPassword1" name="password" placeholder="Password">
            </div>




            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>


</body>

</html>