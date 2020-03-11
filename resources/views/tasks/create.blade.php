@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Create Task
                </div>
                <div class="card-body">
                    <form action="/tasks/create" method="POST">
                        @csrf
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control"name="name">
                    </div>
                    <div class="form-group">
                        <label for="">Content</label>
                        <textarea name="content" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Owner</label>
                            {{Form::select('user_id',$input, isset($params->user_id)? $params->user_id: '',['class' => 'form-control'])}}
                                  
                    </div>

                    <button class="btn btn-primary" type="submit">
                        Submit
                    </button>



                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection