<?php  
require_once "../../connections.php";
require_once "../../header.php";

$rating_Arr = array('Horrible','Bad','Good','Very Good','Excellent');

## get overall average rating
$overall_sql = "select avg(rate) as avg_rate from review";
$overall = mysqli_query($conn, $overall_sql);
if (!$overall)
    echo mysqli_error($conn);
$overall_rate = mysqli_fetch_assoc($overall);

## get reviews
$sql = "SELECT `review`.*,customer.name as c_name, product.name as p_name FROM `review` 
        join customer on `review`.customer_id = customer.id 
        join product on `review`.product_id = product.id 
        ";
$data = mysqli_query($conn, $sql);
if (!$data)
    echo mysqli_error($conn);

## get count of ratings
$reviews_count = mysqli_num_rows($data);

# get num of positive reviews
$positive_sql = "SELECT COUNT(*) AS pos_count FROM review WHERE rate >= 3";
$positive_reviews = mysqli_query($conn, $positive_sql);
if (!$positive_reviews)
    echo mysqli_error($conn);
$positive_reviews = mysqli_fetch_assoc($positive_reviews)['pos_count'];
$positive_reviews /= $reviews_count;
$positive_reviews =round($positive_reviews,2) *100;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/book_style.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container-fluid px-0 py-5 mx-auto">
        <h1 class=" text-center mb-4 text-primary">Reviews Management </h1>
        <div class="row justify-content-center mx-0 mx-md-auto">
            <div class="col-lg-10 col-md-11 px-1 px-sm-2">
                <div class="card border-0 px-3">
                    <!-- top row -->
                    <div class="d-flex row py-5 px-5 bg-light">
                        <div class="green-tab p-2 px-3 mx-2">
                            <p class="sm-text mb-0">OVERALL RATING</p>
                            <h4><?php echo round($overall_rate['avg_rate'],1) ?></h4>
                        </div>
                        <div class="white-tab p-2 mx-2 text-muted">
                            <p class="sm-text mb-0">ALL REVIEWS</p>
                            <h4><?php echo $reviews_count ?></h4>
                        </div>
                        <div class="white-tab p-2 mx-2">
                            <p class="sm-text mb-0 text-muted">POSITIVE REVIEWS</p>
                            <h4 class="green-text"><?php echo $positive_reviews  ?>%</h4>
                        </div>
                    </div> <!-- middle row -->
                    <?php while ($row = mysqli_fetch_assoc($data)) { ?>

                    <div class="review mx-5 my-2">
                        <div class="row d-flex">
                            <div class="profile-pic"><img src="https://i.imgur.com/Mcd6HIg.jpg" width="60px" height="60px"></div>
                            <div class="d-flex flex-column pl-3">
                                <h4><?php echo $row['c_name'] ?></h4>
                                <p class="grey-text" sty>30 min ago</p>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="fa fa-cirdcle green-dot my-auto rating-dot"></div>
                            <div class="green-text">
                                <h5 class="mb-0">rating : <?php echo $row['rate'] ?>/5 <span class="ml-2"><?php echo $rating_Arr[$row['rate'] - 1] ?></span></h5>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <p><?php echo $row['description'] ?></p>
                        </div>
                        <div class="row pb-3">
                            <?php echo '<button class="btn btn-danger ml-3"><a class="text-white" href="./delete.php?cid='.$row['customer_id'].'&pid='.$row['product_id'].'">Delete</a></button>'?>
                        </div>
                        <hr>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>

</html>