<?php
require_once "../../connections.php";
require_once "../../header.php";

$sql = "SELECT `order`.*,customer.name as c_name, vouchercode.code as v_code ,payment.type as p_type FROM `order` 
        join customer on `order`.customer_id = customer.id 
        join payment on `order`.payment_id = payment.id 
        left join vouchercode on `order`.voucher_id = vouchercode.id;
        ";
$data = mysqli_query($conn, $sql);
if (!$data)
    echo mysqli_error($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/book_style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Orders</title>
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #eee;
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
        <div class="container-fluid">
            <h1 class="text-center text-primary display-3 mt-3">Orders List</h1>
            <input type="text" class=" bg-light mt-5 form-control ml-3" id="myInput" style="width: 50%;" onkeyup="myFunction()" placeholder="Search for ID or Customer Name..">
            <?php 
            if(isset($_SESSION['emp_deleted']))
                echo '<span style="color:red">'.$_SESSION['emp_deleted'].'</span>';
                unset($_SESSION['emp_deleted']);
            ?>
            <div class="table-responsive tabl">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="background-color: #ffffff;">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID <i class="fas fa-exchange-alt flip"></i></th>
                            <th>Customer Name <i class="fas fa-exchange-alt flip"></i></th>
                            <th>Total Price <i class="fas fa-exchange-alt flip"></i></th>
                            <th>Order Time<i class="fas fa-exchange-alt flip"></i></th>
                            <th>received Time <i class="fas fa-exchange-alt flip"></i></th>
                            <th>Order Address <i class="fas fa-exchange-alt flip"></i></th>
                            <th>VoucherCode <i class="fas fa-exchange-alt flip"></i></th>
                            <th>Is Approved <i class="fas fa-exchange-alt flip"></i></th>
                            <th>payment method<i class="fas fa-exchange-alt flip"></i></th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $index = 1;
                        while ($row = mysqli_fetch_assoc($data)) { ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['c_name'] ?></td>
                                <td><?php echo $row['totalprice'] ?></td>
                                <td><?php echo $row['order_date'] ?></td>
                                <td><?php echo $row['shipped_date']?></td>
                                <td><?php echo $row['order_address']?></td>
                                <td><?php echo $row['v_code'] ?></td>
                                <td><?php if($row['is_approved']) echo '<i class="fas fa-check-circle display-4 ml-4" style="color:green"></i>'; else echo '<i class="fas fa-times-circle display-4 ml-4" style="color:red"></i>';  ?></td>
                                <td><?php echo $row['p_type'] ?></td>
                                <td style="text-align: center; " class="tr-ctrl align-middle">
                                <button class="crtl-btn ml delete btn btn-primary"><a class="text-light" href="./order_items.php?id=<?php echo $row['id'] ?>">Details</a></button>
                                    <button class="crtl-btn ml-3 delete btn btn-danger"><a class="text-light" href="./delete.php?id=<?php echo $row['id'] ?>">Delete</a></button>
                                </td>                            
                            </tr>
                        <?php } ?>


                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="./work.js"></script>
</body>

</html>