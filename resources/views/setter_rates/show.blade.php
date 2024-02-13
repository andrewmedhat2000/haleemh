@extends('layouts.app')
@section('title','User')
@section('content_header')
<h1>User {{$resource->name}} Info</h1>

@stop
@section('content')
<div class="row">



    <div class="col-xs-12 col-md-12">

        <a href="{{ route('dashboard.users.create') }}" class="btn btn-block btn-primary">
            Add new
        </a>
        <a href="{{ route('dashboard.users.edit',$resource->id) }}" class="btn btn-block btn-primary">
            Edit User
        </a>




        <div class="box">

            <div class="box-header">
                <h3 class="box-title">All User Info</h3>
            </div>

            <div class="box-body">

                <table id="tbl-list-users" data-server="false" class="table table-bordered table-hover">
                    <tbody>

                        <tr>
                            <th class="">
                                <span style="margin-left:30px;">
                                    Name
                                </span>
                            </th>
                            <td>
                                {{$resource->name}}
                            </td>
                        </tr>


                        <tr>
                            <th class="">
                                <span style="margin-left:30px;">
                                    phone
                                </span>
                            </th>
                            <td>
                                {{$resource->phone}}
                            </td>
                        </tr>


                        <tr>
                            <th class="">
                                <span style="margin-left:30px;">
                                    email
                                </span>
                            </th>
                            <td>
                                {{$resource->email}}
                            </td>
                        </tr>


                        <tr>
                            <th class="">
                                <span style="margin-left:30px;">
                                    national_id
                                </span>
                            </th>
                            <td>
                                {{$resource->national_id}}
                            </td>
                        </tr>


                        <tr>
                            <th class="">
                                <span style="margin-left:30px;">
                                    nationality
                                </span>
                            </th>
                            <td>
                                {{$resource->nationality}}
                            </td>
                        </tr>


                        <tr>
                            <th class="">
                                <span style="margin-left:30px;">
                                    address
                                </span>
                            </th>
                            <td>
                                {{$resource->address}}

                            </td>
                        </tr>


                        <tr>
                            <th class="">
                                <span style="margin-left:30px;">
                                    date_of_birth
                                </span>
                            </th>
                            <td>
                               {{$resource->date_of_birth}}
                            </td>

                        </tr>
                        <tr>
                            <th class="">
                                <span style="margin-left:30px;">
                                    gender
                                </span>
                            </th>
                            <td>
                               {{$resource->gender}}
                            </td>

                        </tr>
                        <tr>
                            <th class="">
                                <span style="margin-left:30px;">
                                    date_of_birth
                                </span>
                            </th>
                            <td>
                               {{$resource->date_of_birth}}
                            </td>

                        </tr>


                        <tr>
                            <th class="">
                                <span style="margin-left:30px;">
                                    role
                                </span>
                            </th>
                            <td>
                                {{$resource->role}}
                            </td>
                        </tr>
                        <tr>
                            <th class="">
                                <span style="margin-left:30px;">
                                    image
                                </span>
                            </th>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-group margin-bottom20 col-md-6">
                                        <img src="{{$resource->image_url}}" style="max-height: 150px;max-width: 150px;">
                                    </div>
                                </div>
                            </td>
                        </tr>





                        <tr>
                       

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
