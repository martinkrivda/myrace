@extends('adminlte::page')

@section('htmlheader_title')
	{{ trans('title.races') }}
@endsection
@section('contentheader_title')
    {{ trans('title.raceconfig') }}
@endsection

@section('main-content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <div class="row">
                    <div class="col-xs-2">
                      <span><i class="fa fa-trophy" aria-hidden="true"></i></span>
                      <h3 class="box-title">{{ trans('title.races') }}</h3>
                    </div>
                    <div class="col-xs-2"></div>
                    <div class="col-xs-2"></div>
                    <div class="col-xs-2"></div>
                    <div class="col-xs-2"></div>
                    <div class="col-xs-2">
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create-race"><i class="fa fa-edit"></i>
                        {{ trans('title.addrace') }}</button>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            {{ csrf_field() }}
                <table id="races-table" class="table table-striped table-hover" role="grid" aria-describedby="races-table_info">
                    <thead>
                        <tr>
                          <th>ID</th>
                          <th>{{ trans('title.name') }}</th>
                          <th>{{ trans('title.abbreviation') }}</th>
                          <th>{{ trans('title.location') }}</th>
                          <th>{{ trans('title.organiser') }}</th>
                          <th>{{ trans('title.web') }}</th>
                          <th>{{ trans('title.email') }}</th>
                          <th>{{ trans('title.phone') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <div class="row">
                    <div class="col-xs-2">
                      <span><i class="fa fa-font-awesome" aria-hidden="true"></i></span>
                      <h3 class="box-title">{{ trans('title.raceeditions') }}</h3>
                    </div>
                    <div class="col-xs-2"></div>
                    <div class="col-xs-2"></div>
                    <div class="col-xs-2"></div>
                    <div class="col-xs-2"></div>
                    <div class="col-xs-2">
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create-edition"><i class="fa fa-edit"></i>
                        {{ trans('title.addedition') }}</button>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            {{ csrf_field() }}
                <table id="editions-table" class="table table-striped table-hover" role="grid" aria-describedby="editions-table_info">
                    <thead>
                        <tr>
                          <th>ID</th>
                          <th>{{ trans('title.name') }}</th>
                          <th>{{ trans('title.edition') }}</th>
                          <th>{{ trans('title.race') }}</th>
                          <th>{{ trans('title.organiser') }}</th>
                          <th>{{ trans('title.date') }}</th>
                          <th>{{ trans('title.location') }}</th>
                          <th>{{ trans('title.web') }}</th>
                          <th>{{ trans('title.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('settings.newrace_modal')
@include('settings.newedition_modal')
@include('settings.editedition_modal')
@endsection
@section('scripts')
@parent
<script type="text/javascript">
    var url = "<?php echo route('races-data.index') ?>";
    var orgurl = "<?php echo route('organiser-data.index') ?>";
    var editionurl = "<?php echo route('editions-data.index') ?>";
</script>
<script src="/js/custom/racesAjax.js"></script>
<script src="/js/custom/editionAjax.js"></script>
<!-- TableEdit -->
<script src="{{ asset('js/jquery.tabledit.js') }}"></script>
@endsection
