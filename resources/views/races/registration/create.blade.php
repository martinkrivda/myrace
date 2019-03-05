@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.newregistration') }}
@endsection
@section('contentheader_title')
    {{ trans('title.newregistration') }}
@endsection


@section('main-content')
	<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('race/'.$edition_ID.'/registration/') }}">{{ trans('title.viewallregistrations') }}</a></li>
        <li><a href="{{ URL::to('race/'.$edition_ID.'/registration/create') }}">{{ trans('title.newregistration') }}</a></li>
    </ul>
</nav>
  <div class="row">
    <div class="col-md-6">
      <div class="box box-default">
        <div class="box-header with-border">
          <i aria-hidden="true" class="fa fa-address-card-o"></i>

          <h3 class="box-title">{{ trans('title.newregistration') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @if (count($errors) > 0)
<div class="alert alert-danger">
    There were some problems adding the registration.<br />
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-group">
            {{ Form::label('searchdirectory', trans('title.searchdirectory')) }}
            {{ Form::text('searchdirectory', null,
          array(
            'class'=>'form-control',
            'placeholder'=>trans('title.trytofind'),
            'id' => 'searchdirectory',
            'maxlength' => '255',
            'pattern' => '[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,50}'
          ))}}
          <div id="livesearchrunners" class="position-absolute" style="position: absolute; z-index: 2;"></div>
</div>

{{ Form::open(array('url' => '/registration-data', 'method' => 'POST', 'id' => 'create-registration', 'data-resource' => $edition_ID, 'class' => 'formregistration')) }}
<div class="form-group">
            {{ Form::label('registrationsum', trans('title.reggroup')) }}
            <select id="registrationsum" class="form-control" name="registrationsum">
                  <option selected value="-1">new group of registrations</option>
                    @foreach($registrationsum as $regsummary)
                        <option value="{{$regsummary->regsummary_ID}}">{{$regsummary->name}} - {{$regsummary->email}} - {{$regsummary->regsummary_ID}}</option>
                    @endforeach
            </select>
</div>
<div class="row">
    <div class="col-xs-6">
        <div class="form-group">
            {{ Form::label('firstname', trans('title.firstname')) }}
            {{ Form::text('firstname', null,
          array(
            'class'=>'form-control',
            'placeholder'=>trans('adminlte_lang::message.fillfirstname'),
            'id' => 'firstname',
            'maxlength' => '50',
            'pattern' => '[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,50}',
            'required' => 'required',
          ))}}
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            {{ Form::label('lastname', trans('title.lastname')) }}
            {{ Form::text('lastname', null,
          array(
            'class'=>'form-control',
            'placeholder'=>trans('adminlte_lang::message.filllastname'),
            'id' => 'lastname',
            'maxlength' => '255',
            'pattern' => '[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,255}',
            'required' => 'required',
          ))}}
          <input type="hidden" id="runner_ID" name="runner_ID" pattern="\d{1,10}"
                    class="form-control" maxlength="10" autocomplete="off" value=""/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            {{ Form::label('yearofbirth', trans('title.yearofbirth')) }}
            {{ Form::number('yearofbirth', null,
          array(
            'class'=>'form-control',
            'placeholder'=>trans('title.fillyearofbirth'),
            'id' => 'yearofbirth',
            'max'=> date("Y"),
            'min' => '1900',
            'step' => 1,
            'required' => 'required',
          ))}}
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group">
        {{ Form::label('gender', trans('title.gender')) }}
        {{Form::select('gender', array('male' => trans('title.male'), 'female' => trans('title.female')), null, array(
        'required' => 'required',
        'id' => 'gender',
        'class'=>'form-control',
        ))}}
        </div>
    </div>
    <div class="col-xs-5">
        <div class="form-group">
            {{ Form::label('club', trans('title.club')) }}
            {{ Form::text('club', null,
              array(
                'class'=>'form-control',
                'placeholder'=>trans('title.fillclubo'),
                'id' => 'club',
                'maxlength' => '70',
                'pattern' => '[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ\.]{1,70}',
                'autocomplete' => 'off',
              ))}}
            <input type="hidden" id="club_ID" name="club_ID" pattern="\d{1,10}"
                    class="form-control" maxlength="10" autocomplete="off"/>
         <div id="livesearchclubs"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-8">
        {{ Form::label('email', trans('title.email')) }}
        {{ Form::email('email', null,
          array(
            'class'=>'form-control',
            'placeholder'=>trans('title.fillemailo'),
            'id' => 'email',
            'maxlength' => '255',
          ))}}
    </div>
    <div class="col-xs-4">
        <div class="form-group">
                {{ Form::label('phone', trans('title.phone')) }}
                <input type="tel" id="phone" name="phone"
                    placeholder="{{ trans('title.fillphoneo') }}"
                    class="form-control" maxlength="13" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-4">
        <div class="form-group">
            {{ Form::label('category', trans('title.category')) }}
            {{Form::select('category', $categories, null, array(
                'required' => 'required',
                'id' => 'category',
                'class'=>'form-control',
            ))}}
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group">
            {{ Form::label('entryfee', trans('title.entryfee')) }}
            {{ Form::number('entryfee', null,
                array(
                    'class'=>'form-control',
                    'pattern' => '^\d*(\.\d{0,2})?$',
                    'placeholder'=>trans('title.fillentryfee'),
                    'id' => 'entryfee',
                    'min' => 0,
                    'step'=>'0.01',
                ))}}
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group">
            {{ Form::label('start_nr', trans('title.start_nr')) }}
            <input list="start_nr" name="start_nr" placeholder="{{ trans('title.fillstart_nr') }}" pattern="\d{1,10}" class="form-control"/>
                <datalist id="start_nr">
                    @foreach($freeStartNr as $number)
                        <option value="{{$number->stime_ID}}">{{$number->start_nr}}</option>
                    @endforeach
                </datalist>
        </div>
    </div>
</div>
<div class="form-group">
    {{ Form::label('country', trans('title.country')) }}
    {{Form::select('country', $countries, 'CZ', array(
        'required' => 'required',
        'id' => 'country',
        'class'=>'form-control',
    ))}}
</div>
<div class="form-group">
    {{ Form::label('note', trans('title.note')) }}
    {{ Form::textarea('note', null, ['id' => 'note', 'rows' => 4, 'class'=>'form-control']) }}
</div>
<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            <label >
                <input type="checkbox" name="paid" id="paid" data-toggle="toggle" data-size="mini"> {{trans('title.paid')}}
            </label>
        </div>
    </div>
    <div class="col-xs-5">
        <div class="form-group">
            <label>
                <input type="checkbox" name="notcompeting" id="notcompeting" data-toggle="toggle" data-size="mini"> {{trans('title.notcompeting')}}
            </label>
        </div>
    </div>
</div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {{ Form::submit(trans('title.saveregistration'), array('class' => 'btn btn-primary crud-submit')) }}
    {{ Form::reset(trans('title.reset'), array('class' => 'btn')) }}

    {{ Form::close() }}
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

@endsection
@section('scripts')
    @parent
    <script>
    var edition_ID = {!! json_encode($edition_ID) !!};
    var array = @json($categories);
    </script>
    <script src="/js/custom/registrationAjax.js"></script>
@endsection