@extends('layouts.app')
@section('title','Users')
@section('content_header')
<h1>Users</h1>

@stop
@section('content')


{{ Form::open(['route' => ['dashboard.certificate.store', ['setter_id'=>$setter]], 'files' => true]) }}
<div class="row">

    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">certificate Info .</h3>
            </div>

            <div class="box-body">
                <div class="row">


                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="certificate_name">
                            <span class="text-danger">*</span>
                             Name
                        </label>
                        {{ Form::text('certificate_name',old('certificate_name'),['id'=>'certificate_name','required' => 'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('certificate_name') }}</p>
                    </div>




                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="image">
                             image
                        </label>
                        {{ Form::file('image',['id'=>'image','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('image') }}</p>
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
