@extends('layouts.app')
@section('title','Users')
@section('content_header')
<h1>nurseries</h1>

@stop
@section('content')


    {{ Form::open(['route' => 'dashboard.nursery.store','files'=>'true']) }}
<div class="row">

    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">nursery Info .</h3>
            </div>

            <div class="box-body">
                <div class="row">


                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="name">
                            <span class="text-danger">*</span>
                             Name
                        </label>
                        {{ Form::text('name',old('name'),['id'=>'name','required' => 'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('name') }}</p>
                    </div>



                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="image">
                             image
                        </label>
                        {{ Form::file('image',['id'=>'image','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('image') }}</p>
                    </div>


                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="hour_price">
                            <span class="text-danger">*</span>
                            hour_price
                        </label>
                        {{ Form::number('hour_price',old('hour_price'),['id'=>'v','required' => 'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('hour_price') }}</p>
                    </div>
                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="long">
                            <span class="text-danger">*</span>
                            long
                        </label>
                        {{ Form::number('long',old('long'),['id'=>'long','required' => 'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('long') }}</p>
                    </div>
                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="lat">
                            <span class="text-danger">*</span>
                            lat
                        </label>
                        {{ Form::number('lat',old('lat'),['id'=>'lat','required' => 'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('lat') }}</p>
                    </div>

                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="hint">
                            <span class="text-danger">*</span>
                             hint
                        </label>
                        {{ Form::text('hint',old('hint'),['id'=>'hint','required' => 'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('hint') }}</p>
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
