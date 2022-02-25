<?php
require_once "../DbConnection.php";
require_once "./layouts/headers.php";
require_once "../Helpers/verifyUser.php";
require_once "../Helpers/Validators.php";
#get product
if (isset($_GET['product_id'])) {
  $product_id = $_GET['product_id'];
  $prod_sql = "SELECT product.*,vendor.name as v_name , vendor.id as v_id , category.id as c_id , category.name as c_name
                 FROM product join vendor on product.vendor_id = vendor.id 
                 join category on product.category_id = category.id where product.id = $product_id";
  $prod_op = mysqli_query($conn, $prod_sql);
  if (!$prod_op)
    echo "product =>" . mysqli_error($conn);

  $prod_data = mysqli_fetch_assoc($prod_op);
  $user_id = $_SESSION['user']['id'];
  ## get reviews 
  $rev_sql = "select review.*,customer.name as c_name,customer.id as c_id from review join customer on review.customer_id = customer.id where product_id = $product_id";
  $rev_op = mysqli_query($conn, $rev_sql);
  if (!$rev_op)
    echo "reviews =>" . mysqli_error($conn);
} 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $rate = Clean($_POST['rate']);
  $description = Clean($_POST['description']);

  $errors = [];
  #validate
  if (Validate($rate, 'empty'))
    $errors['rate'] = REQ_ERR;
  else if (Validate($rate, 'number'))
    $errors['rate'] = "rate must be number";

  if (Validate($description, 'empty'))
    $errors['description'] = REQ_ERR;
  else if (Validate($description, 'string'))
    $errors['description'] = "description must be string";

  if (count($errors) == 0)
  {
    $insert_rev_sql = "INSERT INTO `review`(`customer_id`, `product_id`, `rate`, `description`) VALUES ($user_id,$product_id,$rate,'$description')";
    $insert_rev_op = mysqli_query($conn,$insert_rev_sql);
    if(!$insert_rev_op)
        echo"add review=> ".mysqli_error($conn);
    else
      echo "<script> alert('review added successfully'); window.location.href='./product.php?product_id=".$product_id."#addreview'; </script>";
  }else{
    $_SESSION['message'] = $errors;
    header("location: ./product.php?product_id=".$product_id."#addreview");
  }
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
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- style css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Responsive-->
  <link rel="stylesheet" href="css/responsive.css">
  <!-- fevicon -->
  <link rel="icon" href="images/fevicon.png" type="image/gif" />
  <!-- Scrollbar Custom CSS -->
  <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
  <!-- Tweaks for older IEs-->
  <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
  <!-- owl stylesheets -->
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
  <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<!-- body -->

<body class="main-layout">
  <!-- loader  -->
  <div class="loader_bg">
    <div class="loader"><img src="images/loading.gif" alt="#" /></div>
  </div>
  <!-- end loader -->
  <!-- header -->

  <!-- end header -->

  <!-- plant -->
  <div id="plant" class="section  product">
    <div class="container">
      <div class="row">
        <div class="col-md-12 ">
          <div class="titlepage">
            <h2><strong class="black"> Our</strong> Products</h2>
          </div>
        </div>
      </div>
    </div>
  </div>







  <div class="container">
    <h3><a href="./products.php">All Products</a> &nbsp;> &nbsp;<?php echo $prod_data['name']; ?></h3>
    <br>
    <div class="row">
      <div class="col-md-3 text-center">
        <img class="img-thumbnail" style="width: 400px;" src="<?php echo IMG_SRC.$prod_data['image']; ?>">
      </div>
      <div class="col-md-6">
        <h4>Description:</h4>
        <p><?php echo $prod_data['description']; ?></p>
        <h4>Details:</h4>
        <table class="table">
          <tr>
            <td>Vendor:</td>
            <td><?php echo $prod_data['v_name']; ?></td>
          </tr>
          <tr>
            <td>Price:</td>
            <td><?php echo $prod_data['price']; ?> L.E</td>
          </tr>
          <tr>
            <td>Category:</td>
            <td><?php echo $prod_data['c_name']; ?></td>
          </tr>
          <tr>
            <td>Size:</td>
            <td><?php echo $prod_data['size']; ?></td>
          </tr>
          <tr>
            <td>Color:</td>
            <td><?php echo $prod_data['color']; ?></td>
          </tr>
          <tr>
            <td>Amount left:</td>
            <td><?php echo $prod_data['amount_left']; ?></td>
          </tr>
        </table>

        <div class="row">
          <?php
          if ($prod_data['amount_left'] <= 0) {
            echo '<p class="text-danger"><strong>Out Of Stock </strong></p>';
          } else if($_SESSION['type'] == 'customer'){
            echo '
          <form class = "col-md-3"method="post" action="./cart/addtoCart.php">
          <input type="hidden" name="prod_id" value="' . $product_id . '">
          <input type="hidden" name="prod_price" value="' . $prod_data['price'] . '">
          <input type="hidden" name="amount_left" value="' . $prod_data['amount_left'] . '">
            <input type="submit" value="Add To Cart" name="cart" class="btn btn-primary">
          </form>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="mt-3 container">
    <h2 class=" display-3 text-primary ">Reviews</h2>
    <?php while ($rev = mysqli_fetch_assoc($rev_op)) { ?>
      <div class="row m-4 bg-light">
        <div class="m-4">
          <h3 class="text-primary">Name : <span class="text-dark"><?php echo $rev['c_name'] ?></span></h3>
          <h3 class="text-primary">Rate : <span class="text-dark">
              <?php for ($i = 0; $i < $rev['rate']; $i++) {
                echo ' <i class="fas fa-star" style="color:	#D4AF37"></i>';
              } ?> (<?php echo $rev['rate'] ?>/5)</span></h3>

          <h3 class="text-primary">Content </h3>
          <h4 class="ml-3"><?php echo $rev['description'] ?></h4>
          <?php if($rev['customer_id'] == $_SESSION['user']['id']) {?>
            <button class="crtl-btn mt-3 delete btn btn-danger"><a class="text-light" href="./reviews/delete.php?cus_id=<?php echo $rev['customer_id']?>&prod_id=<?php echo $product_id?>">Delete</a></button>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
    <hr>
    <div class="mx-4" id="addreview">
      <form method="POST" action="./product.php?product_id=<?php echo $product_id ?>">
        <h1>Add Review</h1>
        <div class="form-group">
          <?php if(isset($_SESSION['message']['rate']) ) echo errorFormat($_SESSION['message']['rate']); ?>
          <label for="">rate</label>
          <select name="rate" class="ml-2" style="width: 150px;">
            <option value=1>Very Bad</option>
            <option value=2>Bad</option>
            <option value=3>Good</option>
            <option value=4>very Good</option>
            <option value=5>Excellent</option>
          </select>
        </div>
        <div class="form-group">
          <?php if(isset($_SESSION['message']['description']) ) echo errorFormat($_SESSION['message']['description']); ?>
          <label for="">Description</label>
          <textarea type="text" name="description" class="form-control" id="exampleInputPassword1"></textarea>
        </div>
        <button type="submit" name="add_review" class="btn btn-primary">Submit</button>
        <?php if(isset($_SESSION['message'])) unset($_SESSION['message']) ;   ?>
      </form>
    </div>

  </div>



  <!-- footer start-->
  <?php include_once "./layouts/footer.php"; ?>

  <!-- Javascript files-->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery-3.0.0.min.js"></script>
  <script src="js/plugin.js"></script>
  <!-- sidebar -->
  <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="js/custom.js"></script>
  <!-- javascript -->
  <script src="js/owl.carousel.js"></script>
  <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
  <script>
  </script>
</body>

</html>