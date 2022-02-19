<?php

// create
require 'connections.php';
require 'helpers.php';


if(!isset($_SESSION['user_id']))
{
    echo "<script> alert('you should register first'); window.location.href='./login.php'; </script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title =  Clean($_POST['title'], 0);
    $content = Clean($_POST['content'], 0);
    $stDate = $_POST['st_date'];
    $endDate = $_POST['end_date'];

    $errors = [];



    # validate title    
    if (empty($title))
        $errors['title'] = REQ_ERR;
    else if (!ctype_alpha($title))
        $errors['title'] = errorFormat('title Must be string');

    # validate content    
    if (empty($content))
        $errors['content'] = REQ_ERR;
    else if (!ctype_alpha($content))
        $errors['content'] = errorFormat('content Must be string');
    else if(strlen($content) <=10)
        $errors['content'] = errorFormat('content Must be > 50 char');
    
    # validate st_date   
    $date_test = explode('-', $stDate);
    if (empty($stDate))
        $errors['st_date'] = REQ_ERR;
    else if (!checkdate($date_test[1], $date_test[2], $date_test[0]))
        $errors['st_date'] = errorFormat('invalid date entered');

    #validate end_data
    $date_test = explode('-', $endDate);
    if (empty($endDate))
        $errors['end_date'] = REQ_ERR;
    else if (!checkdate($date_test[1], $date_test[2], $date_test[0]))
        $errors['end_date'] = errorFormat('invalid date entered');

    if(!CompareDate($stDate,$endDate))
        $errors['date'] = errorFormat('end date must be > start date');

    #validate image
    if (!empty($_FILES['image']['name'])) {
        $imgName  = $_FILES['image']['name'];
        $imgTemp  = $_FILES['image']['tmp_name'];
        $imgType  = $_FILES['image']['type'];
        $imgSize  = $_FILES['image']['size'];

        $allowedExtensions = ['png', 'jpg', 'jfif', 'jpeg'];
        $tempName = explode('.', $imgName);
        $imgExtension =  strtolower(end($tempName));

        if ($imgSize > MAX_UPLOAD_SIZE)
            $errors['image'] = 'max upload size 5MB';
        else if (!in_array($imgExtension, $allowedExtensions))
            $errors['image'] = 'Invalid image extension';
        else {
            $imgName = time() . rand() . $imgName;
            $disPath = 'uploads/' . $imgName;
            if (!move_uploaded_file($imgTemp, $disPath))
                $errors['image'] = 'Invalid image extension';
            else
                $_SESSION['image'] = $disPath;
        }
    } else {
        $errors['image'] = REQ_ERR;
    }



    #check for errors
    if (count($errors) == 0) {
        $id = $_SESSION['user_id'];
        $sql = "insert into todolist (`title`,`content`,`stdate`,`enddate`,`image`,`user_id`) values ('$title','$content','$stDate','$endDate','$disPath',$id)";
        $op = mysqli_query($conn, $sql);
        if ($op)
            echo ("<script LANGUAGE='JavaScript'>
            window.alert('data inserted successfully');
            window.location.href='./index.php';
            </script>");
        else   echo mysqli_error($conn);
    } 
    else
        foreach ($errors as $key => $value) {
            echo "<br>".$key."  :  ".$value."<br>";
        }
}

    mysqli_close($conn);

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Register</h2>

        <form action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
            

            <div class="form-group">
                <label for="exampleInputName">title</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="title" placeholder="Enter title">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">content</label>
                <input type="text" class="form-control" required id="exampleInputEmail1"  name="content" placeholder="Enter content">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">start date</label>
                <input type="date" class="form-control" required id="exampleInputPassword1" name="st_date" >
            </div>
            <div class="form-group">
                <label for="exampleInputPassword">end date</label>
                <input type="date" class="form-control" required id="exampleInputPassword1" name="end_date" >
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Image</label>
                <input type="file" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>


</body>

</html>