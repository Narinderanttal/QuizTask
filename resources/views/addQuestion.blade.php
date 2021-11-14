@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    
                    <div class="container">
                        <form method="post" action="{{ url('/add-qestion') }}">
                        @csrf
                            <h2>Add Question</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="question_name">Question Name</label>
                                        <input type="text" class="form-control @error('question_name') is-invalid @enderror" name="question_name" placeholder="" id="question_name" value="{{ old('question_name') }}">
                                        @error('question_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="option_one">Option one</label>
                                        <input type="text" class="form-control @error('option_one') is-invalid @enderror" name="option_one" placeholder="" id="option_one" value="{{ old('option_one') }}">
                                        @error('option_one')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            <!--  col-md-6   -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="option_two">Option Two</label>
                                        <input type="text" class="form-control  @error('option_two') is-invalid @enderror" name="option_two" placeholder="" id="option_two" value="{{ old('option_two') }}">
                                        @error('option_two')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            <!--  col-md-6   -->
                            </div>
                            <!--  row   -->


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="option_three">Option three</label>
                                        <input type="text" class="form-control  @error('option_three') is-invalid @enderror" name="option_three" placeholder="" id="option_three" value="{{ old('option_three') }}">
                                        @error('option_three')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            <!--  col-md-6   -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="option_four">Option four</label>
                                        <input type="text" class="form-control  @error('option_four') is-invalid @enderror" name="option_four" placeholder="" id="option_four" value="{{ old('option_four') }}">
                                        @error('option_four')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            <!--  col-md-6   -->
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="right_answer">Right Answer</label>
                                        <input type="text" class="form-control  @error('right_answer') is-invalid @enderror" name="right_answer" placeholder="" id="right_answer" value="{{ old('right_answer') }}">
                                        @error('right_answer')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
