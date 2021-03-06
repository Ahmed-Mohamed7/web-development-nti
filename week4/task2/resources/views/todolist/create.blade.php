<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Task</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<style>
    body{
        background: rgb(74, 74, 248);
    }
</style>

<body>







    <div class="container mt-5 py-5 bg-light">
        <h2 class="text-center">Add task</h2>

        @if ($errors->any())

            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ url('todolist') }}" method="post" enctype="multipart/form-data">

            @csrf


            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" id="exampleInputName" aria-describedby="" name="title"
                    placeholder="Enter title" >
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">content</label>
                <input type="text" class="form-control" id="exampleInputEmail1"
                    name="content" placeholder="Enter content" >
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