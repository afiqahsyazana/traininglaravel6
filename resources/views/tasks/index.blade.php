@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center mb-4">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Well done!</h4>
                    <p>Successfully Added!</p> {{session('status')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            @endif    
            
            <div class="col-md-10">
                <!--Filter Button --->
                <button class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter">
                        
                    Filter
                </button>

                <a class="btn btn-primary" href="/tasks/create" >
                    <span class="oi oi-plus" style="color:white"></span>
                    Create
                </a>
                <a href="/tasks/excel?{{$paramString}}" class="btn btn-success">
                    <span class="oi oi-file" style="color:white"></span>
                    Export
                </a>
                
            </div>
           
            
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">List of tasks</div>

                    <div class="card-body">

                        @if($tasks->isEmpty())
                            <p> There is no tasks</p>
                        @else

                            <table class="table">
                                <thead>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Content</th>
                                    <th>Owner</th>
                                    <th> Email</th>
                                    <th> Action</th>
                                </thead>

                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <!--this part whereto continue numbering of items in table-->
                                            <td>{{($tasks->currentPage() -1) * $tasks->perPage()+ $loop->index+1}}</td>
                                            <td>{{$task->name}}</td>
                                            <td>{{$task->category}}</td>
                                            <td>{{$task->content}}</td>
                                            {{-- this part where task Model go to user table in column name  --}}
                                            <td>{{$task->user->name}}</td>
                                            <td>{{$task->user->email}}</td>
                                            <td>
                                                <a href="/tasks/{{$task->id}}">
                                                    
                                                    <span class="oi oi-eye" title="icon star" aria-hidden="true" style="color:blue"></span>
                                                    </a>
                                                    
                                                    <form action="tasks/{{$task->id}}" method="POST">
                                                    {{method_field('DELETE')}}
                                                    @csrf
                                                    <button type="submit" style="border: none; background: transparent">
                                                        <span class="oi oi-trash"  style="color:red"></span>
                                                    </button>
                                                    </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        <!---this is for pagination -->
                        {{ $tasks->appends((array)$params)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    
      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            
            <div class="modal-body">
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-12">
                        <form action="/tasks" method="GET">
                            <fieldset>
                                <div class="form-group">
                                        <label for=""  class="col-lg-12 control-label">Name</label>
                                        <div class="col-lg-12">
                                            <input name="name" type="text" class="form-control">
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="name" class="col-lg-12 control-label">Owner</label>
                                        <div class="col-lg-12">
                                            {{Form::select('user_id',$input, isset($params->user_id)? $params->user_id: '',['class' => 'form-control'])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-lg-12 control-label">E-mail</label>
                                        <div class="col-lg-12">
                                                {{Form::select('email', $inputEmail, isset($params->email)? $params->email: '',['class' => 'form-control'])}}
                                        </div>
                                    </div>
                        
                                <div class="form-group">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                </div>
                            </fieldset>
                            
                        </form>
                    </div>
                </div>
            </div>

            
@endsection
