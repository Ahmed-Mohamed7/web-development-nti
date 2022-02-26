<?php 
require './blog.php';

$blog = new Blog;
if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $data =  $blog->showData(1,$id)[0];
    
}
else{
    echo "<script> alert('review added successfully'); window.location.href='./index.php; </script>";
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $update = $blog->edit($id,$_POST,$data['image']);
    // foreach($update as $key => $value){
    //     echo '* '.$key.' : '.$value.'<br>';
    // }
    header("location: ./index.php");
}




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

        <form action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF'])."?id=".$id ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control"  id="exampleInputName" aria-describedby="" name="title" placeholder="Enter Name" value="<?php echo $data['title'] ?>">
            </div>



            <div class="form-group">
                <label for="exampleInputEmail">Content</label>
                <input type="text" class="form-control"  id="exampleInputEmail1" aria-describedby="emailHelp" name="content" placeholder="Enter email" value="<?php echo $data['content'] ?>">
            </div>

            <?php if(isset($data['image'])){ ?>
                <img src="<?php echo 'uploads/'.$data['image'] ?>" style="max-width: 100px; max-height:100px">
            <?php } ?>

            <div class="form-group">
                <label for="exampleInputPassword">image</label>
                <input type="file" name="image">
            </div>



            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>


</body>

</html>