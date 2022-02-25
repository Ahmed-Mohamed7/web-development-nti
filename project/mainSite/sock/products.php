<?php
require_once "../DbConnection.php";
require_once "./layouts/headers.php";
if (isset($_GET['cat_id'])) {
    $cat_id = $_GET['cat_id'];
    $all_product_Sql = "SELECT product.*,category.name as c_name from 
    product join category on product.category_id  = category.id where category.id = $cat_id ";
    
}else if(isset($_GET['search'])){
    $search = $_GET['search'];
    $all_product_Sql = "SELECT product.*,category.name as c_name from 
    product join category on product.category_id  = category.id where product.name like '%$search%' ";
} 
else {
    #get categories
    $all_product_Sql = "SELECT product.*,category.name as c_name from 
            product join category on product.category_id  = category.id";
}
$all_product_op = mysqli_query($conn, $all_product_Sql);
if (!$all_product_op)
    echo 'products =>' . mysqli_error($conn);
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
                        <form action="./products.php" method="GET">
                            <input type="text" name="search" placeholder="search for any product" style="width: 300px; height:40px; border-radius:20px;">
                            <button class="btn btn-primary btn-round">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clothes_main section ">
        <div class="container bg-white">
            <div class="row">
                <?php while ($prod = mysqli_fetch_assoc($all_product_op)) { ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 ">
                        <div class="sport_product" style="width: 100%; height:100%">
                            <figure><img src="<?php echo IMG_SRC.$prod['image'] ?>" alt="img" style="max-width: 150px; max-height: 150px; " /></figure>
                            <div class="">
                                <h3><?php echo $prod['name'] ?></h3>
                                <p class="text-secondary my-2"><?php echo $prod['c_name'] ?></p>
                                <h3> $<strong class="text-success mb-2"><?php echo $prod['price'] ?></strong></h3>
                                <button class="btn btn-warning mb-2"><a href="./product.php?product_id=<?php echo $prod['id'] ?>">more details</a></button>
                            </div>
                        </div>
                    </div>
                <?php  } ?>


            </div>
        </div>
    </div>
    </div>
    <!-- end plant -->
    <!--about -->
    <div class="section about ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="titlepage">
                        <h2><strong class="black"> About</strong> Us</h2>
                        <span>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected randomised words which don't look even slightly believable</span>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <section>
        <div id="main_slider" class="section carousel slide banner-main" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#main_slider" data-slide-to="0" class="active"></li>
                <li data-target="#main_slider" data-slide-to="1"></li>
                <li data-target="#main_slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <div class="row marginii">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="carousel-sporrt_text ">
                                    <h1 class="sporrt_text">Best sports item shop our</h1>
                                    <p class="lorem_text">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected randomised words which don't look even slightly believableThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected randomised words which don't look even slightly believable</p>
                                    <div class="btn_main">
                                        <a class="btn btn-lg btn-primary" href="#" role="button">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="img-box">
                                    <figure><img src="images/child-image.png" style="max-width: 100%; border: 15px solid #fff;" /></figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <div class="row marginii">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="carousel-sporrt_text ">
                                    <h1 class="sporrt_text">Best sports item shop our</h1>
                                    <p class="lorem_text">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected randomised words which don't look even slightly believableThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected randomised words which don't look even slightly believable</p>
                                    <div class="btn_main">
                                        <a class="btn btn-lg btn-primary" href="#" role="button">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="img-box ">
                                    <figure><img src="images/child-image.png" style="max-width: 100%; border: 15px solid #fff;" /></figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <div class="row marginii">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="carousel-sporrt_text ">
                                    <h1 class="sporrt_text">Best sports item shop our</h1>
                                    <p class="lorem_text">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected randomised words which don't look even slightly believableThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected randomised words which don't look even slightly believable</p>
                                    <div class="btn_main">
                                        <a class="btn btn-lg btn-primary" href="#" role="button">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="img-box">
                                    <figure><img src="images/child-image.png" style="max-width: 100%; border: 15px solid #fff;" /></figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
    <!-- end about -->
    <!--Our  Clients -->
    <div id="plant" class="section_Clients layout_padding padding_bottom_0">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="titlepage">
                        <h2> Testmonial</h2>
                        <span style="text-align: center;">available, but the majority have suffered alteration in some form, by injected randomised words which don't look even slightly believable</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section Clients_2 layout_padding padding-top_0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">

                    <div id="testimonial" class="carousel slide" data-ride="carousel">

                        <!-- Indicators -->
                        <ul class="carousel-indicators">
                            <li data-target="#testimonial" data-slide-to="0" class="active"></li>
                            <li data-target="#testimonial" data-slide-to="1"></li>
                            <li data-target="#testimonial" data-slide-to="2"></li>
                        </ul>

                        <!-- The slideshow -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="titlepage">
                                    <div class="john">
                                        <div class="john_image"><img src="images/john-image.png" style="max-width: 100%;"></div>
                                        <div class="john_text">JOHN DUE<span style="color: #fffcf4;">(ceo)</span></div>
                                        <p class="lorem_ipsum_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, asIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as </p>
                                        <div class="icon_image"><img src="images/icon-1.png"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="titlepage">
                                    <div class="john">
                                        <div class="john_image"><img src="images/john-image.png" style="max-width: 100%;"></div>
                                        <div class="john_text">JOHN DUE<span style="color: #fffcf4;">(ceo)</span></div>
                                        <p class="lorem_ipsum_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, asIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as </p>
                                        <div class="icon_image"><img src="images/icon-1.png"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="titlepage">
                                    <div class="john">
                                        <div class="john_image"><img src="images/john-image.png" style="max-width: 100%;"></div>
                                        <div class="john_text">JOHN DUE<span style="color: #fffcf4;">(ceo)</span></div>
                                        <p class="lorem_ipsum_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, asIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as </p>
                                        <div class="icon_image"><img src="images/icon-1.png"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#testimonial" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#testimonial" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <!-- end Our  Clients -->
    <!-- start Contact Us-->

    <div id="plant" class="contact_us layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="titlepage">
                        <h2><strong class="black"> Contact</strong> Us</h2>
                        <span style="text-align: center;">available, but the majority have suffered alteration in some form, by injected randomised words which don't look even slightly believable</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact_us_2 layout_padding paddind_bottom_0">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="soc_text">soC</div>
                </div>
                <div class="col-md-6">
                    <div class="email_btn">
                        <form action="/action_page.php">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" placeholder="Name" name="Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" placeholder="Email" name="Email">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" placeholder="Phone" name="Phone">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" placeholder="Massage" name="text3">
                            </div>
                            <div class="submit_btn">
                                <button type="submit" class="btn btn-primary" style="background: #081b30; color: #fff; padding: 11px;">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="contact_us_3 layout_padding">
                    <div class="row">
                        <div class="col-md-4">
                            <h1 style="color: #ffffff; ">Newsletter</h1>
                            <p class="long_text">It is a long established fact that a reader will be distracted a</p>
                        </div>
                        <div class="col-md-8">
                            <div class="email_text">
                                <div class="input-group mb-3">
                                    <input style="border-bottom-left-radius: 20px !important; border-top-left-radius: 20px !important;" type="text" class="form-control" placeholder="Enter your email">
                                    <div class="input-group-append">
                                        <button style="border-top-right-radius: 20px !important; border-bottom-right-radius: 20px !important; color: #fff; padding-bottom: 10px; padding-top: 10px;" class="btn btn-primary" type="Subscribe">Subscribe</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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