<?php
require_once "../../connections.php";
require_once "../../header.php";

$sql = "Select vouchercode.*,admins.name as a_name,admins.id as a_id from vouchercode join admins on vouchercode.admin_id = admins.id";
$data = mysqli_query($conn, $sql);
if (!$data)
    echo mysqli_error($conn);

?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Employees</title>
    <link href="../../assets/book_style.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <!-- <script src="https://use.fontawesome.com/your-embed-code.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

    <style>
        body {
            background-color: #eee;
        }

        table {
            background-color: #ffffff;
        }

        .flip {
            transform: rotate(90deg);
        }

        th {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <main>
        
        <!-- Body -->
        <div class="container-fluid">
            <h1 class="text-center text-primary display-3 mt-3">Voucher codes Management</h1>
            <div class="row">
                <div class="col-8">
                    <input type="text" class=" bg-light mt-5 form-control ml-3" id="myInput" style="width: 50%;" onkeyup="myFunction()" placeholder="Search for ID or Code..">
                </div>
            </div>
            <a class="btn btn-primary my-4" href="./create.php">+Add voucher</a>
            <?php 
            if(isset($_SESSION['emp_deleted']))
                echo '<span style="color:red">'.$_SESSION['emp_deleted'].'</span>';
                unset($_SESSION['emp_deleted']);
            ?>
            <div class="table-responsive tabl">
           
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 5%">Id <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">Code <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 20%">Description<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">Discount Percentage <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 6%">IsEnabled<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">Added By<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 10%">Enable<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 12%">Control</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Discount Percentage</th>
                            <th>IsEnabled</th>
                            <th>Added By</th>
                            <th>Enable</th>
                            <th>Control</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $index = 1;
                        while ($row = mysqli_fetch_assoc($data)) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['code']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['discount_percentage']; ?> %</td>
                                <td><?php if($row['is_enable']) echo '<i class="fas fa-check-circle display-4 ml-3" style="color:green"></i>'; else echo '<i class="fas fa-times-circle display-4 ml-3" style="color:red"></i>';  ?></td>
                                <td><?php echo $row['a_name']; ?></td>
                                <td><?php if($row['is_enable']) 
                                    echo '<button class="btn btn-danger ml-3"><a class="text-white" href="./enable.php?id='.$row['id'].'&action=disable">disable</a></button>';
                                    else 
                                     echo '<button class="btn btn-primary ml-3"><a class="text-white" href="./enable.php?id='.$row['id'].'&action=enable">Enable</a></button>';
                                ?>
                                </td>
                                <td style="text-align: center; " class="tr-ctrl align-middle">
                                <button class="crtl-btn ml-3 delete btn btn-primary"><a class="text-light" href="./edit.php?id=<?php echo $row['id'] ?>">Edit</a></button>
                                    <button class="crtl-btn ml-3 delete btn btn-danger"><a class="text-light" href="./delete.php?id=<?php echo $row['id'] ?>">Delete</a></button>
                                </td>
                                
                            </tr>
                        <?php $index = $index + 1;
                        } ?>
                    </tbody>
                   

                </table>
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>