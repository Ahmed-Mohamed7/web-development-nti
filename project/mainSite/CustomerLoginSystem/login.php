<?php
session_start();
require_once "../DbConnection.php";
require_once "../Helpers/Validators.php";
require_once "../Helpers/helpers.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = Clean($_POST['email']);
    $password = $_POST['password'];

    $errors = [];



    #validate email
    if (Validate($email, 'empty'))
        $errors['email'] = REQ_ERR;
    else if (Validate($email, 'email'))
        $errors['email'] = errorFormat('Invalid EMail');

    #validate password
    if (Validate($password, 'empty'))
        $errors['password'] = REQ_ERR;
    else if (Validate($password, 'lengthS', 8))
        $errors['password'] = errorFormat('password must be >= 8 characters');

    
    if (count($errors) == 0) {
        $err = false;
        ## hash password
        $hashedPassword = md5($password);



        ## check email
        $login_sql = "select * from customer where email = '$email' and password = '$hashedPassword'";
        $login_op = mysqli_query($conn, $login_sql);
        if (!$login_op) {
            $errors['server'] = errorFormat('error while inserting');
            $err = true;
        } 
        else if(mysqli_num_rows($login_op) == 0){
            $errors['server'] = errorFormat('either email or password not correct');
            $err = true;
        }
        else{
            $customer_data = mysqli_fetch_assoc($login_op);
            unset($customer_data['password']);
            $_SESSION['type'] ='customer';
            $_SESSION['user'] = $customer_data;
            echo "<script> alert('register successfully'); window.location.href='../sock/'; </script>";
        }
        
        if ($err) {
            $_SESSION['message'] = $errors;
        }
    } else {
        $_SESSION['message'] = $errors;
    }
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="sytlesheet" href="./style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <section class="vh-100" style="background-color: #393f81;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block justify-content-center align-self-center">
                                <img src="../../assets/online.jpg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form  action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                        
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                            <span class="h1 fw-bold mb-0">Logo</span>
                                        </div>
                                        
                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>
                                        <?php if (isset($_SESSION['message']['server'])) echo ($_SESSION['message']['server']) ?>

                                        <?php if (isset($_SESSION['message']['email'])) echo ($_SESSION['message']['email']) ?>
                                        <div class="form-outline mb-4">
                                            <input type="email" name="email" id="form2Example17" class="form-control form-control-lg" />
                                            <label class="form-label" for="form2Example17">Email address</label>
                                        </div>

                                        <?php if (isset($_SESSION['message']['password'])) echo ($_SESSION['message']['password']) ?>
                                        <div class="form-outline mb-4">
                                            <input type="password" name="password" id="form2Example27" class="form-control form-control-lg" />
                                            <label class="form-label" for="form2Example27">Password</label>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                        </div>

                                        <a class="small text-muted" href="#!">Forgot password?</a>
                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="./register.php" style="color: #393f81;">Register here</a></p>
                                        <a href="../VendorLoginSystem/login.php">login as vendor</a>
                                        <a href="#!" class="small text-muted">Terms of use.</a>
                                        <a href="#!" class="small text-muted">Privacy policy</a>
                                        <?php if (isset($_SESSION['message'])) unset($_SESSION['message']); ?>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>