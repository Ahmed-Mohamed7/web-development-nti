<?php
require_once "../../../DbConnection.php";
require_once "../../layouts/headers.php";
require_once "../../../Helpers/verifyUser.php";
require_once "../../../Helpers/Validators.php";
require_once "../../../Helpers/helpers.php";
vertifyCustomer();
if(isset($_GET['id']))
{
    ## get customer data
    $cus_id = Clean($_GET['id']);
    
    $error = [];
    $current_link = "./index.php?id=".$cus_id;
    #validate 
    if(Validate($cus_id,'empty'))
        $error['id'] =REQ_ERR;
    else if(Validate($cus_id,'number'))
        $error['id'] ='id must be number';

    if(count($error) == 0)
    {
        #check if the is exist
        if($cus_id != $_SESSION['user']['id'])
            echo "<script> alert('you only can view your profile'); window.location.href='../../index.php'; </script>";
        $cus_sql = "SELECT * FROM customer where id =  $cus_id";
        $cus_op = mysqli_query($conn,$cus_sql);
        if(!$cus_op)
            echo "customer=> ".mysqli_error($conn);
        $cus_data = mysqli_fetch_assoc($cus_op);
    }
    else{
        $_SESSION['message'] = $errors;
    }
    #get orders data
    $order_sql = "select `order`.*,vouchercode.code as v_code,payment.type as p_type from `order` 
                left join vouchercode on  `order`.voucher_id = vouchercode.id 
                join payment on `order`.payment_id = payment.id
                where `order`.customer_id = $cus_id order by `order`.order_date DESC limit 10";
    $order_op = mysqli_query($conn,$order_sql);
    if(! $order_op)
        echo "order".mysqli_error($conn);
    
}
else{
    echo "<script> alert('404 not found customer'); window.location.href='../../index.php'; </script>"; 
}

if($_SERVER['REQUEST_METHOD'] ='POST' && isset($_POST['edit']))
{
    $name = Clean($_POST['name'], 0);
    $email = Clean($_POST['email']);
    $phone = Clean($_POST['phone']);
    $address = Clean($_POST['address'], 0);
    $birthdate = Clean($_POST['birthdate']);
    $gender = Clean($_POST['gender']);

    $errors = [];

    #validate name   
    if (Validate($name, 'empty'))
        $errors['name'] = REQ_ERR;
    else if (Validate($name, 'string'))
        $errors['name'] = errorFormat('Name must be string');
    else if (Validate($name, 'lengthG', 50))
        $errors['name'] = errorFormat('Name must be <= 50 characters');

    #validate email
    if (Validate($email, 'empty'))
        $errors['email'] = REQ_ERR;
    else if (Validate($email, 'email'))
        $errors['email'] = errorFormat('Invalid EMail');



    #validate phone
    if (Validate($phone, 'empty'))
        $errors['phone'] = REQ_ERR;
    else if (Validate($phone, 'phone'))
        $errors['phone'] = errorFormat('invalid phone');


    #validate address
    if (Validate($address, 'empty'))
        $errors['address'] = REQ_ERR;
    else if (Validate($address, 'lengthG', 255))
        $errors['address'] = errorFormat('address must be <= 255 characters');
    else if (Validate($address, 'string'))
        $errors['address'] = errorFormat('address must be string');

    # validate gender
    if (Validate($gender, 'empty'))
        $errors['gender'] = REQ_ERR;
    else if (Validate($gender, 'gender'))
        $errors['gender'] = errorFormat('invalid value for gender');

    #validate date
    if (Validate($birthdate, 'empty'))
        $errors['birthdate'] = REQ_ERR;
    else if (Validate($birthdate, 'date'))
        $errors['birthdate'] = errorFormat('invalid date');

    if (count($errors) == 0) 
    {

        ##check email
        ##didn't change email
        if($email == $_SESSION['user']['email'])
            $email_q = '';
        else{
            $email_sql = "select * from customer where email = '$email'";
            $email_op = mysqli_query($conn,$email_sql);
            if(mysqli_num_rows($email_op)==0)
            {
                $_SESSION['user']['email'] = $email;
                $email_q = "`email`='$email',";
            }
            else{
                echo "<script> alert('email is already exists'); window.location.href='$current_link'; </script>"; 
            }
        }

        ####
        $update_customer_sql = "UPDATE `customer` SET `name`='$name',".$email_q."
           `birthdate`='$birthdate',`address`='$address',`gender`='$gender',`phone_number`='$phone' where id = $cus_id";
        $update_customer_op = mysqli_query($conn,$update_customer_sql); 
        if(!$update_customer_op)
            echo "customer => ".mysqli_error($conn);
        else{
            echo "<script> alert('data updated successfully'); window.location.href='$current_link'; </script>"; 
        }
    }
    else{
        $_SESSION['message'] = $errors;
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #eee;
        }

        table {
            background-color: #ffffff;
        }

        .flip {
            transform: rotate(90deg);
        }

        th {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <!-- <img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt=""> -->
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <!-- Profile picture upload button-->
                    <button class="btn btn-primary" type="button">Upload new image</button>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']).'?id='.$cus_id?>"  method="POST">
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <?php if(isset($_SESSION['message']['name'])) echo errorFormat($_SESSION['message']['name']); ?>
                            <label class="small mb-1" for="inputUsername">Full Name</label>
                            <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" name="name" value="<?php echo $cus_data['name'] ?>">
                        </div>
                       
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-5 col-md-5">
                            <?php if(isset($_SESSION['message']['gender'])) echo errorFormat($_SESSION['message']['gender']); ?>
                                <label class="small mb-1" for="inputOrgName">Gender</label>
                                <select name ="gender">
                                    <option value="male" <?php if($cus_data['name']=='male'){?> selected <?php } ?> >male</option>
                                    <option  value="male" <?php if($cus_data['name']=='female'){?> selected <?php } ?>>female</option>
                                </select>
                            </div>
                            <!-- Form Group (location)-->
                         
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                        <?php if(isset($_SESSION['message']['email'])) echo errorFormat($_SESSION['message']['email']); ?>

                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                            <input class="form-control" id="inputEmailAddress" type="email" name="email" placeholder="Enter your email address" value=<?php echo $cus_data['email']  ?>>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (phone number)-->
                            <div class="col-md-6">
                            <?php if(isset($_SESSION['message']['phone'])) echo errorFormat($_SESSION['message']['phone']); ?>

                                <label class="small mb-1" for="inputPhone">Phone number</label>
                                <input class="form-control" id="inputPhone" type="tel" name="phone" placeholder="Enter your phone number" value=<?php echo $cus_data['phone_number']  ?>>
                            </div>
                            <!-- Form Group (birthday)-->
                            <div class="col-md-6">
                            <?php if(isset($_SESSION['message']['birthdate'])) echo errorFormat($_SESSION['message']['birthdate']); ?>

                                <label class="small mb-1" for="inputBirthday">Birthday</label>
                                <input class="form-control" id="inputBirthday" type="date" name="birthdate" name="birthday" placeholder="Enter your birthday" value=<?php echo $cus_data['birthdate']  ?>>
                            </div>
                        </div>

                        <div class="mb-3">
                        <?php if(isset($_SESSION['message']['address'])) echo errorFormat($_SESSION['message']['address']); ?>

                            <label class="small mb-1" for="inputEmailAddress">Address</label>
                            <input class="form-control" id="inputEmailAddress" type="text" name="address" placeholder="Enter your email address" value=<?php echo $cus_data['address']  ?>>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" name="edit" type="submit">Save changes</button>
                        <?php if(isset($_SESSION['message'])) unset($_SESSION['message']); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div>
    <div class="table-responsive tabl">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 5%"># <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">Price <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">OrderDate <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">ShippedDate<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">Address<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">Is Vouchered<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">Voucher Code <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">Payment <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">state <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">Control</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Price</th>
                            <th>OrderDate</th>
                            <th> ShippedDate</th>
                            <th>Address</th>
                            <th>Is Vouchered</th>
                            <th>Voucher Code</th>
                            <th>Payment</th>
                            <th>State</th>
                            <th>Control</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $index = 1;
                        while ($row = mysqli_fetch_assoc($order_op)) { ?>
                            <tr>
                                <td><?php echo $index ?></td>
                                <td><?php echo $row['totalprice']; ?></td>
                                <td><?php echo $row['order_date'];  ?></td>
                                <td><?php echo $row['shipped_date']; ?></td>
                                <td><?php echo $row['order_address']; ?></td>
                                <td><?php echo $row['is_vouchered']; ?></td>
                                <td><?php echo $row['v_code']; ?></td>
                                <td><?php echo $row['p_type']; ?></td>
                                <td><?php if(strtotime($row['shipped_date']) > time()) echo '<h4 class="text-warning">On its way</h4>'; else echo '<h4 class="text-success">Delivered</h4>';  ?></td>
                                <td style="text-align: center; " class="tr-ctrl align-middle">
                                <button class="crtl-btn ml-3 delete btn btn-primary"><a class="text-light" href="">Details</a></button>
                                </td>
                            </tr>
                        <?php $index = $index + 1;
                        } ?>
                    </tbody>
                   

                </table>
            </div>
    </div>
</div>

<style type="text/css">
body{
background-color:#f2f6fc;
color:#69707a;
}
.img-account-profile {
    height: 10rem;
}
.rounded-circle {
    border-radius: 50% !important;
}
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
}
.card .card-header {
    font-weight: 500;
}
.card-header:first-child {
    border-radius: 0.35rem 0.35rem 0 0;
}
.card-header {
    padding: 1rem 1.35rem;
    margin-bottom: 0;
    background-color: rgba(33, 40, 50, 0.03);
    border-bottom: 1px solid rgba(33, 40, 50, 0.125);
}
.form-control, .dataTable-input {
    display: block;
    width: 100%;
    padding: 0.875rem 1.125rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1;
    color: #69707a;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #c5ccd6;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

/* .nav-borders .nav-link.active {
    color: #0061f2;
    border-bottom-color: #0061f2;
}
.nav-borders .nav-link {
    color: #69707a;
    border-bottom-width: 0.125rem;
    border-bottom-style: solid;
    border-bottom-color: transparent;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    padding-left: 0;
    padding-right: 0;
    margin-left: 1rem;
    margin-right: 1rem;
} */

</style>

<script type="text/javascript">

</script>
<script src="../script.js"></script>
</body>
</html>