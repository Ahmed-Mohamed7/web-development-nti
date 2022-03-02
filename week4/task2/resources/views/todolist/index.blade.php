<!DOCTYPE html>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <!-- custom css -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }
        .m-b-1em {
            margin-bottom: 1em;
        }
        .m-l-1em {
            margin-left: 1em;
        }
        .mt0 {
            margin-top: 0;
        }
    </style>

</head>

<body>

    <!-- container -->
    <div class="container">


        <div class="page-header">
            <h1>Read Students </h1>     
            <br>

          @php
            // dd(session()->has('test'));
            echo session()->get('Message');
          @endphp

            <br>



        </div>

        <a href="{{url('/create')}}">+ task</a>   ||     <a href="{{url('/user/logout')}}">+ LogOut</a>

        <table class='table table-hover table-responsive table-bordered'>
            <!-- creating our table heading -->
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>start date</th>
                <th>end date</th>
                <th>image</th>
                <th>action</th>
            </tr>


        @foreach ($data as $value )


            <tr>
                <td>{{ $value->id}}</td>
                <td>{{ $value->title }}</td>
                <td>{{ $value->content}}</td>
                <td>{{ $value->stdate}}</td>
                <td>{{ $value->enddate}}</td>
                <td> <img src=" {{asset('images').'/'. $value->image}}" style="max-height: 100px; max-width:100px"></td>

                <td>
                    <a href='{{url('delete/'.$value->id)}}' class='btn btn-danger m-r-1em'>Delete</a>
                </td>
            </tr>

       @endforeach

            <!-- end table -->
        </table>

    </div>
    <!-- end .container -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- confirm delete record will be here -->

</body>

</html>