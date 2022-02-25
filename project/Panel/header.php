<?php
require_once "connections.php";
define('ROOTPATH', $_SERVER['HTTP_HOST'].'/nti_course/project/panel/login.php');
if (!isset($_SESSION['admin'])) {
  //$_SERVER['DOCUMENT_ROOT']
  echo "<script> alert('you should register first'); window.location.href='http://localhost/nti_course/project/panel/login.php'; </script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Admin Panel </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="http://localhost/nti_course/project/Panel/admin_panel.php">Onlinestore</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <?php
        if (isset($_SESSION['admin'])) { ?>
                <a class="nav-link" href='//<?php  echo ROOTPATH  ?>'>Profile</a></li>';
                <a class="nav-link" href="signout.php">Sign Out</a></li>';
        <?php } ?>

        ?>

      </ul>
    </div>
    </div>
  </nav>