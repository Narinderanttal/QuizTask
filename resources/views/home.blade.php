@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                @if (Session::has('messages'))
                    <div class="alert alert-danger">{{ Session::get('messages') }}</div>
                @endif
                <div class="card-header">Question List</div>
                <div class="card-body">
                    <div class="text-right">
                        <a class="btn btn-primary" href="{{ url('/add-qestion') }}">Add question</a>
                    </div>
                    <br>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Question Name</th>
                            <th>Option One</th>
                            <th>Option Two</th>
                            <th>Option Three</th>
                            <th>Option four</th>
                            <th>Right Option</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                            @if(count($questions)>0)
                                @foreach($questions as $qvalue)
                                    <tr>
                                        <th scope="row">{{$qvalue->id}}</th>
                                        <td>{{$qvalue->question_name}}</td>
                                        <td>{{$qvalue->option_one}}</td>
                                        <td>{{$qvalue->option_two}}</td>
                                        <td>{{$qvalue->option_three }}</td>
                                        <td>{{$qvalue->option_four}}</td>
                                        <td>{{$qvalue->right_answer}}</td>
                                        <td>
                                            <a class="btn btn-warning btn-sm" href="{{ url('/show') }}/{{$qvalue->id}}">Edit</a>
                                            <a class="btn btn-danger btn-sm" href="{{ url('/delete-qestion') }}/{{$qvalue->id}}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                 <tr>
                                    <th>Record Not Found</th>
                                 </tr>  
                            @endif
                      </tbody>
                    </table>







                </div>
            </div>
        </div>
    </div>
</div>
@endsection
