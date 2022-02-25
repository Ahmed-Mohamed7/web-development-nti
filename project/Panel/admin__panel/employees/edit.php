<?php

require_once '../../connections.php';
require_once '../../helpers/validators.php';
require_once '../../helpers/helpers.php';
require_once '../../header.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (!isset($_GET['id']))
        header("location: ./index.php");
    else {

        $id = $_GET['id'];

        $sql = "select * from admins where id = $id";
        $op  = mysqli_query($conn, $sql);
        if (!$op)
            header("location: ./index.php");
        $_SESSION['edit_id'] = $id;
        $data = mysqli_fetch_assoc($op);
    }
}







if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name = Clean($_POST['name'], 0);
    $email = Clean($_POST['email']);
    $address = Clean($_POST['address'], 0);
    $salary = Clean($_POST['salary']);
    $phone = Clean($_POST['phone']);
    $gender = Clean($_POST['gender']);
    $birthDate = Clean($_POST['birthdate']);
    $isManager = Clean($_POST['is_manager']);


    # Validate ...... 
    $errors = [];
    # validate name
    $errName = ValidateName($name);
    if (!empty($errName))
        $errors['name'] = $errName;

    # validate email
    $errEmail = ValidateEmail($email);
    echo $errEmail;
    if (!empty($errEmail))
        $errors['email'] = $errEmail;

    #validate address
    $errAddress = ValidateAddress($address);
    if (!empty($errAddress))
        $errors['address'] = $errAddress;

    #validate phone
    $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
    $phone = str_replace("-", "", $filtered_phone_number);
    $errPhone = ValidatePhone($phone);
    if (!empty($errPhone))
        $errors['phone'] = $errPhone;

    #validate salary
    $errSalary = ValidateNumbers($salary);
    if (!empty($errSalary))
        $errors['salary'] = $errSalary;

    #validate gender
    $errGender = ValidateGender($gender);
    if (!empty($errGender))
        $errors['gender'] = $errGender;

    #validate date
    $errBirth = validateDate($birthDate);
    if (!empty($errBirth))
        $errors['date'] = $errBirth;

    #validate is_manager
    $errMan = ValidateBoolean($isManager);
    if (!empty($errMan))
        $errors['is_manager'] = $errMan;


    if (count($errors) == 0) {
        $id = $_SESSION['edit_id'];
        ## check for email
        $email_sql = "select * from admins where email = '$email'";
        $email_op = mysqli_query($conn, $email_sql);
        if (!$email_op) {
            echo "<script> alert('error while edit date" . mysqli_error($conn) . "'); window.location.href='./edit.php'; </script>";
        }
        #email changed but 
        if (mysqli_num_rows($email_op) != 0) {
            $temp_data = mysqli_fetch_assoc($email_op);
            # different person
            if ($id != $temp_data['id'])
                echo "<script> alert('email is already exist'); window.location.href='./edit.php?id=$id'; </script>";
        }
        $sql  = "UPDATE `admins` SET `name`='$name',`email`='$email',`salary`=$salary,`birth_date`='$birthDate',`is_manager`=$isManager,`phone_number`='$phone',`address`='$address',`gender`='$gender' WHERE id = '$id'";
        $insertOp = mysqli_query($conn, $sql);
        if ($insertOp) {
            echo "<script> alert('data updated successfully'); window.location.href='./index.php'; </script>";
            unset($_SESSION['edit_id']);
        } else {
            echo "<script> alert('error while edit date" . mysqli_error($conn) . "'); window.location.href='./edit.php'; </script>";
        }
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
        <form action="./edit.php" method="POST">
            <input style="display: inline-block; width:47%" type="text" class="form-control" id="isbn" name="name" placeholder="Name" value="<?php echo $data['name'] ?>">
            <input style="display: inline-block; margin-left:5.5%; width:47%" type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $data['email'] ?>"><br><br>
            <!-- <input class="mb-3" style=" display: inline-block; width:47%" type="password" class="form-control" id="pass" name="password" placeholder="Password"> -->
            <textarea class="form-control" id="description" name="address" rows="2" value="<?php echo $data['address'] ?>"><?php echo $data['address'] ?></textarea><br>

            <div class="row mb-3">
                <div class="col">
                    <input type="number" class="form-control" id="copies" name="salary" placeholder="salary" value="<?php echo $data['salary'] ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="price" name="phone" placeholder="phone number" value="<?php echo $data['phone_number'] ?>">
                </div>
                <div class="col">
                    <select type="text" class="form-control" id="PubFormat" name="gender" value="<?php echo $data['gender'] ?>">
                        <option value="male" selected>Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label>birth date</label>
                    <input type="date" class="form-control" id="copies" name="birthdate" value="<?php echo $data['birth_date'] ?>">
                </div>

            </div>
            <div class="row ml-1">
                <label class=" mr-3">IS Manager</label>
                <select name="is_manager" style="width: 100px;">
                    <option value='0' <?php if ($data['is_manager'] == '0') { ?>selected <?php } ?>>NO</option>
                    <option value='1' <?php if ($data['is_manager'] == '1') { ?>selected <?php } ?>>YES</option>
                </select>
            </div>
            <div class="my-5 row justify-content-center align-items-center">
                <button type="submit" class="add btn btn-success ">Add</button>
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