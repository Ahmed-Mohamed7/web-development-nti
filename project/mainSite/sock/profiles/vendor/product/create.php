<?php
require_once "../../../../DbConnection.php";
require_once "../../../layouts/headers.php";
require_once "../../../../Helpers/verifyUser.php";
require_once "../../../../Helpers/Validators.php";
require_once "../../../../Helpers/helpers.php";
vertifyVendor();
$sql = "select * from category";
$cate_op = mysqli_query($conn, $sql);
if (!$cate_op)
    echo "category=> " . mysqli_error($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = Clean($_POST['name'], 0);
    $price = Clean($_POST['price']);
    $description = Clean($_POST['description'], 0);
    $category = Clean($_POST['category']);
    $size = Clean($_POST['size']);
    $color = Clean($_POST['color']);
    $amount_left = Clean($_POST['amount_left']);

    $errors = [];

    #validate name   
    if (Validate($name, 'empty'))
        $errors['name'] = REQ_ERR;
    else if (Validate($name, 'string'))
        $errors['name'] = errorFormat('Name must be string');
    else if (Validate($name, 'lengthG', 50))
        $errors['name'] = errorFormat('Name must be <= 50 characters');

    #validate price
    if (Validate($price, 'empty'))
        $errors['price'] = REQ_ERR;
    else if (Validate($price, 'number'))
        $errors['price'] = errorFormat('Invalid price');



    #validate description
    if (Validate($description, 'empty'))
        $errors['description'] = REQ_ERR;
    else if (Validate($description, 'lengthG', 255))
        $errors['description'] = errorFormat('description must be <= 255 characters');
    else if (Validate($description, 'string'))
        $errors['description'] = errorFormat('description must be string');

    # validate category
    if (Validate($category, 'empty'))
        $errors['category'] = REQ_ERR;


    #validate size
    if (Validate($size, 'empty'))
        $errors['size'] = REQ_ERR;
    else if (Validate($size, 'string'))
        $errors['size'] = errorFormat('invalid size');

    #validate color
    if (Validate($color, 'empty'))
        $errors['color'] = REQ_ERR;
    else if (Validate($color, 'string'))
        $errors['color'] = errorFormat('invalid color');

    #validate amount
    if (Validate($amount_left, 'empty'))
        $errors['amount_left'] = REQ_ERR;
    else if (Validate($amount_left, 'number'))
        $errors['amount_left'] = errorFormat('invalid amount_left');

    #validate image
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
        $errors['image'] = REQ_ERR;
    }

    $id = $_SESSION['user']['id'];
    $link = './index.php?id=' . $id;
    
    if (count($errors) == 0) {
        $err = false;
        echo "ahmed";
        ##set image
        $disPath = SetImageName($imgName, '');
        if (!move_uploaded_file($imgTemp, "../../../../../uploads/" . $disPath)) {
            $errors['image'] = errorFormat('Invalid image extension');
            $err = true;
        }
        if (!$err) {

            $insert_sql = "INSERT INTO `product`(`name`, `price`, `image`, `description`, `category_id`, `vendor_id`, `size`, `color`, `amount_left`) 
                    VALUES ('$name',$price,'$disPath','$description',$category, $id,'$size','$color',$amount_left)";
            $insert_op = mysqli_query($conn, $insert_sql);
            if (!$insert_op) {
                echo mysqli_error($conn);
                echo "<script> alert('error while creating '); window.location.href='./create.php'; </script>";
            }

            echo "<script> alert('product added successfully'); window.location.href='$link'; </script>";
        } else {
            $_SESSION['message'] = $errors;
            // header("location: $link");
        }
    } else {
        $_SESSION['message'] = $errors;
        //header("location: $link");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">

    <title>Document</title>
</head>

<body>
    <div class="container my-5 pb-5">
        <h1 class="text-center ">Add products</h1>
        <a class="btn btn-primary my-3" href="./index.php?id=<?php echo $_SESSION['user']['id'] ?>">< Index</a>
        <form action="./create.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <?php if (isset($_SESSION['message']['name'])) echo errorFormat($_SESSION['message']['name']) ?>
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp" placeholder="Enter name">
            </div>
            <div class="form-group">
                <?php if (isset($_SESSION['message']['price'])) echo errorFormat($_SESSION['message']['price']) ?>

                <label for="exampleInputEmail1">price</label>
                <input type="number" class="form-control" id="exampleInputEmail1" name="price" aria-describedby="emailHelp" placeholder="Enter price">
            </div>
            <div class="form-group">
                <?php if (isset($_SESSION['message']['description'])) echo errorFormat($_SESSION['message']['description']) ?>
                <label for="exampleInputEmail1">Description</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="description" aria-describedby="emailHelp" placeholder="Enter description">
            </div>
            <div class="form-group">
                <?php if (isset($_SESSION['message']['category'])) echo errorFormat($_SESSION['message']['category']) ?>

                <label>Category</label>
                <select name="category">
                    <?php while ($row = mysqli_fetch_assoc($cate_op)) { ?>
                        <option value=<?php echo $row['id'] ?>><?php echo $row['name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <?php if (isset($_SESSION['message']['size'])) echo errorFormat($_SESSION['message']['size']) ?>

                <label for="exampleInputEmail1">Size</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="size" aria-describedby="emailHelp" placeholder="Enter size">
            </div>

            <div class="form-group">
                <?php if (isset($_SESSION['message']['color'])) echo errorFormat($_SESSION['message']['color']) ?>

                <label for="exampleInputEmail1">Color</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="color" aria-describedby="emailHelp" placeholder="Enter color">
            </div>

            <div class="form-group">
                <?php if (isset($_SESSION['message']['amount_left'])) echo errorFormat($_SESSION['message']['amount_left']) ?>

                <label for="exampleInputPassword1">Amount Left</label>
                <input type="number" class="form-control" id="exampleInputPassword1" name="amount_left" placeholder="amount_left">
            </div>

            <div class="form-group">
                <?php if (isset($_SESSION['message']['image'])) echo errorFormat($_SESSION['message']['image']) ?>

                <label>image : </label>
                <input type="file" name="image">
            </div>
            <button type="submit" name="add" class="btn btn-primary">Submit</button>
            <?php if (isset($_SESSION['message'])) unset($_SESSION['message']) ?>
        </form>
    </div>
</body>

</html>