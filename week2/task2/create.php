<?php

// create
require 'connections.php';
require 'helpers.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title =  Clean($_POST['title'], 0);
    $content = Clean($_POST['content'], 0);
    $date = $_POST['date'];

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
    else if(strlen($content) <=50)
        $errors['content'] = errorFormat('content Must be > 50 char');
    
    # validate date   
    $date_test = explode('-', $date);
    if (empty($date))
        $errors['date'] = REQ_ERR;
    else if (!checkdate($date_test[1], $date_test[2], $date_test[0]))
        $errors['date'] = errorFormat('invalid date entered');

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
        $sql = "insert into posts (`title`,`content`,`date`,`image`) values ('$title','$content','$date','$disPath')";
        $op = mysqli_query($conn, $sql);
        if ($op)
            echo "<SCRIPT> 
            alert('data inserted successfully')
            </SCRIPT>";
        else   echo mysqli_error($conn);
    } 
    else
        foreach ($errors as $key => $value) {
            echo $key . "  =>  " . $value . "<br>";
        }
}


/*
   
 create db   (blog)    >>> table [title , content , category ]     
 create connection by php code .... 
*/

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
                <label for="exampleInputPassword">date</label>
                <input type="date" class="form-control" required id="exampleInputPassword1" name="date" >
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