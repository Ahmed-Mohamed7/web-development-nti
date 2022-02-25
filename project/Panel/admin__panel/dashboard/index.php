<?php
require_once "../../connections.php";
require_once "../../header.php";

## get total profits
$profile_sql = "select sum(totalprice) as t_price from `orderitem`";
$profile_op = mysqli_query($conn, $profile_sql);
if (!$profile_op)
    echo mysqli_error($conn);
$total_profit = mysqli_fetch_assoc($profile_op)['t_price'];

# get the total number of orders
$order_sql = "select count(*) as c_order from `order`";
$order_op = mysqli_query($conn, $order_sql);
if (!$order_op)
    echo mysqli_error($conn);
$order_Count = mysqli_fetch_assoc($order_op)['c_order'];

# get the total number of customers
$customer_sql = "select count(*) as c_cus from `customer`";
$customer_op = mysqli_query($conn, $customer_sql);
if (!$customer_op)
    echo mysqli_error($conn);
$customer_Count = mysqli_fetch_assoc($customer_op)['c_cus'];


# get the total number of vendors
$vendor_sql = "select count(*) as c_vendor from `vendor`";
$vendor_op = mysqli_query($conn, $vendor_sql);
if (!$vendor_op)
    echo mysqli_error($conn);
$vendor_Count = mysqli_fetch_assoc($vendor_op)['c_vendor'];


# get the countries for vendors
$ven_sql = "SELECT COUNT(*) as c_count, Country
            FROM vendor GROUP BY Country;";
$ven_op = mysqli_query($conn, $ven_sql);


#get the no of customers for each country
$cus_sql = "SELECT COUNT(*) as c_count, country
            FROM customer GROUP BY country;";
$cus_op = mysqli_query($conn, $cus_sql);

# get the sales for each months
$sales_sql = "SELECT SUM(`orderitem`.totalprice) as sales,MONTH(`order`.order_date) as months FROM `order` JOIN `orderitem`
              on `order`.id = `orderitem`.order_id where YEAR(order_date)=2022 GROUP BY MONTH(`order`.order_date) order by MONTH(`order`.order_date) ;";
$sales_op = mysqli_query($conn, $sales_sql);

$months = [];
$sale = [];
while ($res = mysqli_fetch_assoc($sales_op)) {
    $sale[] = $res['sales'];
    $months[] = $res['months'];
}
$obj['sale'] = $sale;
$obj['months'] = $months;

# get the orders per each months
$or_sql = "SELECT COUNT(*) as c_orders,MONTH(`order`.order_date) as months FROM `order` where YEAR(order_date)=2022 GROUP BY MONTH(order_date) order by MONTH(order_date) ";
$or_op = mysqli_query($conn, $or_sql);

$mons = [];
$orders = [];
while ($res1 = mysqli_fetch_assoc($or_op)) {
    $orders[] = $res1['c_orders'];
    $mons[] = $res1['months'];
}
$obj['orders'] = $orders;
$obj['mons'] = $mons;


###
$link = "http://localhost/nti_course/project/Panel/admin__panel/";
$dashboard = [
    'customers' => $link . 'customers/', 'disount_code' => $link . 'discount_code', 'employees' => $link . 'employees/',
    'orders' => $link . 'orders/orders.php', 'prods and categories' => $link . 'prod_Cate/main.php','reviews'=>'reviews/',
    'vendors'=>$link.'vendors/'
]
?>
<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard | Bootstrap Simple Admin Template</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <link href="assets/vendor/flagiconcss/css/flag-icon.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <img src="assets/img/bootstraper-logo.png" alt="bootraper logo" class="app-logo">
            </div>
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="dashboard.html"><i class="fas fa-home"></i> Dashboard</a>
                </li>
               <?php foreach ($dashboard as $key => $value) {  ?>
                <li>
                    <a href="<?php echo $value ?>"><i class="fas fa-home"></i> <?php echo $key ?></a>
                </li>
                <?php } ?>
            
            </ul>
        </nav>
        <div id="body" class="active">
            <!-- navbar navigation component -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- end of navbar navigation -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 page-header">
                            <div class="page-pretitle">Overview</div>
                            <h2 class="page-title">Dashboard</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="icon-big text-center">
                                                <i class="teal fas fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="detail">
                                                <p class="detail-subtitle">Orders</p>
                                                <span class="number"><?php echo $order_Count ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <hr />
                                        <div class="stats">
                                            <i class="fas fa-calendar"></i> For this Week
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="icon-big text-center">
                                                <i class="olive fas fa-money-bill-alt"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="detail">
                                                <p class="detail-subtitle">Total Profits</p>
                                                <span class="number">$<?php echo $total_profit ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <hr />
                                        <div class="stats">
                                            <i class="fas fa-calendar"></i> For this Month
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="icon-big text-center">
                                                <i class="violet fas fa-eye"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="detail">
                                                <p class="detail-subtitle">Customers</p>
                                                <span class="number"><?php echo $customer_Count ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <hr />
                                        <div class="stats">
                                            <i class="fas fa-stopwatch"></i> For this Month
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="icon-big text-center">
                                                <i class="orange fas fa-envelope"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="detail">
                                                <p class="detail-subtitle">Vendors</p>
                                                <span class="number"><?php echo $vendor_Count ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <hr />
                                        <div class="stats">
                                            <i class="fas fa-envelope-open-text"></i> For this week
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="content">
                                            <div class="head">
                                                <h5 class="mb-0">PROFITS EACH MONTH</h5>
                                                <p class="text-muted">profit per each month</p>
                                            </div>
                                            <div class="canvas-wrapper">
                                                <canvas class="chart" id="trafficflow"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="content">
                                            <div class="head">
                                                <h5 class="mb-0">ORDERS EACH MONTH</h5>
                                                <p class="text-muted">orders per each month</p>
                                            </div>
                                            <div class="canvas-wrapper">
                                                <canvas class="chart" id="sales"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="content">
                                    <div class="head">
                                        <h5 class="mb-0">Top Vendors by Country</h5>
                                        <p class="text-muted">Current year website visitor data</p>
                                    </div>
                                    <div class="canvas-wrapper">
                                        <table class="table table-striped">
                                            <thead class="success">
                                                <tr>
                                                    <th>Country</th>
                                                    <th class="text-end">Unique Visitors</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = mysqli_fetch_assoc($ven_op)) { ?>
                                                    <tr>
                                                        <td> <?php echo $row['Country'] ?></td>
                                                        <td class="text-end"><?php echo $row['c_count'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="content">
                                    <div class="head">
                                        <h5 class="mb-0">Most Customers Countries</h5>
                                        <p class="text-muted">Current year website visitor data</p>
                                    </div>
                                    <div class="canvas-wrapper">
                                        <table class="table table-striped">
                                            <thead class="success">
                                                <tr>
                                                    <th>Country</th>
                                                    <th class="text-end">num of Visitors</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = mysqli_fetch_assoc($cus_op)) { ?>
                                                    <tr>
                                                        <td> <?php echo $row['country'] ?></td>
                                                        <td class="text-end"><?php echo $row['c_count'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var sale = <?php echo json_encode($obj); ?>;
    </script>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chartsjs/Chart.min.js"></script>
    <script src="assets/js/dashboard-charts.js"></script>
    <script src="assets/js/script.js">

    </script>
</body>

</html>