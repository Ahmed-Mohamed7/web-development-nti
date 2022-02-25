<?php
require_once "../../connections.php";
require_once "../../header.php";

$sql = "Select * from admins";
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
        <!-- Modal -->
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Edit Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <select id="SelectColumn" class="form-control">
                                    <option value="isbn  0" selected>Id</option>
                                    <option value="title 1">Name</option>
                                    <option value="description 4">Email</option>
                                    <option value="category_id 2">Birth Data</option>
                                    <option value="publishing_house_id 8">Address</option>
                                    <option value="author_id 3">Gender</option>
                                    <option value="price 6">Phone Number</option>
                                    <option value="price 6">Salary</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Value:</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="send" type="button" data-dismiss="modal" class="btn btn-primary">Done</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal End -->
        <!-- Body -->
        <div class="container-fluid">
            <h1 class="text-center text-primary display-3 mt-3">Employees Management</h1>
            <div class="row">
                <div class="col-8">
                    <input type="text" class=" bg-light mt-5 form-control ml-3" id="myInput" style="width: 50%;" onkeyup="myFunction()" placeholder="Search for Id or Name..">
                </div>
                <div class="col-3 ">
                   <button class="btn btn-primary mt-5"><a class="text-light" href="./create.php">Add Employee</a></button>
                </div>
            </div>
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
                            <th style="width: 10%">Name <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 6%">Email <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 7%">Birth Date<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 20%">Address<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 6%">Gender<i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 6%">Phone Number <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 6%">Salary <i class="fas fa-exchange-alt flip"></i></th>
                            <th style="width: 12%">Control</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Birth Date</th>
                            <th>Address</th>
                            <th>Gender</th>
                            <th>Phone Number</th>
                            <th>Salary</th>
                            <th>Control</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $index = 1;
                        while ($row = mysqli_fetch_assoc($data)) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email'];  ?></td>
                                <td><?php echo $row['birth_date']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td><?php echo $row['gender']; ?></td>
                                <td><?php echo $row['phone_number']; ?></td>
                                <td><?php echo $row['salary'] ?></td>
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