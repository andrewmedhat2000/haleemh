@extends('layouts.app')
@section('title','User')
@section('content_header')
<h1>Users</h1>

@stop
@section('content')
<div class="row">



    <div class="col-xs-12 col-md-12">

        <a href="{{ route('dashboard.nursery.create') }}" class="btn btn-block btn-primary">
            Add new
        </a>
        <div class="box">

            <div class="box-header">
                <h3 class="box-title">All nursery Info</h3>
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
                            <th>name</th>
                            <th>iamge</th>
                            <th>hour_price</th>
                            <th>long</th>
                            <th>lat</th>
                            <th>hint</th>
                            <th>completed_orders</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nurseries as $nursery)
                        <tr>
                            <td>{{$nursery->id}}</td>
                            <td>{{$nursery->name}}</td>
                            <td>
                                <img src="{{$nursery->image_url}}" style="max-height: 150px;max-width: 150px;">

                            </td>

                            <td>{{$nursery->hour_price}}</td>
                            <td>
                                {{$nursery->long}}
                            </td>
                            <td>
                                {{$nursery->lat}}
                            </td>
                            <td>
                                {{$nursery->hint}}
                            </td>

                            <td>
                                {{$nursery->completed_orders}}
                            </td>

                            <td>
                                <div class="d-flex">
                                    <div class="mx-1">
                                        <a class="btn btn-sm btn-primary" href="{{ route('dashboard.nursery.edit',$nursery->id) }}">
                                            Edit
                                        </a>
                                    </div>
                                    <div class="mx-1">
                                        {{ Form::open(['route' => ['dashboard.nursery.destroy',$nursery->id] ,'method' => 'DELETE' ,'class' => 'delete-form']) }}
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Delete
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
