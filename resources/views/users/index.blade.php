@extends('layouts.app')
@section('title','User')
@section('content_header')
<h1>Users</h1>

@stop
@section('content')
<div class="row">



    <div class="col-xs-12 col-md-12">

        <a href="{{ route('dashboard.users.create') }}" class="btn btn-block btn-primary">
            Add new
        </a>
        <div class="box">

            <div class="box-header">
                <h3 class="box-title">All User Info</h3>
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
                            <th>Email</th>
                            <th>phone</th>
                            <th>national_id</th>
                            <th>nationality</th>
                            <th>address</th>
                            <th>date_of_birth</th>
                            <th>gender</th>
                            <th>image</th>
                            <th>role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>

                            <td>
                                <a href="{{ route('dashboard.users.show',$user->id)}}">
                                    {{$user->name}}
                                </a>
                            </td>
                            <td>{{$user->email}}</td>
                            <td>
                                {{$user->phone}}
                            </td>
                            <td>
                                {{$user->national_id}}
                            </td>
                            <td>
                                {{$user->nationality}}
                            </td>
                            <td>
                                 
                                {{$user->address}}
                            </td>
                            <td>
                                {{$user->date_of_birth}}
                            </td>
                            <td>
                                {{$user->gender}}
                            </td>
                            <td>
                                <img src="{{$user->image_url}}" style="max-height: 150px;max-width: 150px;">

                            </td>

                            <td>
                                {{$user->role}}

                            </td>

                            <td>
                                <div class="d-flex">
                                    <div class="mx-1">
                                        <a class="btn btn-sm btn-primary" href="{{ route('dashboard.users.edit',$user->id) }}">
                                            Edit
                                        </a>
                                    </div>


                                    <div class="mx-1">
                                        {{ Form::open(['route' => ['dashboard.users.destroy',$user->id] ,'method' => 'DELETE' ,'class' => 'delete-form']) }}
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
