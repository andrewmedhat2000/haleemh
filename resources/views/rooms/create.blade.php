@extends('layouts.app')
@section('section-title')
<div class="row">
    <div class="col-md-4 col-sm-12">
        <h3 class="section-title">Create new room</h3>
    </div>
</div>
@stop
@section('content')
{{ Form::open(['route' => ['dashboard.rooms.store', ['setter_id'=>$setter]], 'files' => true]) }}
<div class="row">
    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">room Info.</h3>
            </div>

            <div class="box-body">
                <div class="row">

                    <div class="form-group margin-bottom20 col-md-6" id="name">
                        <label class="control-label" for="name">
                            <span class="text-danger">*</span>
                            name
                        </label>
                        {{ Form::text('name',old('name'),['id'=>'name','required'=>'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('name') }}</p>
                    </div>
                    <div class="form-group margin-bottom20 col-md-6">
                        <label class="control-label" for="facility_id">
                            <span class="text-danger">*</span>
                            facility
                        </label>
                        {!! Form::select('facility_id',$facility, null, ['class' => 'form-control select2', 'id' => 'facility_id', 'placeholder' => "NONE"]); !!}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('facility_id') }}</p>
                    </div>


                    <div class="form-group margin-bottom20 col-md-12">
                        <label class="control-label" for="images">
                            Image
                        </label>
                        {{ Form::file('images[]',['id'=>'images','required'=>'required','class' => 'form-control']) }}
                        <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('images') }}</p>
                    </div>


                    <div class="form-group margin-bottom20 col-md-12">
                        <label class="control-label">
                            Add Images
                            <button type="button" onclick="add_file()" class="btn btn-primary btn-sm">+ Add

                                More</button>
                        </label>
                    </div>
                    <div id="addfileDiv">
                    </div>




                    <div id="addfileDivTemplate" style="display:none;">
                        <div class="row">
                            <div class="form-group margin-bottom20 col-md-12">
                                <label class="control-label" for="images">
                                    Image
                                </label>
                                {{ Form::file('images[]',['id'=>'images','class' => 'form-control']) }}
                                <p class="text-danger" style="margin-bottom: 0;">{{ $errors->first('images') }}</p>
                            </div>

                        </div>
                    </div>


                </div>



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

<script type="text/javascript">
    function add_file() {
            var template = $('#addfileDivTemplate').html();
            $('#addfileDiv').append(template);
        }

</script>

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $('.tags').select2({
            placeholder: 'select',
        });
</script>



@stop
