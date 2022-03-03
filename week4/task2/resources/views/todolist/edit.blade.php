<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<style>
    body{
        background: rgb(74, 74, 248);
    }
</style>
</head>

<body>







    <div class="container bg-light mt-5 pb-4">
        <h1 class="text-center text-primary my-5 display-4">Edit Task</h1>
        <a href="{{ url('todolist')}}" class="btn btn-primary"><< back to tasks</a><hr>


        @if ($errors->any())

            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ url('todolist/'.$data->id) }}" method="post" enctype="multipart/form-data">

            @csrf
            @method("put")


            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" id="exampleInputName" aria-describedby="" name="title"
                    placeholder="Enter Title" value="{{ $data->title }}">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">Content</label>
                <textarea name="content" class="form-control" id="" cols="30"
                    rows="2">  {{ $data->content }}  </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">start date</label>
                <input type="date" class="form-control" id="exampleInputName" aria-describedby="" name="stdate"
                placeholder="Enter Title" value="{{ $data->stdate }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">end date</label>
                <input type="date" class="form-control" id="exampleInputName" aria-describedby="" name="enddate"
                value="{{ $data->enddate }}">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Image</label>
                <input type="file" id="exampleInputPassword1" name="image">
            </div>
            <p>

                <img src="{{asset('images').'/'. $data->image }}" alt="" width="200" height="200">

            </p>

            <div class="row">

                <button type="submit" class="btn btn-success text-center mx-auto py-2 px-5">save</button>
            </div>
        </form>
    </div>


    <br>






</body>

</html>