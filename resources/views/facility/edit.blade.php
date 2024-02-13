@extends('layouts.app')
@section('title','Users')
@section('content_header')
<h1>facility</h1>

@stop
@section('content')


{{ Form::open(['route' => ['dashboard.facility.update',$facility->id],'method' => 'PATCH','files'=>'true','enctype'=>'multipart/form-data']) }}
{{ Form::hidden('facility_id',$facility->id,['id'=>'facility_id','class' => 'form-control']) }}

<div class="row">

    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">facility Info .</h3>
            </div>

            <div class="box-body">
                <div class="row">

                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="space">
                            <span class="text-danger">*</span>
                             space
                        </label>
                        {{ Form::text('space',old('space'),['id'=>'space','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('space') }}</p>
                    </div>

                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="num_of_rooms">
                            <span class="text-danger">*</span>
                            num_of_rooms
                        </label>
                        {{ Form::number('num_of_rooms',old('num_of_rooms'),['id'=>'num_of_rooms','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('num_of_rooms') }}</p>
                    </div>


                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="tax_id">
                            tax_id
                        </label>
                        {{ Form::file('tax_id',['id'=>'tax_id','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('tax_id') }}</p>
                    </div>
                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="rent_contract">
                            rent_contract
                        </label>
                        {{ Form::file('rent_contract',['id'=>'rent_contract','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('rent_contract') }}</p>
                    </div>
                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="name">
                            <span class="text-danger">*</span>
                             Name
                        </label>
                        {{ Form::text('name',old('name'),['id'=>'name','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('name') }}</p>
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
