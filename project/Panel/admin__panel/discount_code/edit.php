<?php

require_once '../../connections.php';
require_once '../../helpers/validators.php';
require_once '../../helpers/helpers.php';
require_once '../../header.php';

if (isset($_GET['id'])) {
    if (!isset($_GET['id']))
        header("location: ./index.php");
    else {
        $id = $_GET['id'];

        $sql = "select * from vouchercode where id = $id";
        $op  = mysqli_query($conn, $sql);
        if (!$op)
            header("location: ./index.php");
        $_SESSION['edit_id'] = $id;
        $data = mysqli_fetch_assoc($op);
    }
}







if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $code = Clean($_POST['code']);
    $description = Clean($_POST['description']);
    $discount_percentage = Clean($_POST['discount_percentage']);


    # Validate ...... 
    $errors = [];
    # validate code
    if (Validate($code, 'empty'))
        $errors['code'] = REQ_ERR;
    else if (Validate($code, 'string'))
        $errors['code'] = 'code must be string';

    # validate email
    if (Validate($description, 'empty'))
        $errors['description'] = REQ_ERR;
    else if (Validate($description, 'string'))
        $errors['description'] = 'description must be string';

    # validate email
    if (Validate($discount_percentage, 'empty'))
        $errors['discount_percentage'] = REQ_ERR;
    else if (Validate($discount_percentage, 'number'))
        $errors['discount_percentage'] = 'discount_percentage must be NUMBER';



    if (count($errors) == 0) {
        $id = $_SESSION['edit_id'];
        $admin_id = $_SESSION['admin']['id'];
        $sql  = "UPDATE `vouchercode` SET `code`='$code',`description`='$description',`discount_percentage`=$discount_percentage,`admin_id`=$admin_id WHERE id = $id";
        $insertOp = mysqli_query($conn, $sql);
        if ($insertOp) {
            echo "<script> alert('data updated successfully'); window.location.href='./index.php'; </script>";
            unset($_SESSION['edit_id']);
        } else {
            $link = './edit.php'.$id;
            echo "<script> alert('error while edit date" . mysqli_error($conn) . "'); window.location.href='./edit.php'; </script>";
        }
    }
    else{
        $_SESSION['message'] =  $errors; 
    }
}



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="book_style.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <title>Add Emp</title>
</head>

<body>
    <div class="my-5 row justify-content-center align-items-center">
        <h1 class="text-primary">Edit Employee</h1>
    </div>
    <div class="container my-5">
        <div class="my-3 ml-1">
            <?php if (isset($errors)) {
            ?>
                <div class="">
                    <?php foreach ($errors as $key => $value) { ?>
                        <div class="row"><?php echo $key . "    " . $value . "<br>" ?></div>
                    <?php } ?>
                </div>
            <?php
            }
            ?>

        </div>
        <form action="./edit.php?id=<?php echo $id ?>" method="POST">
            <?php if(isset($_SESSION['message']['code'])) echo errorFormat($_SESSION['message']['code']) ?>
            <label>code</label>
            <input style="display: inline-block;" type="text" class="form-control mb-3" id="isbn" name="code" placeholder="Name" value="<?php echo $data['code'] ?>">

            <?php if(isset($_SESSION['message']['description'])) echo errorFormat($_SESSION['message']['description']) ?>
            <label>description</label>
            <input style="display: inline-block; " type="text" class="form-control mb-3" id="email" name="description" value="<?php echo $data['description'] ?>"><br><br>
            <!-- <input class="mb-3" style=" display: inline-block; width:47%" type="password" class="form-control" id="pass" name="password" placeholder="Password"> -->

            <?php if(isset($_SESSION['message']['discount_percentage'])) echo errorFormat($_SESSION['message']['discount_percentage']) ?>
            <div class="row mb-3">
                <label>Discount Percentage</label>
                <input type="number" class="form-control" id="copies" name="discount_percentage" value="<?php echo $data['discount_percentage'] ?>">

            </div>



            <div class="my-5 row justify-content-center align-items-center">
                <button type="submit" class="add btn btn-success ">Edit</button>
                <?php if(isset($_SESSION['message'])) unset($_SESSION['message']) ?>

            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
</body>

</html>