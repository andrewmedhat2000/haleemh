@extends('layouts.app')
@section('title','User')
@section('content_header')
<h1>Setters</h1>

@stop
@section('content')
<div class="row">



    <div class="col-xs-12 col-md-12">

        <a href="{{ route('dashboard.setters.create') }}" class="btn btn-block btn-primary">
            Add new
        </a>
        <div class="box">

            <div class="box-header">
                <h3 class="box-title">All Setter Info</h3>
            </div>



            @if (session('alert'))
            <div class="alert alert-warning">
                {{ session('alert') }}
            </div>
            @endif
            <div class="box-body table-responsive">

                <table id="tbl-list-users" data-server="false" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>hour_price</th>
                            <th>long</th>
                            <th>lat</th>
                            <th>hint</th>
                            <th>Professional_life</th>
                            <th>completed_orders</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($setters as $setter)
                        <tr>
                            <td>{{$setter->id}}</td>


                            <td>{{$setter->hour_price}}</td>
                            <td>
                                {{$setter->long}}
                            </td>
                            <td>
                                {{$setter->lat}}
                            </td>
                            <td>
                                {{$setter->hint}}
                            </td>
                            <td>

                                {{$setter->Professional_life}}
                            </td>
                            <td>
                                {{$setter->completed_orders}}
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="mx-1">
                                        <a class="btn btn-sm btn-primary" href="{{ route('dashboard.setters.edit',$setter->id) }}">
                                            Edit
                                        </a>
                                    </div>
                                    <div class="mx-1">
                                        {{ Form::open(['route' => ['dashboard.setters.destroy',$setter->id] ,'method' => 'DELETE' ,'class' => 'delete-form']) }}
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                        {{ Form::close() }}
                                    </div>
                                    <div class="mx-1">
                                        {{ Form::open(['route' => ['dashboard.setters.user_details'] ,'method' => 'POST' ,'class' => 'submit-form']) }}
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <input type="hidden" name="data" value="<?php echo $setter->id?>">

                                            user_details
                                        </button>
                                        {{ Form::close() }}
                                    </div>
                                    <div class="mx-1">
                                        {{ Form::open(['route' => ['dashboard.setters.room_details'] ,'method' => 'POST' ,'class' => 'submit-form']) }}
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <input type="hidden" name="data" value="<?php echo $setter->id?>">

                                            room_details
                                        </button>
                                        {{ Form::close() }}
                                    </div>
                                    <div class="mx-1">
                                        {{ Form::open(['route' => ['dashboard.setters.certificate_details'] ,'method' => 'POST' ,'class' => 'submit-form']) }}
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <input type="hidden" name="data" value="<?php echo $setter->id?>">
                                            certificates_details
                                        </button>
                                        {{ Form::close() }}
                                    </div>
                                    <div class="mx-1">
                                        {{ Form::open(['route' => ['dashboard.setters.facility_details'] ,'method' => 'POST' ,'class' => 'submit-form']) }}
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <input type="hidden" name="data" value="<?php echo $setter->id?>">
                                            facility_details
                                        </button>
                                        {{ Form::close() }}
                                    </div>
                                    <div class="mx-1">
                                        {{ Form::open(['route' => ['dashboard.setters.nursery_details'] ,'method' => 'POST' ,'class' => 'submit-form']) }}
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <input type="hidden" name="data" value="<?php echo $setter->id?>">
                                            nursery_details
                                        </button>
                                        {{ Form::close() }}
                                    </div>
                                    <div class="mx-1">
                                        {{ Form::open(['route' => ['dashboard.setters.setter_rate_details'] ,'method' => 'POST' ,'class' => 'submit-form']) }}
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <input type="hidden" name="data" value="<?php echo $setter->id?>">
                                            setter_rate_details
                                        </button>
                                        {{ Form::close() }}
                                    </div>

                                </div>


                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

@stop

@section('js')
{{--<script>--}}
{{--$(function () {--}}
{{--$('#tbl-list-users').DataTable()--}}
{{--})--}}
{{--</script>--}}
@stop
