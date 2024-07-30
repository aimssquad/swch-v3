@extends('admin.layouts.default')
@section('title', $management.' '.$pageType)
@section('content')
<section class="body pad15">
    <div class="container">
        <div class="box-white min-h600">
            <div class="bw-heading">
                <a class="btn btn-back" href="{{ \Helper::getCancelbuttonUrl($routePrefix,\Request::get('from')) }}"><i
                        class="fa fa-angle-left"></i>Back</a>
            </div>
            <div class="bw-body">

                <h5 class="heading-md">{{ $pageType.' '. $management }}</h5>
                <!-- Message Start -->
                @include('admin.includes.messages')
                <!-- Message End -->
                {{ Form::open(array('route'=>array($routePrefix.'.update',$id), 'class'=>'form-validate', 'name'=>'', 'autocomplete'=>'off', 'enctype'=>'multipart/form-data')) }}

                <div class="row">
                    <div class="col-12 col-lg-6 col-md-12">
                        <div class="form-group">
                            {!! Form::label('First Name') !!} <strong class="error">*</strong>
                            {{ Form::text('first_name', $record->first_name, array('required','class' => 'form-control','id' => 'first_name','placeholder' => 'Enter First Name','maxlength'=>"50")) }}
                        </div>

                    </div>
                    <div class="col-12 col-lg-6 col-md-12">
                        <div class="form-group">
                            {!! Form::label('Last Name') !!} <strong class="error">*</strong>

                            {{ Form::text('last_name', $record->last_name, array('required','class' => 'form-control','id' => 'last_name','placeholder' => 'Enter Last Name','maxlength'=>"50")) }}
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6 col-md-12">
                        <div class="form-group">
                            {!! Form::label('Email Address') !!} <strong class="error">*</strong>
                            {{ Form::text('email', $record->email, array('required','readonly'=>true,'class' => 'form-control','id' => 'email','placeholder' => 'Email Address','maxlength'=>"50")) }}
                        </div>

                    </div>
                    <div class="col-12 col-lg-6 col-md-12">
                        <div class="form-group">
                            {!! Form::label('Contact Number') !!} <strong class="error">*</strong>
                            {{ Form::text('phone', $record->phone, array('required','class' => 'form-control','id' => 'phone','placeholder' => 'Contact Number','maxlength'=>"20")) }}
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6 col-md-12">
                        <div class="form-group">
                            {!! Form::label('Gender') !!} <strong class="error">*</strong>
                            
                            {{ Form::select('gender',$genders,$record->gender, array('required','class' => 'form-control','id' => 'gender','placeholder' => 'Select Gender')) }}
                           
                            
                        </div>

                    </div>
                    <div class="col-12 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Date of Birth</label> <strong class="error">*</strong>

                            {{ Form::text('dob',  $record->dob!=NULL?date(config('global.PHP_DATE_FORMAT'),strtotime($record->dob)):'', array('required','class' => 'form-control','id' => 'dob','placeholder' => 'Date of Birth','readonly'=>true)) }}
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6 col-md-12">
                        <div class="form-group">
                            {!! Form::label('Location') !!} <strong class="error">*</strong>
                            {{ Form::text('location', $record->location, array('required','class' => 'form-control','id' => 'location','placeholder' => 'Location','maxlength'=>"50")) }}
                        </div>

                    </div>
                    <div class="col-12 col-lg-6 col-md-12">
                        <div class="form-group">
                            {!! Form::label('Permanent Address') !!} <strong class="error">*</strong>
                            {{ Form::textarea('address', $record->address, array('required','rows'=>3,'class' => 'form-control','id' => 'address','placeholder' => 'Permanent Address','maxlength'=>"255")) }}
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6 col-md-12">
                        
                        <div class="form-group">
                            {!! Form::label('Profile Image') !!}
                            {{ Form::file('user_logo', ['class' => 'form-control imagefile','id'=>'user_logo','data-msg-accept'=>"File must be JPG, JPEG or PNG", 'accept'=>"image/x-png,image/jpeg,image/png"]) }}
                            <img  id="imgshow" width='100%'>
                            {{ Form::hidden('imagedata', null, array('id' => 'imagedata')) }}
                        </div>

                        <div class="form-group">
                        @if($record->user_logo!='')
                            <!-- <img src="{{\Helper::getS3Image(config('global.FRONT_USER_PROFILE_IMAGE_PATH').'/'.$record->user_logo)}}" width="100"> -->
                            <img src="{{\Helper::getS3Image($record->user_logo)}}" width="100">
                            
                            
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Date of Joining</label>
                            {{ Form::text('created_at', date(config('global.PHP_DATE_FORMAT'),strtotime($record->created_at)), array('required','readonly'=>true,'class' => 'form-control','id' => 'created_at','placeholder' => 'Date of Joining')) }}
                        </div>

                    </div>
                   
                </div>
                <div class="row">

                    <div class="col-12 col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Biography</label> <strong class="error">*</strong>
                            {{ Form::textarea('bio', $record->bio, array('required','class' => 'form-control','id' => 'bio','placeholder' => 'Biography','maxlength'=>2000)) }}<small>Max 2000 characters</small>
                        </div>

                    </div>
                </div>
                <button type="submit" class="btn btn-capsule btn-green btn-submit" onclick="cropme('imgshow');">Save</button>
                {!! Form::close() !!}

            </div>
        </div>

    </div>

</section>

@endsection

@section('pageScript')

<script type="text/javascript">
$(document).ready(function() {
    $('#dob').datepicker({
        format: 'mm/dd/yyyy',
        endDate: '-18y'
    });
    $("#user_logo").change(function() {
        if (this.files && this.files[0]) {
            if(this.files[0].type.match('image.*'))
            {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.rcrop-preview-wrapper').remove();
                    $('#imgshow').rcrop('destroy');
                    $('#imgshow').removeAttr('src');
                    $('#imgshow').attr('src', e.target.result);
                    $('#imgshow').rcrop({
                        minSize: [200, 200],
                        preserveAspectRatio: true,

                        preview: {
                            display: true,
                            size: [100, 100],
                        }
                    });
                    //$('#btnCrop').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        }
    });
});

function cropme(id) {
    var srcOriginal = $('#' + id).rcrop('getDataURL');
    $('#imagedata').val(srcOriginal);
    console.log(srcOriginal);
    //document.forms[0].submit();
}    
</script>

@endsection