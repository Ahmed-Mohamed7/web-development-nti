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
        <h2>add task</h2>

        @if ($errors->any())

            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ url('/store') }}" method="post" enctype="multipart/form-data">

            @csrf


            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" id="exampleInputName" aria-describedby="" name="title"
                    placeholder="Enter Name" >
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">content</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    name="content" placeholder="Enter email" >
            </div>

            <div class="form-group">
                <label for="exampleInputName">Start Date</label>
                <input type="date" class="form-control" id="exampleInputName" aria-describedby="" name="stdate"
                    placeholder="Enter Name" >
            </div>

            <div class="form-group">
                <label for="exampleInputName">End Date </label>
                <input type="date" class="form-control" id="exampleInputName" aria-describedby="" name="enddate"
                    placeholder="Enter Name" >
            </div>

            <div class="form-group">
                <label for="exampleInputName">Image </label>
                <input type="file" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <br>






</body>

</html>