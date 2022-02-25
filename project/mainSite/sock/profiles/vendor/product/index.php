<?php
require_once "../../../../DbConnection.php";
require_once "../../../layouts/headers.php";
require_once "../../../../Helpers/verifyUser.php";
require_once "../../../../Helpers/Validators.php";
require_once "../../../../Helpers/helpers.php";

vertifyVendor();

## get all products of this vendor
if (isset($_GET['id'])) {
    $ven_id = $_GET['id'];
    if ($ven_id != $_SESSION['user']['id'])
        echo "<script> alert('you only can view your profile'); window.location.href='../../index.php'; </script>";

    $sql = "select product.*,category.name as c_name from product join category on product.category_id = category.id where vendor_id = $ven_id";
    $op = mysqli_query($conn, $sql);
    if (!$op)
        echo "prods" . mysqli_error($conn);
} else {
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
    <h1 class="text-center text-primary my-5">all products</h1>

    <?php if (isset($_SESSION['item_del'])) {
        echo errorFormat($_SESSION['item_del']);
        unset($_SESSION['item_del']);
    } ?>
    <div class="table-responsive tabl">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead class="thead-dark">
                <tr>
                    <th style="width: 5%">Id <i class="fas fa-exchange-alt flip"></i></th>
                    <th style="width: 10%">Name <i class="fas fa-exchange-alt flip"></i></th>
                    <th style="width: 10%">Price <i class="fas fa-exchange-alt flip"></i></th>
                    <th style="width: 10%">Image<i class="fas fa-exchange-alt flip"></i></th>
                    <th style="width: 10%">Description<i class="fas fa-exchange-alt flip"></i></th>
                    <th style="width: 10%">Category<i class="fas fa-exchange-alt flip"></i></th>
                    <th style="width: 10%"> Size <i class="fas fa-exchange-alt flip"></i></th>
                    <th style="width: 10%">Color <i class="fas fa-exchange-alt flip"></i></th>
                    <th style="width: 10%">Amount Left <i class="fas fa-exchange-alt flip"></i></th>
                    <th style="width: 10%">Control</th>
                </tr>
            </thead>
            <tfoot class="thead-dark">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th> Description</th>
                    <th>Category</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Amount left</th>
                    <th>Control</th>
                </tr>
            </tfoot>
            <tbody>
                <?php $index = 1;
                while ($row = mysqli_fetch_assoc($op)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price'];  ?></td>
                        <td> <img style="max-width: 150px; max-height:150px;" src=" <?php echo IMG_SRC . $row['image']; ?>"></td>
                        <td><?php echo substr($row['description'],0,50); ?></td>
                        <td><?php echo $row['c_name']; ?></td>
                        <td><?php echo $row['size']; ?></td>
                        <td><?php echo $row['color']; ?></td>
                        <td><?php echo $row['amount_left'];  ?></td>
                        <td style="text-align: center; " class="tr-ctrl align-middle">
                            <button class="crtl-btn ml-3 delete btn btn-primary"><a class="text-light" href="./edit.php?id=<?php echo $row['id'] ?>">Edit</a></button>
                            <button class="crtl-btn ml-3 delete btn btn-danger"><a class="text-light" href="./delete.php?id=<?php echo $row['id'] ?>&vid=<?php echo $ven_id ?>">Delete</a></button>
                        </td>
                    </tr>
                <?php $index = $index + 1;
                } ?>
            </tbody>


        </table>
    </div>
</body>

</html>