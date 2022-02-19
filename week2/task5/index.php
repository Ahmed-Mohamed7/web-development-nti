<?php 

require_once "./connections.php";
require_once "./helpers.php";

if(!isset($_SESSION['user_id']))
{
    echo "<script> alert('you should register first'); window.location.href='./login.php'; </script>";
}
else{
    $id = $_SESSION['user_id'];
    echo $id;
    $sql = "SELECT * FROM todolist where `user_id` = $id ";
    $data = mysqli_query($conn,$sql);
    if(!$data)
        echo 'error ,please try again';
}



?>

<!DOCTYPE html>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <!-- custom css -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>

</head>

<body>

    <!-- container -->
    <div class="container">


        <div class="page-header">
            <h1>todolist</h1>
            <br>


          <?php 
          
            if(isset($_SESSION['Message'])){
                echo ' * '.$_SESSION['Message'];

                unset($_SESSION['Message']);
            }
          
          ?>



        </div>

        <a href="./create.php">+add task</a>
        <button style="float: right;" class=""><a href="./signout.php">singout</a></button>
        <table class='table table-hover table-responsive table-bordered ' style="margin-top: 30px;">
            <!-- creating our table heading -->
            <tr>
                <th>title</th>
                <th>content</th>
                <th>start date</th>
                <th>end date</th>
                <th>image</th>

                <th>action</th>
            </tr>

   <?php 
        while($result = mysqli_fetch_assoc($data)){


   ?>
            <tr>
                <td><?php  echo $result['title'];  ?></td>
                <td><?php  echo $result['content'];  ?></td>
                <td><?php  echo $result['stdate'];  ?></td>
                <td><?php  echo $result['enddate'];  ?></td>
                <td><img src= <?php  echo $result['image'];  ?> style="max-width: 150px; max-height :150px;"></td>

                <td>
                    <a href='./delete.php?id=<?php  echo $result['id'];  ?>' class='btn btn-danger m-r-1em'>Delete</a>
                </td>
            </tr>

<?php  } ?>
            <!-- end table -->
        </table>

    </div>
    <!-- end .container -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- confirm delete record will be here -->

</body>

</html>


<?php 
  
  mysqli_close($conn);

?>