@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.createtag') }}
@endsection
@section('contentheader_title')
    {{ trans('title.createtag') }}
@endsection


@section('main-content')
<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('tags') }}">{{ trans('title.viewalltags') }}</a></li>
        <li><a href="{{ URL::to('tags/create') }}">{{ trans('title.createtag') }}</a></li>
    </ul>
</nav>
  <div class="row">
    <div class="col-md-6">
      <div class="box box-default">
        <div class="box-header with-border">
          <i class="fa fa-tags" aria-hidden="true"></i>

          <h3 class="box-title">{{ trans('title.createtag') }}</h3>
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

{{ Form::open(array('url' => 'tags')) }}

    <div class="form-group">
        {{ Form::label('epc', trans('title.epc')) }}
        {{ Form::text('epc', null,
      array(
        'class'=>'form-control',
        'placeholder'=>trans('title.fillepc'),
        'id' => 'epc',
        'required' => 'required',
      ))}}
    </div>

    {{ Form::submit(trans('title.addtag'), array('class' => 'btn btn-primary')) }}
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
