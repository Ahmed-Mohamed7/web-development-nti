<?php
require_once "../../../DbConnection.php";
require_once "../../layouts/headers.php";
require_once "../../../Helpers/verifyUser.php";
require_once "../../../Helpers/Validators.php";
require_once "../../../Helpers/helpers.php";

vertifyVendor();

if (isset($_GET['id'])) {
    ## get customer data
    $ven_id = Clean($_GET['id']);

    $error = [];
    $current_link = "./index.php?id=" . $ven_id;
    #validate 
    if (Validate($ven_id, 'empty'))
        $error['id'] = REQ_ERR;
    else if (Validate($ven_id, 'number'))
        $error['id'] = 'id must be number';

    if (count($error) == 0) {
        #check if the is exist
        if ($ven_id != $_SESSION['user']['id'])
            echo "<script> alert('you only can view your profile'); window.location.href='../../index.php'; </script>";
        $ven_sql = "SELECT * FROM vendor where id =  $ven_id";
        $ven_op = mysqli_query($conn, $ven_sql);
        if (!$ven_op)
            echo "vendor=> " . mysqli_error($conn);
        $ven_data = mysqli_fetch_assoc($ven_op);
    } else {
        $_SESSION['message'] = $errors;
    }
    #get orders data
    $order_sql = "select `order`.order_date as o_date,`order`.shipped_date as s_date ,`order`.order_address as o_add,`order`.id as oid,
                orderitem.quantity as i_q, orderitem.totalprice as i_price,
                product.*,customer.name as c_name , customer.phone_number as p_n,
                payment.type as p_t
                from `orderitem` 
                join product on  `orderitem`.product_id = product.id 
                join `order` on `orderitem`.order_id = `order`.id
                join customer on `order`.customer_id = customer.id
                join payment on `order`.payment_id = payment.id
                where `product`.vendor_id = $ven_id order by o_date DESC limit 10";
    $order_op = mysqli_query($conn,$order_sql);
    if(! $order_op)
        echo "order".mysqli_error($conn);

} else {
    echo "<script> alert('404 not found customer'); window.location.href='../../index.php'; </script>";
}

if ($_SERVER['REQUEST_METHOD'] = 'POST' && isset($_POST['edit'])) {

    $name = Clean($_POST['name'], 0);
    $email = Clean($_POST['email']);
    $phone = Clean($_POST['phone']);
    $address = Clean($_POST['address'], 0);
    $url = Clean($_POST['url']);

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

    # validate url
    if (Validate($url, 'empty'))
        $errors['url'] = REQ_ERR;
    else if (Validate($url, 'url'))
        $errors['url'] = errorFormat('invalid value for gender');

    $img_found = true; 
    if (!empty($_FILES['image']['name'])) {
        $imgName  = $_FILES['image']['name'];
        $imgTemp  = $_FILES['image']['tmp_name'];
        $imgType  = $_FILES['image']['type'];
        $imgSize  = $_FILES['image']['size'];

        $tempName = explode('.', $imgName);
        $imgExtension =  strtolower(end($tempName));

        if ($imgSize > MAX_UPLOAD_SIZE)
            $errors['image'] = errorFormat('max upload size 5MB');
        else if (Validate($imgExtension, 'extension'))
            $errors['image'] = errorFormat('Invalid image extension');
    } else {
        $img_found = false;
    }


    if (count($errors) == 0) {
        $err = false;
        ##check email
        ##didn't change email
        if ($email == $_SESSION['user']['email'])
            $email_q = '';
        else {
            $email_sql = "select * from vendor where email = '$email'";
            $email_op = mysqli_query($conn, $email_sql);

            if (mysqli_num_rows($email_op) == 0) {
                $_SESSION['user']['email'] = $email;
                $email_q = "`email`='$email',";
            } else {
                echo "<script> alert('email is already exists'); window.location.href='$current_link'; </script>";
            }
        }
        ##update image
        if($img_found){
            $disPath = SetImageName($imgName, '');
            if (!move_uploaded_file($imgTemp, '../../../../uploads/' . $disPath)) {
                $errors['image'] = errorFormat('Invalid image extension');
                $err = true;
            }
            $img_q = ",`image`='$disPath'";
            unlink(IMG_PATH.$ven_data['image']);
        }
        else $img_q = "";
       

        if (!$err) {
            ##### 
            $update_vendor_sql = "UPDATE `vendor` SET `name`='$name',`email`='$email',`phone_number`='$phone',
            `address`='$address',`website_url`='$url'".$img_q."  WHERE id = $ven_id";

            $update_vendor_op = mysqli_query($conn, $update_vendor_sql);
            if (!$update_vendor_op)
                echo "vendor => " . mysqli_error($conn);
            else 
            {
                $_SESSION['user']['name'] = $name;
                echo "<script> alert('data updated successfully'); window.location.href='$current_link'; </script>";
            }
            
        }
    } else {
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
                <div class="card   mb-3">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center ">
                        <!-- Profile picture image-->
                        <!-- <img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt=""> -->
                        <!-- Profile picture help block-->
                        <div class="card-body text-center">
                            <!-- Profile picture image-->
                            <img class="img-account-profile rounded-circle mb-2" style="max-width: 200px; max-height : 200px;" src="<?php echo "http://localhost/nti_course/project/uploads/" . $ven_data['image'] ?>" alt="">
                            <!-- Profile picture help block-->
                            <h3 class="font-italic text-dark mb-4">Name :<?php echo $ven_data['name'] ?> </h3>
                            <h3 class="font-italic text-dark mb-4">Verified :
                                <?php if ($ven_data['is_verified']) echo '<span class="text-success"> YES </span>';
                                else echo ' <span class="text-danger"> No </span>'; ?>
                            </h3>
                            <!-- Profile picture upload button-->
                        </div>

                    </div>
                </div>
                <button class="btn btn-primary btn-round d-flex mb-3"><a class="text-white" href="./product/index.php?id=<?php echo $ven_id ?>">Products</a></button>
                <button class="btn btn-primary btn-round"><a class="text-white" href="./product/create.php" >add products</a></button>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $ven_id ?>" method="POST" enctype="multipart/form-data">
                            <!-- Form Group (username)-->
                            <div class="mb-3">
                                <?php if (isset($_SESSION['message']['name'])) echo errorFormat($_SESSION['message']['name']); ?>
                                <label class="small mb-1" for="inputUsername">Full Name</label>
                                <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" name="name" value="<?php echo $ven_data['name'] ?>">
                            </div>

                            <!-- Form Row        -->

                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <?php if (isset($_SESSION['message']['email'])) echo errorFormat($_SESSION['message']['email']); ?>

                                <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                <input class="form-control" id="inputEmailAddress" type="email" name="email" placeholder="Enter your email address" value=<?php echo $ven_data['email']  ?>>
                            </div>
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (organization name)-->
                                <div class="mb-3">
                                    <?php if (isset($_SESSION['message']['url'])) echo errorFormat($_SESSION['message']['url']); ?>
                                    <label class="small mb-1" for="inputUsername">WebSite Url</label>
                                    <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" name="url" value="<?php echo $ven_data['website_url'] ?>">
                                </div>
                                <!-- Form Group (location)-->

                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <?php if (isset($_SESSION['message']['phone'])) echo errorFormat($_SESSION['message']['phone']); ?>

                                    <label class="small mb-1" for="inputPhone">Phone number</label>
                                    <input class="form-control" id="inputPhone" type="tel" name="phone" placeholder="Enter your phone number" value=<?php echo $ven_data['phone_number']  ?>>
                                </div>
                                <!-- Form Group (birthday)-->
                            </div>

                            <div class="mb-3">
                                <?php if (isset($_SESSION['message']['address'])) echo errorFormat($_SESSION['message']['address']); ?>

                                <label class="small mb-1" for="inputEmailAddress">Address</label>
                                <input class="form-control" id="inputEmailAddress" type="text" name="address" placeholder="Enter your email address" value="<?php echo $ven_data['address'] ?>">
                            </div>

                            <div class="form-group">
                                <?php if (isset($_SESSION['message']['image'])) echo errorFormat($_SESSION['message']['image']); ?>

                                <label for="exampleInputPassword">Image</label>
                                <input type="file" name="image">
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" name="edit" type="submit">Save changes</button>
                            <?php if (isset($_SESSION['message'])) unset($_SESSION['message']); ?>
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
                            <th style="width: 5%">OrderId <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">OrderDate <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">ShippedDate<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">OrderAddress<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">Product Name<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 5%">Quantity <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 5%">price <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">Payment <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">customerName <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">customerPhone <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">State</th>
                            <th >action</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>OrderId</th>
                            <th>OrderDate</th>
                            <th> ShippedDate</th>
                            <th>OrderAddress</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>price</th>
                            <th>Payment</th>
                            <th>customerName</th>
                            <th>customerPhone</th>
                            <th>State</th>
                            <th >action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $index = 1;
                        while ($row = mysqli_fetch_assoc($order_op)) { ?>
                            <tr>
                                <td><?php echo $index ?></td>
                                <td><?php echo $row['oid']; ?></td>
                                <td><?php echo $row['o_date']; ?></td>
                                <td><?php echo $row['s_date'];  ?></td>
                                <td><?php echo $row['o_add']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['i_q']; ?></td>
                                <td><?php echo $row['i_price']; ?></td>
                                <td><?php echo $row['p_t']; ?></td>
                                <td><?php echo $row['c_name']; ?></td>
                                <td><?php echo $row['p_n']; ?></td>
                                <td><?php if (strtotime($row['s_date']) > time()) echo '<h4 class="text-warning">On its way</h4>';
                                    else echo '<h4 class="text-success">Delivered</h4>';  ?></td>
                                <td><a class="btn btn-danger" href="./refuse.php?or_id=<?php echo $row['oid']?>&prod_id=<?php echo $row['id'] ?>">Refuse</a></td>
                            </tr>
                        <?php $index = $index + 1;
                        } ?>
                    </tbody>


                </table>
            </div>
        </div>
    </div>

    <style type="text/css">
        body {
            background-color: #f2f6fc;
            color: #69707a;
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

        .form-control,
        .dataTable-input {
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