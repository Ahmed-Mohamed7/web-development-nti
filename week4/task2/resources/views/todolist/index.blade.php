<!DOCTYPE html>
<html>

<head>
    <title>todolist</title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

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
    <div class="container py-5">


        <div class="page-header">
            <h1 class="text-center text-primary display-4">Task List </h1>     
            <hr>

        

            <br>



        </div>
        <div  style="margin-bottom:20px">
            <a class="btn btn-primary mr-3" href="{{url('todolist/create')}}">+ add task</a>  
            <a class="btn btn-primary mr-3" href="{{url('/user').'/'.auth()->user()->id}}">View Profile</a>  
            <a class="btn btn-danger ml-4" href="{{url('/user/logout')}}">+ LogOut</a>
        </div>
        <h3 class="text-danger">
        @php
         echo session()->get('Message');  
         $index = 1; 
         @endphp
         </h1> 
        <table class='table table-hover table-responsive table-bordered'>
            <!-- creating our table heading -->
            <tr class="bg-warning">
                <th>#</th>
                <th style="width: 10%">Title</th>
                <th style="width: 30%">Content</th>
                <th style="width: 10%">start date</th>
                <th style="width: 10%">end date</th>
                <th style="width: 20%">image</th>
                <th style="width: 20%">action</th>
            </tr>

        
        @foreach ($data as $value )


            <tr  >
                <td>{{ $index++}}</td>
                <td>{{ $value->title }}</td>
                <td style="max-width: 415px;  word-wrap: break-word;">{{ $value->content}}</td>
                <td>{{ $value->stdate}}</td>
                <td>{{ $value->enddate}}</td>
                <td> <img src=" {{asset('images').'/'. $value->image}}" style="max-height: 150px; max-width:150px"></td>

                <td>
                    <a href='' data-toggle="modal" data-target="#modal_single_del{{ $value->id}}" class='btn btn-danger mb-2 mr-3'>Remove </a>               
                        <a href='{{url('todolist/'.$value->id.'/edit')}}' class='btn btn-primary'>Edit</a>
                </td>
            </tr>

            <div class="modal" id="modal_single_del{{ $value->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">delete confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                       </button>
                        </div>

                        <div class="modal-body">
                          Remove   {{$value->title}} !!!!
                        </div>
                        <div class="modal-footer">
                            <form action="{{url('/todolist/'.$value->id)}}" method="post">

                                @csrf
                                @method('delete')

                                <div class="not-empty-record">
                                    <button type="submit" class="btn btn-primary">Delete</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
       @endforeach

            <!-- end table -->
        </table>

    </div>
    <!-- end .container -->
   
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- confirm delete record will be here -->

</body>

</html>