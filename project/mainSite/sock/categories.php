<?php
require_once "../DbConnection.php";
require_once "./layouts/headers.php";
#get categories
$all_categories_Sql = "SELECT  * from category";
$all_category_op = mysqli_query($conn, $all_categories_Sql);
if (!$all_category_op)
    echo 'categories =>' . mysqli_error($conn);
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
    
    <div class="clothes_main section pt-5" style="background-color: #081b30;">
      <div class="container">
         <h1 class="text-light display-4 mb-2"><a class="text-light" href="./categories.php">Our<span class="ml-1" style="color: #136af8;">categories</span></a></h1>
         <div class="row">

            <?php while ($cat = mysqli_fetch_assoc($all_category_op)) { ?>
               <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 py-5">
                  <div class="sport_product  py-5" style="background-color: #136af8; border-radius:10px">
                     <h1 class=" mb-3 display-4" style="color:#fff;"><?php echo $cat['name'] ?></h1>
                     <button class="btn btn-dark" style="border-radius: 10px;"> <a href="./products.php?cat_id=<?php echo $cat['id'] ?>" class="text-white">Discover</a></button>
                  </div>
               </div>
            <?php } ?>
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