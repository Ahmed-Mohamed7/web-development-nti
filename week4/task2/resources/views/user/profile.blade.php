<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #eee;
        }

        table {
            background-color: #ffffff;
        }

        .flip {
            transform: rotate(90deg);
        }

        th {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <a href="{{ url('todolist')}}" class="btn btn-primary"><< back to tasks</a>
    <h1 class="text-center">welcome , {{$user->name}}</h1>
    <hr class="mt-0 mb-4">

        @if ($errors->any())

            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
       
    <form action="{{ url('user/'.$user->id) }}"  method="POST" enctype="multipart/form-data">
        @csrf
        @method("put")
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <!-- <img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt=""> -->
                    <!-- Profile picture help block-->
                    <img src="{{asset('images').'/'. $user->image }}" alt="" width="200" height="200">

                    <h1 class=" font-italic text-primary my-3">{{$user->name}}</h1>
                    <div class="mb-3">
                        <label class="small mb-1" for="inputEmailAddress">update Image</label>
                        <input  type="file" name="image" >
                    </div>
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <!-- Profile picture upload button-->
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Full Name</label>
                            <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" name="name" value="{{$user->name}}" >
                        </div>
                       
                    
                        <!-- Form Group (email address)-->
                        <div class="mb-3">

                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                            <input class="form-control" id="inputEmailAddress" type="email" name="email" placeholder="Enter your email address" value="{{$user->email}}" >
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (phone number)-->
                           
                            <!-- Form Group (birthday)-->
                            <div class="col-md-6">

                                <label class="small mb-1" for="inputBirthday">Birthday</label>
                                <input class="form-control" id="inputBirthday" type="date" name="bdate" value="{{$user->date}}">
                            </div>
                        </div>

                       
                       
                        <!-- Save changes button-->
                        <button class="btn btn-primary" name="edit" type="submit">Save changes</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div>
</div>

<style type="text/css">
body{
background-color:#f2f6fc;
color:#69707a;
}
.img-account-profile {
    height: 10rem;
}
.rounded-circle {
    border-radius: 50% !important;
}
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
}
.card .card-header {
    font-weight: 500;
}
.card-header:first-child {
    border-radius: 0.35rem 0.35rem 0 0;
}
.card-header {
    padding: 1rem 1.35rem;
    margin-bottom: 0;
    background-color: rgba(33, 40, 50, 0.03);
    border-bottom: 1px solid rgba(33, 40, 50, 0.125);
}
.form-control, .dataTable-input {
    display: block;
    width: 100%;
    padding: 0.875rem 1.125rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1;
    color: #69707a;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #c5ccd6;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}



</style>

<script type="text/javascript">

</script>
<script src="../script.js"></script>
</body>
</html>