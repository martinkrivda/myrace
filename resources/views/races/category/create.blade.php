@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.createcategory') }}
@endsection
@section('contentheader_title')
    {{ trans('title.createcategory') }}
@endsection


@section('main-content')
<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('race/'.$edition_ID.'/category/') }}">{{ trans('title.viewallcategories') }}</a></li>
        <li><a href="{{ URL::to('race/'.$edition_ID.'/category/create') }}">{{ trans('title.createcategory') }}</a></li>
    </ul>
</nav>
  <div class="row">
    <div class="col-md-6">
      <div class="box box-default">
        <div class="box-header with-border">
          <i aria-hidden="true" class="fa fa-newspaper-o"></i>

          <h3 class="box-title">{{ trans('title.createcategory') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @if (count($errors) > 0)
<div class="alert alert-danger">
    There were some problems adding the category.<br />
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{ Form::open(array('url' => 'race/'.$edition_ID.'/category')) }}

    <div class="form-group">
        {{ Form::label('categoryname', trans('title.name')) }}
        {{ Form::text('categoryname', null,
      array(
        'class'=>'form-control',
        'placeholder'=>trans('title.fillCatName'),
        'id' => 'categoryname',
        'maxlength' => '30',
        'pattern' => '[a-zA-Z0-9 \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉĚÚŮ\.]{1,30}',
        'required' => 'required',
      ))}}
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
            {{ Form::label('course', trans('title.course')) }}
            {{Form::select('course', $courses, '', array(
            'id' => 'courses',
            'class'=>'form-control',
            'required' => 'required',
            ))}}
            </div>
        </div>
    <div class="col-xs-6">
    <div class="form-group">
        {{ Form::label('gender', trans('title.gender')) }}
        {{Form::select('gender', array('male' => trans('title.male'), 'female' => trans('title.female')), null, array(
        'required' => 'required',
        'id' => 'gender',
        'class'=>'form-control',
        ))}}
    </div>
</div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
            {{ Form::label('length', trans('title.length')) }}
            {{ Form::number('length', null,
                array(
                    'class'=>'form-control',
                    'placeholder'=>trans('title.filllength'),
                    'id' => 'length',
                    'min' => 1,
                    'max' => 2147483647,
                    'step'=>'1',
                ))}}
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
            {{ Form::label('climb', trans('title.climb')) }}
            {{ Form::number('climb', null,
                array(
                    'class'=>'form-control',
                    'placeholder'=>trans('title.fillclimb'),
                    'id' => 'climb',
                    'min' => 1,
                    'max' => 2147483647,
                    'step'=>'1',
                ))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
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
        <div class="col-xs-6">
            <div class="form-group">
            {{ Form::label('currency', trans('title.currency')) }}
            {{Form::select('currency', $currencies, 'CZK', array(
            'id' => 'currency',
            'class'=>'form-control',
            ))}}
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="starttime" class=" form-control-label">{{ trans('title.starttime') }}</label><input type="datetime-local"
            id="starttime" name="starttime"
            placeholder="{{ trans('title.fillstarttime') }}"
            class="form-control"/>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
            {{ Form::label('sinterval', trans('title.sinterval')) }}
            {{ Form::number('sinterval', null,
                array(
                    'class'=>'form-control',
                    'placeholder'=>trans('title.fillsinterval'),
                    'id' => 'sinterval',
                    'min' => 0,
                    'max' => 2147483647,
                    'step'=>'0.5',
                ))}}
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group">
            {{ Form::label('timelimit', trans('title.timelimit')) }}
            {{ Form::number('timelimit', null,
                array(
                    'class'=>'form-control',
                    'placeholder'=>trans('title.filltimelimit'),
                    'id' => 'timelimit',
                    'min' => 0,
                    'max' => 2147483647,
                    'step'=>'1',
                ))}}
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group">
            {{ Form::label('capacity', trans('title.capacity')) }}
            {{ Form::number('capacity', null,
                array(
                    'class'=>'form-control',
                    'placeholder'=>trans('title.fillcapacity'),
                    'id' => 'capacity',
                    'min' => 0,
                    'max' => 2147483647,
                    'step'=>'1',
                ))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2">
            <div class="form-group">
            {{ Form::label('checkage', trans('title.checkage')) }}
            {{ Form::checkbox('checkage', '1', false,
                array(
                    'title' => 'Check runner\'s age.',
                    'id' => 'checkage',

                ))}}
            </div>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
            {{ Form::label('birthfrom', trans('title.birthfrom')) }}
            {{ Form::number('birthfrom', null,
                array(
                    'class'=>'form-control',
                    'placeholder'=>trans('title.fillyearofbirth'),
                    'id' => 'birthfrom',
                    'min' => 1900,
                    'max' => date("Y"),
                    'step'=>'1',
                ))}}
            </div>
        </div>
        <div class="col-xs-5">
            <div class="form-group">
            {{ Form::label('birthto', trans('title.birthto')) }}
            {{ Form::number('birthto', null,
                array(
                    'class'=>'form-control',
                    'placeholder'=>trans('title.fillyearofbirth'),
                    'id' => 'birthto',
                    'min' => 1900,
                    'max' => date("Y"),
                    'step'=>'1',
                ))}}
            </div>
        </div>
    </div>

    {{ Form::submit(trans('title.addcategory'), array('class' => 'btn btn-primary')) }}
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
