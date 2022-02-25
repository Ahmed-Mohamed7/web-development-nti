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

if (isset($_GET['id']) ) {
    $id = $_GET['id'];
    $prod_sql = "select product.*,category.name as c_name , category.id as c_id from product join category on product.category_id = category.id where product.id = $id";
    $prod_op = mysqli_query($conn, $prod_sql);
    if (!$prod_op)
        echo "prod=> " . mysqli_error($conn);
    $prods = mysqli_fetch_assoc($prod_op);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {

    $ven_id = $_SESSION['user']['id'];
    $index_link = "./index.php?id=" . $ven_id;
    $current_link = "./edit.php?id=".$id;
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

        if ($img_found) {
            $disPath = SetImageName($imgName, '');
            if (!move_uploaded_file($imgTemp, '../../../../../uploads/' . $disPath)) {
                $errors['image'] = errorFormat('Invalid image extension');
                $err = true;
            }
            $img_q = ",`image`='$disPath'";
            unlink(IMG_PATH . $ven_data['image']);
        } 
        else $img_q = "";

        if (!$err) {
            $update_product_sql = "UPDATE `product` SET `name`='$name',`price`=$price".$img_q.",`description`='$description',`category_id`=$category,`vendor_id`= $ven_id,`size`='$size',`color`='$color',`amount_left`=$amount_left WHERE id =$id ";

            $update_vendor_op = mysqli_query($conn, $update_product_sql);
            if (!$update_product_sql)
                echo "vendor => " . mysqli_error($conn);
            else
                echo "<script> alert('data updated successfully'); window.location.href='$index_link'; </script>";
        }
        else{
            $_SESSION['message'] = $errors;
           // header("location: $current_link");

        }
    } 
    else {
        $_SESSION['message'] = $errors;
        //header("location: $current_link");
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
        <h1 class="text-center text-primary">Edit product</h1>
        <a class="btn btn-primary my-3" href="./index.php?id=<?php echo $_SESSION['user']['id'] ?>">
            < Index</a>
                <form action="./edit.php?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <?php if (isset($_SESSION['message']['name'])) echo errorFormat($_SESSION['message']['name']) ?>
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp" placeholder="Enter name" value="<?php echo $prods['name'] ?>">
                    </div>
                    <div class="form-group">
                        <?php if (isset($_SESSION['message']['price'])) echo errorFormat($_SESSION['message']['price']) ?>

                        <label for="exampleInputEmail1">price</label>
                        <input type="number" class="form-control" id="exampleInputEmail1" name="price" aria-describedby="emailHelp" placeholder="Enter price" value="<?php echo $prods['price'] ?>">
                    </div>
                    <div class="form-group">
                        <?php if (isset($_SESSION['message']['description'])) echo errorFormat($_SESSION['message']['description']) ?>
                        <label for="exampleInputEmail1">Description</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="description" aria-describedby="emailHelp" placeholder="Enter description" value="<?php echo $prods['description'] ?>">
                    </div>
                    <div class="form-group">
                        <?php if (isset($_SESSION['message']['category'])) echo errorFormat($_SESSION['message']['category']) ?>

                        <label>Category</label>
                        <select name="category">
                            <?php while ($row = mysqli_fetch_assoc($cate_op)) { ?>
                                <option value=<?php echo $row['id'] ?> <?php if ($row['id'] == $prods['c_id']) { ?> selected <?php } ?>><?php echo $row['name'] ?> </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <?php if (isset($_SESSION['message']['size'])) echo errorFormat($_SESSION['message']['size']) ?>

                        <label for="exampleInputEmail1">Size</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="size" aria-describedby="emailHelp" placeholder="Enter size" value="<?php echo $prods['size'] ?>">
                    </div>

                    <div class="form-group">
                        <?php if (isset($_SESSION['message']['color'])) echo errorFormat($_SESSION['message']['color']) ?>

                        <label for="exampleInputEmail1">Color</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="color" aria-describedby="emailHelp" placeholder="Enter color" value="<?php echo $prods['color'] ?>">
                    </div>

                    <div class="form-group">
                        <?php if (isset($_SESSION['message']['amount_left'])) echo errorFormat($_SESSION['message']['amount_left']) ?>

                        <label for="exampleInputPassword1">Amount Left</label>
                        <input type="number" class="form-control" id="exampleInputPassword1" name="amount_left" placeholder="amount_left" value="<?php echo $prods['amount_left'] ?>">
                    </div>
                    <?php if (isset($prods['image'])) { ?>
                        <div class="form-group">
                            <label>image</label>
                            <img style="max-width: 150px; max-height:150px;" src=" <?php echo "http://localhost/nti_course/project/uploads/" . $prods['image']; ?>">
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <?php if (isset($_SESSION['message']['image'])) echo errorFormat($_SESSION['message']['image']) ?>

                        <label>image : </label>
                        <input type="file" name="image">
                    </div>
                    <button type="submit" name="edit" class="btn btn-primary">Submit</button>
                    <?php if (isset($_SESSION['message'])) unset($_SESSION['message']) ?>
                </form>
    </div>
</body>

</html>