<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
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

    <div class="container  bg-light py-5 mt-5">
        <h2>Register User</h2>

        @if ($errors->any())

            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
        echo session()->get('Message');
      @endphp

        <form action="{{ url('user/register') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="exampleInputEmail">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" 
                    name="name" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    name="email" placeholder="Enter email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail">Birth Date</label>
                <input type="date" class="form-control" id="exampleInputEmail1" name="date">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                    placeholder="Password">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Confirm Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="passwordconfirm"
                    placeholder="passwordconfirm">
            </div>

            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>


    <br>






</body>

</html>
