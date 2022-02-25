<?php
session_start();
$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $rootDir."\\nti_course\project\mainSite\Helpers\helpers.php";
?>



<nav class="navbar navbar-expand-lg " style="background-color: #136af8;">
    <a class="navbar-brand text-light" href="http://localhost/nti_course/project/mainSite/sock/">OnlineStore</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav text-light ml-auto">
            <li class="nav-item active">
                <?php $link = url(''); ?>
                <a class="nav-link text-light" href="<?php echo $link ?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item ">
            <?php $link = url('about.html'); ?>
                <a class="nav-link text-light" href="<?php echo $link ?>">About</a>
            </li>
            <li class="nav-item">
            <?php $link = url('products.php'); ?>
                <a class="nav-link text-light" href="<?php echo $link ?>">Products</a>
            </li>
            <li class="nav-item">
                <?php $link = url('categories.php'); ?>
                <a class="nav-link text-light" href="<?php echo $link ?>">Categories</a>
            </li>
            <?php if (!isset($_SESSION['user'])) { ?>
                <li><a href="http://localhost/nti_course/project/mainSite/CustomerLoginSystem/login.php" class="text-white">Login</a></li>
            <?php } else {
                if (isset($_SESSION['type']) && $_SESSION['type'] == 'customer') { $link = url("cart/cart.php") ?>
                    <li class="nav-item">
                        <a class="nav-link text-light bg-warning" style="border-radius: 10px;" href="<?php echo $link ?>">Cart <i class="fas fa-cart-arrow-down "></i> (<?php if(isset($_SESSION['cart'])) echo count($_SESSION['cart']) ?>)</a>
                    </li>
            <?php } else if (isset($_SESSION['type']) && $_SESSION['type'] == 'vendor') { ?>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="http://localhost/nti_course/project/mainSite/sock/profiles/vendor/product/create.php">Add Product</a>
                    </li>
            <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['user']['name'] ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item " href="<?php 
                            if($_SESSION['type'] == 'customer') 
                                echo url('profiles/customer/index.php?id='.$_SESSION['user']['id']); 
                            else 
                                echo url('profiles/vendor/index.php?id='.$_SESSION['user']['id']); ?>
                            ">Profile</a>
                        <a class="dropdown-item " href="../signout.php">Signout</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>
