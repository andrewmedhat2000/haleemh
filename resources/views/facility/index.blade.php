@extends('layouts.app')
@section('title','User')
@section('content_header')
<h1>facility</h1>

@stop
@section('content')
<div class="row">



    <div class="col-xs-12 col-md-12">

        <a href="{{ route('dashboard.facility.create',['setter'=>$setter_id]) }}" class="btn btn-block btn-primary">
            Add new
        </a>
        <div class="box">

            <div class="box-header">
                <h3 class="box-title">All facilities Info</h3>
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
                            <th>Name</th>
                            <th>space</th>
                            <th>num_of_rooms</th>
                            <th>tax_id</th>
                            <th>rent_contract</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($facilities as $facility)
                        <tr>
                            <td>{{$facility->id}}</td>

                            <td>
                                    {{$facility->name}}
                            </td>
                            <td>
                                {{$facility->space}}
                            </td>
                            <td>
                                {{$facility->num_of_rooms}}
                            </td>
                            <td>
                                <img src="{{$facility->tax_id_url}}" style="max-height: 150px;max-width: 150px;">

                            </td>
                            <td>
                                <img src="{{$facility->rent_contract_url}}" style="max-height: 150px;max-width: 150px;">
                            </td>


                            <td>
                                <div class="d-flex">
                                    <div class="mx-1">
                                        <a class="btn btn-sm btn-primary" href="{{ route('dashboard.facility.edit',$facility->id) }}">
                                            Edit
                                        </a>
                                    </div>


                                    <div class="mx-1">
                                        {{ Form::open(['route' => ['dashboard.facility.destroy',$facility->id] ,'method' => 'DELETE' ,'class' => 'delete-form']) }}
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
