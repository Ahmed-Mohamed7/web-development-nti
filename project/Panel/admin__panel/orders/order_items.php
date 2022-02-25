<?php
require_once('../../connections.php');
require_once '../../header.php';
require_once "../../../config.php";
$order_id = $_GET['id'];
$order_id = intval($order_id);
//echo $item_id
$items_sql = "SELECT `orderitem`.*,
        `product`.name as p_name, `product`.price as p_price, `product`.image as p_image,
        `vendor`.name as v_name, `vendor`.id as v_id FROM `product` 
        join `orderitem` on `orderitem`.product_id = `product`.id 
        join `vendor` on `product`.`vendor_id` = `vendor`.id
        WHERE `orderitem`.order_id = $order_id";

$items_op = mysqli_query($conn,$items_sql);
if(!$items_op)
    echo 'items'.mysqli_error($conn);
else{

}

$customer_sql = "SELECT `customer`.* FROM `ORDER` 
                join `customer` on `ORDER`.customer_id = `customer`.id 
                WHERE `order`.id = $order_id ";

$customer_op = mysqli_query($conn,$customer_sql);
if(!$customer_op)
    echo 'customer'.mysqli_error($conn);
else{
    $cutomer_data = mysqli_fetch_assoc($customer_op);
}
            
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Orders</title>
    <style>
        body {
            background-color: #eee;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="text-center text-primary my-5 display-3 pb-3 shadow">Order Items</h1>
        <div class="  rounded  my-4">
            <div class="row">
                <div class="col-6">
                    <h3 class="text-secondary my-3 pb-3">Order_ID : <span class="text-warning"><?php echo $order_id ?></span></h3>
                    <h3 class="text-secondary my-3 pb-3">Number of items : <span class="text-warning"><?php echo mysqli_num_rows($items_op) ?></span></h3>
                    <?php while ($items_data = mysqli_fetch_assoc($items_op)) {  ?>
                        <div class="row my-3 bg-light">
                            <div class="col-5 pic">
                                <img src="<?php echo IMG_SRC.$items_data['p_image'];  ?>" alt="Image1" style="max-width: 150px; max-height:150px" class="img-fluid">
                            </div>
                            <div class="col-7 py-3">
                                <h5 class="pt-2">product Id : <span class="text-primary"><?php echo $items_data['product_id'] ?></span></h5>
                                <h5 class="py-2">Product Name : <span class="text-primary"><?php echo $items_data['p_name'] ?></span> </h5>
                                <h5 class="">Vendor Id : <span class="text-primary"><?php echo $items_data['v_id'] ?></span> </h5>
                                <h5 class="">Vendor Name : <span class="text-primary"><?php echo $items_data['v_name'] ?></span> </h5>
                                <h5 class="">Product Price : <span class="text-success"><?php echo $items_data['p_price'] ?> $</span> </h5>
                                <h5 class="py-2">Quantity : <span class="text-success"><?php echo $items_data['quantity'] ?> items</span> </h5>
                                <h5 class="py-2 ">Total Price : <span class="text-success"><?php echo $items_data['totalprice'] ?> item </span></h5>
                            </div>

                        </div>
                    <?php } ?>
                </div>
                <div class="col-5 pt-2 bg-light border ml-5">
                    <h1 class="text-center text-dark mb-3">Customer Information</h1>
                    <h3 class="text-secondary py-2">Full Name :<span class="text-primary"> <?php echo $cutomer_data['name']; ?></span></h3>
                    <h3 class="text-secondary py-2">Email : <span class="text-primary"><?php echo $cutomer_data['email']; ?></span></h3>
                    <h3 class="text-secondary py-2">Birth Date : <span class="text-primary"><?php echo $cutomer_data['birthdate']; ?></span></h3>
                    <h3 class="text-secondary py-2">Address : <span class="text-primary"><?php echo $cutomer_data['address']; ?></span></h3>
                    <h3 class="text-secondary py-2">Phone Number : <span class="text-primary"><?php echo $cutomer_data['phone_number']; ?></span></h3>
                </div>

            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>