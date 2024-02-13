@extends('layouts.app')
@section('title','Users')
@section('content_header')
<h1>setter_rate</h1>

@stop
@section('content')


{{ Form::open(['route' => ['dashboard.setter_rate.store', ['setter_id'=>$setter]], 'files' => true]) }}
<div class="row">

    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">setter_rate Info .</h3>
            </div>

            <div class="box-body">
                <div class="row">



                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="review">
                            <span class="text-danger">*</span>
                            review
                        </label>
                        {{ Form::text('review',old('review'),['id'=>'review','required' => 'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('review') }}</p>
                    </div>

                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="num_of_stars">
                            <span class="text-danger">*</span>
                            num_of_stars
                        </label>
                        {{ Form::number('num_of_stars',old('num_of_stars'),['id'=>'num_of_stars','required' => 'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('num_of_stars') }}</p>
                    </div>



                  

                </div>

                <br>
                <div class="row">

                    <div class="col-md-2 col-xs-4">
                        <button type="submit" class="btn btn-block btn-primary">
                            Save
                        </button>
                    </div>
                    <div class="col-md-2 col-xs-4">
                        <button type="reset" class="btn btn-block btn-default">
                            Reset
                        </button>
                    </div>

                    {{ Form::close() }}
                </div>


            </div>
        </div>
    </div>


</div>





@stop
