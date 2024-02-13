@extends('layouts.app')
@section('title','User')
@section('content_header')
<h1>setter_rate</h1>

@stop
@section('content')
<div class="row">



    <div class="col-xs-12 col-md-12">

        <a href="{{ route('dashboard.setter_rate.create',['setter'=>$setter_id]) }}" class="btn btn-block btn-primary">
            Add new
        </a>
        <div class="box">

            <div class="box-header">
                <h3 class="box-title">All setter_rates Info</h3>
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
                            <th>num_of_stars</th>
                            <th>review</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($setter_rates as $setter_rate)
                        <tr>
                            <td>{{$setter_rate->id}}</td>

                            <td>
                                    {{$setter_rate->num_of_stars}}
                            </td>
                            <td>
                                {{$setter_rate->review}}
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="mx-1">
                                        <a class="btn btn-sm btn-primary" href="{{ route('dashboard.setter_rate.edit',$setter_rate->id) }}">
                                            Edit
                                        </a>
                                    </div>


                                    <div class="mx-1">
                                        {{ Form::open(['route' => ['dashboard.setter_rate.destroy',$setter_rate->id] ,'method' => 'DELETE' ,'class' => 'delete-form']) }}
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
