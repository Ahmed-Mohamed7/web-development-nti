<?php
require_once "../../DbConnection.php";
require_once "../layouts/headers.php";
require_once "../../Helpers/verifyUser.php";
require_once "../../Helpers/Validators.php";
$price = 0.0;
$amount = 0;

## get voucher codes
$voucher_sql = "select * from vouchercode where is_enable=1";
$voucher_op = mysqli_query($conn, $voucher_sql);
if (!$voucher_op)
    echo "voucher =>" . mysqli_error($conn);

## get payment methods
$payment_sql = "select * from payment";
$payment_op = mysqli_query($conn, $payment_sql);
if (!$payment_op)
    echo "payment =>" . mysqli_error($conn);

### voucher code
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['code'])) {
    $v_data = explode('||', $_POST['voucher']);
    //echo $v_data;
    $v_id = $v_data[0];
    $v_name = $v_data[1];

    $err = [];
    #validate
    if (Validate($v_id, 'empty'))
        $err['voucher_id'] = 'field required';
    else if (Validate($v_id, 'number'))
        $err['voucher_id'] = 'voucher_id must be integer';

    if (Validate($v_name, 'empty'))
        $err['v_name'] = 'field required';
    else if (Validate($v_name, 'string'))
        $err['v_name'] = 'voucher_code must be string';

    if (count($err) == 0) {
        $check_code_sql = "select * from vouchercode where id =$v_id and code='$v_name'";
        $check_code_op = mysqli_query($conn, $check_code_sql);
        if (!$check_code_op)
            echo mysqli_error($conn);

        if (mysqli_num_rows($check_code_op) == 0) {
            echo "<script> alert('invalid voucher code'); window.location.href='./cart.php'; </script>";
        } else {
            if (isset($_SESSION['voucher_code']) && $_SESSION['voucher_code']['id'] == $v_id)
                echo "<script> alert('this voucher code is already used'); window.location.href='./cart.php'; </script>";

            $_SESSION['voucher_code']['id'] = $v_id;
            $_SESSION['voucher_code']['code'] = $v_name;
            $discount = mysqli_fetch_assoc($check_code_op)['discount_percentage']/100.0;
            $_SESSION['voucher_code']['discount'] = $discount;
            echo "<script> alert('voucher code added successfully'); window.location.href='./cart.php'; </script>";
        }
    } else {
        echo "<script> alert('$err'); window.location.href='./cart.php'; </script>";
    }
} else {
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Sock</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="../css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- owl stylesheets -->
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>

<body>
    <div class="container">
        <?php if (!isset($_SESSION['cart'])) { ?>
            <h1 class="text-center text-danger my-5 display-3"> your cart is empty</h1>
            <div class="d-flex">
                <button class="btn btn-warning mx-auto"><a href="../products.php" class="text-center">continue shopping</a></button>
            </div>
        <?php } else { ?>
            <div class="row my-5">
                <aside class="col-lg-8">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-borderless table-shopping-cart">
                                <thead class="text-muted">
                                    <tr class="small text-uppercase">
                                        <th scope="col">Product</th>
                                        <th scope="col" width="120">Quantity</th>
                                        <th scope="col" width="120">Price</th>
                                        <th scope="col" class="text-right d-none d-md-block" width="200"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($_SESSION['cart'] as $prod_id => $prod_q) {
                                        $prod_id = intval($prod_id);
                                        $prod_sql = "SELECT * FROM `product` where id = $prod_id";
                                        $prod_op = mysqli_query($conn, $prod_sql);
                                        if (!$prod_op)
                                            echo mysqli_error($conn);
                                        $prod = mysqli_fetch_assoc($prod_op);
                                        if (!$prod)
                                            continue;
                                        $price += $prod_q['price'] * $prod_q['quantity'];
                                    ?>
                                        <tr class="" style="border-bottom: soild 1px black;">
                                            <td>
                                                <figure class="itemside align-items-center">
                                                    <div class="aside"><img src="<?php echo IMG_SRC.$prod['image'] ?>" class="img-sm"></div>
                                                    <figcaption class="info"> <a href="#" class="title text-dark" data-abc="true"><?php echo $prod['name'] ?></a>
                                                        <p class="text-muted small">SIZE: <?php echo $prod['size'] ?> <br> Color: <?php echo $prod['color'] ?></p>
                                                    </figcaption>
                                                </figure>
                                            </td>
                                            <td> <input disabled value="<?php echo $prod_q['quantity'] ?>" class="mt-2" style="width: 60px;"> </td>
                                            <td>
                                                <div class="price-wrap"> <var class="price"><?php echo $prod_q['quantity'] * $prod['price']   ?></var> <small class="text-muted"> $<?php echo $prod['price'] ?> each </small> </div>
                                            </td>
                                            <i class="far fa-plus"></i>
                                            <td class="text-right d-none d-md-block">
                                                <a class="btn btn-danger ml-2" href="./edit.php?id=<?php echo $prod_id ?>&action=dec"><i class="fas fa-minus-circle"></i></a>
                                                <a data-original-title="Save to Wishlist" title="" href="./edit.php?id=<?php echo $prod_id ?>&action=inc" class="btn btn-success" data-toggle="tooltip" data-abc="true"> <i class="fas fa-plus-circle"></i></a>
                                                <a href="./delete.php?id=<?php echo $prod_id ?>" class="btn btn-warning mt-4" data-abc="true"> Remove</a>
                                            </td>
                                        </tr>
                                    <?php } ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </aside>
                <aside class="col-lg-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <form action="./cart.php" method="POST">
                                <div class="">
                                    <label>Have coupon?</label><br>
                                    <select class="bg-light mb-2" style="border: radius 10px; width: 80px;" name="voucher">
                                        <?php while ($voucher = mysqli_fetch_assoc($voucher_op)) { ?>
                                            <option value='<?php echo $voucher['id'] ?>||<?php echo $voucher['code'] ?>' <?php if ( isset($_SESSION['voucher_code']) && $voucher['id'] == $_SESSION['voucher_code']['id']) {?> selected <?php } ?>>
                                                <?php echo $voucher['code'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <button class="btn btn-primary btn-apply coupon mt-2 mb-3" type="submit" name="code">Apply</button>
                                    <?php if (isset($_SESSION['voucher_code'])) echo '<h3 class="text-success">' . $_SESSION['voucher_code']['code'] . ' is used</h3>';
                                    else echo '<h3 class="text-danger">no voucherCode used</h3>' ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <dl class="dlist-align">
                                <dt>Total price:</dt>
                                <dd class="text-right ml-3">$<?php echo $price  ?></dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Discount:</dt>
                                <dd class="text-right text-danger ml-3">-  <?php if(isset($_SESSION['voucher_code']['discount'])) echo $_SESSION['voucher_code']['discount'] * $price; else echo "zero"  ?> </dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Total:</dt>
                                <dd class="text-right text-dark b ml-3">$<strong class="text-success"><?php if(isset($_SESSION['voucher_code']['discount'])) echo $price - $_SESSION['voucher_code']['discount'] * $price; else echo $price  ?></strong></dd>
                            </dl>
                            <form action="./purchase.php" method="POST" class="">
                                <h4>payment method</h4>
                                <select name="payment">
                                        <?php while ($pay = mysqli_fetch_assoc($payment_op)) {?>
                                        <option value=<?php echo $pay['id']?> >
                                            <?php echo $pay['type'] ?>
                                        </option> 
                                        <?php } ?>
                                </select>
                                <hr> <button  href="./cart.php" name="purchase"  class="btn px-0 btn-primary btn-square btn-main" type="submit" data-abc="true">Make Purchase </button> <a href="../products.php" class="btn btn-out btn-success px-0 btn-square btn-main mt-2" data-abc="true">Continue Shopping</a>
                            </form>
                        </div>
                    </div>
                </aside>
            </div>
    </div>
    <?php include_once "../layouts/footer.php"; ?>
<?php } ?>
<!-- footer start-->

<!-- Javascript files-->
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/jquery-3.0.0.min.js"></script>
<script src="../js/plugin.js"></script>
<!-- sidebar ../-->
<script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="../js/custom.js"></script>
<!-- javascri../pt -->
<script src="../js/owl.carousel.js"></script>
<script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<script>
</script>
</body>

</html>