

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
      
        <form action="./validate.php" method="post"  enctype="multipart/form-data" >

            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" id="exampleInputName" aria-describedby=""   name="name" placeholder="Enter name">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">Email</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword" aria-describedby="emailHelp" name="password" placeholder="">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail">Address</label>
                <input type="text" class="form-control" id="exampleInputAddress" aria-describedby="emailHelp" name="address" placeholder="">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail">Gender</label>
                <select class="form-control"  name="gender" >
                    <option value="male" selected>male</option>
                    <option value="female" >female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail">linkedinUrl</label>
                <input type="text" class="form-control" id="exampleInputUrl" aria-describedby="emailHelp" name="linkedinUrl" placeholder="">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Image</label>
                <input type="file" name="image">
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <br>



</body>






</html>