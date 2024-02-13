@extends('layouts.app')
@section('title','Users')
@section('content_header')
<h1>Users</h1>

@stop
@section('content')


    {{ Form::open(['route' => 'dashboard.setters.store','files'=>'true']) }}
<div class="row">

    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Setter Info .</h3>
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
                        <label class="control-label" for="email">
                            <span class="text-danger">*</span>
                            Email
                        </label>
                        {{ Form::email('email',old('email'),['id'=>'email','required' => 'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('email') }}</p>
                    </div>

                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="phone">
                            <span class="text-danger">*</span>
                            Phone
                        </label>
                        {{ Form::text('phone',old('phone'),['id'=>'phone','required' => 'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('phone') }}</p>
                    </div>
                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="national_id">
                            national_id
                        </label>
                        {{ Form::text('national_id',old('national_id'),['id'=>'national_id','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('national_id') }}</p>
                    </div>

                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="nationality">
                            nationality
                        </label>
                        {{ Form::text('nationality',old('nationality'),['id'=>'nationality','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('nationality') }}</p>
                    </div>

                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="address">
                            address
                        </label>
                        {{ Form::text('address',old('address'),['id'=>'address','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('address') }}</p>
                    </div>

                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="date_of_birth">
                            date_of_birth
                        </label>
                        {{ Form::date('date_of_birth', old('date_of_birth'), ['id' => 'date_of_birth', 'class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('date_of_birth') }}</p>
                    </div>

                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="gender">
                            gender
                        </label>
                        {{ Form::select('gender', ['male' => 'male', 'female' => 'female'], old('gender'), ['id' => 'gender', 'class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('gender') }}</p>
                    </div>


                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="image">
                             image
                        </label>
                        {{ Form::file('image',['id'=>'image','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('image') }}</p>
                    </div>


                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="role">
                            role
                        </label>
                        {{ Form::select('role', ['user' => 'user', 'admin' => 'admin'], old('role'), ['id' => 'role', 'class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('role') }}</p>
                    </div>




                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="password">
                            <span class="text-danger">*</span>
                            Password
                        </label>
                        {{ Form::password('password',['id'=>'password','required'=>'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('password') }}</p>
                    </div>


                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="password_confirmation">
                            <span class="text-danger">*</span>
                            Confirm-password
                        </label>
                        {{ Form::password('password_confirmation',['id'=>'password_confirmation','required'=>'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('password_confirmation') }}</p>
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

                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="nursery_id">
                            <span class="text-danger">*</span>
                            nursery
                        </label>
                        {!! Form::select('nursery_id',$nurseries, null, ['class' => 'form-control select2', 'id' => 'nursery_id', 'placeholder' => "NONE"]); !!}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('nursery_id') }}</p>
                    </div>
                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="Professional_life">
                            Professional_life
                        </label>
                        {{ Form::select('Professional_life', ['freelance' => 'freelance', 'nursery' => 'nursery'], old('Professional_life'), ['id' => 'Professional_life','required' => 'required', 'class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('Professional_life') }}</p>
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
