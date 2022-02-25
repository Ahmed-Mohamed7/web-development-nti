<?php
require_once "./header.php";


?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Panel</title>
    <link href="styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>


</head>

    <main>
        <div class="d-flex flex-column mx-auto work-div">
                <button type="button" id="btn_1" onclick="location.href='admin__panel/customers/index.php' " class="btn workshop-btn btn-outline-danger ">Customers <i class="fas fa-user-friends ml-2"></i></button>
                <button type="button" id="btn_2" onclick="location.href='admin__panel/vendors/index.php' " class="btn workshop-btn btn-outline-warning">Vendors<i class="fas fa-shopping-cart ml-2"></i></button>
                <button type="button" id="btn_3" onclick="location.href='admin__panel/orders/orders.php'" class="btn workshop-btn btn-outline-success">Orders <i class="fas fa-calendar-check ml-2"></i></button>
                <button type="button" id="btn_3" onclick="location.href='admin__panel/prod_cate/main.php'" class="btn workshop-btn btn-outline-danger">Products & Category <i class="fas fa-calendar-check ml-2"></i></button>
                <button type="button" id="btn_5" onclick="location.href='admin__panel/reviews/'" class="btn workshop-btn btn-outline-dark">Reviews <i class="fas fa-info-circle ml-2"></i></button>
                <button type="button" id="btn_4" onclick="location.href='admin__panel/discount_code/index.php'" class="btn workshop-btn btn-outline-info">VoucherCodes<i class="fas fa-percent ml-2"></i></button>
                <?php
                if($_SESSION['admin']['is_manager']){
                ?>
                    <button type="button" id="btn_4" onclick="location.href='./admin__panel/employees/index.php'" class="btn workshop-btn btn-outline-info">Employees <i class="fas fa-book ml-2"></i></button>
                    <button type="button" id="btn_4" onclick="location.href='admin__panel/dashboard'" class="btn workshop-btn btn-outline-info">DashBoard<i class="fas fa-percent ml-2"></i></button>
                <?php } ?>
                
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
</body>

</html>