<?php 
require_once '../../header.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../styles.css">
    <title>Events</title>
    <style>
        body {
            background-color: #eee;
        }
    </style>
</head>

<body>

    <h1 class="text-center mt-5 text-primary display-2">Products and Categories</h1>
    <div class="d-flex flex-column mx-auto work-div d-flex con justify-content-center">
        <button type="button" id="btn_5" onclick="location.href='./product/product.php'" class="btn workshop-btn btn-outline-primary my-5">Products</button>
        <button type="button" id="btn_5" onclick="location.href='./category/category.php '" class="btn workshop-btn btn-outline-primary">categories</button>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
</body>

</html>