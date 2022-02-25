<?php
require_once "../../../connections.php";
require_once "../../../header.php";
require_once "../../../helpers/validators.php";
require_once "../../../helpers/helpers.php";


$sql = "SELECT * FROM category";
$data = mysqli_query($conn, $sql);
if (!$data)
    echo mysqli_error($conn);
else if ($_SERVER["REQEST_METHOD"] = "POST" && isset($_POST['name'])) {
    $name = Clean($_POST['name'], 0);
    #validate name
    $errName = ValidateName($name);
    if (!empty($errName)) {
        echo "<script> alert('invalid name'); window.location.href='./category.php'; </script>";
    } else {
        $name = strtolower($name);
        $name_sql = "SELECT * FROM category where name = '$name'";
        $name_op = mysqli_query($conn, $name_sql);
        if(!$name_op)
              echo "<script> alert('error while insert data'); window.location.href='./category.php'; </script>";
        else if (mysqli_num_rows($name_op) != 0)
            echo "<script> alert('this name is already exist'); window.location.href='./category.php'; </script>";
        else 
        {
            $insert_sql = "insert into category (`name`) values ('$name')";
            $insert_op = mysqli_query($conn, $insert_sql);
            if (!$insert_op)
                echo "<script> alert('error while insert data'); window.location.href='./category.php'; </script>";
            else
                echo "<script> alert('data inserted successfully'); window.location.href='./category.php'; </script>";
        }
    }
}
?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Events</title>
    <link href="../books/book_style.css" rel="stylesheet" />
    <style>
        .des {
            word-wrap: break-word;
        }

        .wrapword {
            white-space: -moz-pre-wrap !important;
            /* Mozilla, since 1999 */
            white-space: -pre-wrap;
            /* Opera 4-6 */
            white-space: -o-pre-wrap;
            /* Opera 7 */
            white-space: pre-wrap;
            /* css-3 */
            word-wrap: break-word;
            /* Internet Explorer 5.5+ */
            white-space: -webkit-pre-wrap;
            /* Newer versions of Chrome/Safari*/
            word-break: break-all;
            white-space: normal;
        }

        body {
            background-color: #eee;
        }

        table {
            background-color: #ffffff;
        }

        th {
            cursor: pointer;
        }

        .flip {
            transform: rotate(90deg);
        }
    </style>
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <main>

        <!-- Body -->

        <div class="container-fluid">
            <h1 class="text-center text-primary mt-4 display-3">Category Management</h1>
            <input type="text" class=" bg-light mt-5 form-control ml-3" id="myInput" style="width: 50%;" onkeyup="myFunction()" placeholder="Search for ID or Title..">
            <?php 
            if(isset($_SESSION['emp_deleted']))
                echo '<span style="color:red">'.$_SESSION['emp_deleted'].'</span>';
                unset($_SESSION['emp_deleted']);
            ?>
            <div class="table-responsive tabl">
                <table class="table table-bordered mt-5" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" style="width: 10%">ID <i class="fas fa-exchange-alt flip"></i></th>
                            <th class="text-center" style="width: 10%">Name <i class="fas fa-exchange-alt flip"></i></th>
                            <th class="text-center" style="width : 12%">Control</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-dark">
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Control</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $index = 1;
                        while ($row = mysqli_fetch_assoc($data)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $row['id']; ?></td>
                                <td class="text-center"> <?php echo $row['name']; ?></td>




                                <td style="text-align: center; " class="tr-ctrl align-middle">
                                    <button data-id="<?php echo $row['id']; ?>" data-index="<?php echo $index; ?>" class="crtl-btn  edit btn btn-primary" data-toggle="modal" data-target="#Modal">Edit</button>
                                    <button class="crtl-btn ml-3 delete btn btn-danger"><a class="text-light" href="./delete.php?id=<?php echo $row['id'] ?>">Delete</a></button>
                                </td>
                            </tr>
                        <?php $index = $index + 1;
                        } ?>
                    </tbody>
                    <tr class="align-middle">
                        <form action="./category.php" method="POST">
                            <td> </td>
                            <td class="align-middle"><input type="text" name="name" class="form-control" id="video_title" placeholder="Title"></td>
                            <td style="text-align: center;" class="align-middle"><button type="submit" class="add_videos align-middle btn btn-success">Add</button></td>
                        </form>

                    </tr>

                </table>
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../script.js"></script>
</body>

</html>