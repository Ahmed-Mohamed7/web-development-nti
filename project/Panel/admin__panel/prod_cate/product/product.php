<?php
require_once "../../../connections.php";
require_once "../../../header.php";
require_once "../../../../config.php";

$sql = "SELECT `product`.*,category.name as c_name, vendor.name as v_name  FROM `product` 
        join category on `product`.category_id = category.id 
        join vendor on `product`.vendor_id = vendor.id 
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
            <h1 class="text-center text-primary display-3 mt-3">Products List</h1>
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
                            <th>Product Name <i class="fas fa-exchange-alt flip"></i></th>
                            <th>Price <i class="fas fa-exchange-alt flip"></i></th>
                            <th>Description<i class="fas fa-exchange-alt flip"></i></th>
                            <th>Category <i class="fas fa-exchange-alt flip"></i></th>
                            <th>Vendor Name<i class="fas fa-exchange-alt flip"></i></th>
                            <th>Amount left <i class="fas fa-exchange-alt flip"></i></th>
                            <th>Image <i class="fas fa-exchange-alt flip"></i></th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $index = 1;
                        while ($row = mysqli_fetch_assoc($data)) { ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['price'] ?></td>
                                <td><?php echo $row['description'] ?></td>
                                <td><?php echo $row['c_name']?></td>
                                <td><?php echo $row['v_name']?></td>
                                <td><?php echo $row['amount_left'] ?> items</td>
                                <td><img src="<?php echo IMG_SRC.$row['image']?>" alt="product image" style="max-width:100px; max-height:100px"</td>
                                <td style="text-align: center; " class="tr-ctrl align-middle">
                                    <button class="crtl-btn  delete btn btn-danger"><a class="text-light" href="./delete.php?id=<?php echo $row['id'] ?>">Delete</a></button>
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