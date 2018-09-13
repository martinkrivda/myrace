@extends('adminlte::page')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.clubs') }}
@endsection
@section('contentheader_title')
  {{ trans('adminlte_lang::message.clubsdirectory') }}
@endsection
@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-9 col-md-offset-1">

				<div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Example box</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        Put your content here
                    </div>
                    <!-- /.box-body -->
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
                          <span><i class="fa fa-home"></i></span>
                          <h3 class="box-title">{{ trans('adminlte_lang::message.clubs') }}</h3>
                        </div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-2">
                            <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create-club"><i class="fa fa-edit"></i> {{ trans('adminlte_lang::message.addclub') }}</button>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                {{ csrf_field() }}
                    <table id="clubs-table" class="table table-striped table-hover dataTable" role="grid" aria-describedby="clubs-table_info">
                        <thead>
                            <tr>
                              <th>ID</th>
                              <th>{{ trans('adminlte_lang::message.name') }}</th>
                              <th>{{ trans('adminlte_lang::message.abbr') }}</th>
                              <th>{{ trans('adminlte_lang::message.street') }}</th>
                              <th>{{ trans('adminlte_lang::message.city') }}</th>
                              <th>{{ trans('adminlte_lang::message.zip') }}</th>
                              <th>{{ trans('adminlte_lang::message.country') }}</th>
                              <th>{{ trans('adminlte_lang::message.taxid') }}</th>
                              <th>{{ trans('adminlte_lang::message.vatid') }}</th>
                              <th>{{ trans('adminlte_lang::message.web') }}</th>
                              <th>E-mail</th>
                              <th>{{ trans('adminlte_lang::message.phone') }}</th>
                              <th>{{ trans('adminlte_lang::message.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                              <th>ID</th>
                              <th>{{ trans('adminlte_lang::message.name') }}</th>
                              <th>{{ trans('adminlte_lang::message.abbr') }}</th>
                              <th>{{ trans('adminlte_lang::message.street') }}</th>
                              <th>{{ trans('adminlte_lang::message.city') }}</th>
                              <th>{{ trans('adminlte_lang::message.zip') }}</th>
                              <th>{{ trans('adminlte_lang::message.country') }}</th>
                              <th>{{ trans('adminlte_lang::message.taxid') }}</th>
                              <th>{{ trans('adminlte_lang::message.vatid') }}</th>
                              <th>{{ trans('adminlte_lang::message.web') }}</th>
                              <th>E-mail</th>
                              <th>{{ trans('adminlte_lang::message.phone') }}</th>
                              <th>{{ trans('adminlte_lang::message.actions') }}</th>
                        </tfoot>
                    </table>
                </div>
        </div>
    </div>
    @include('directory.newclub_modal')
    @include('directory.editclub_modal')
@endsection
@section('scripts')
    @parent
    <script type="text/javascript">
        var url = "<?php echo route('clubs-data.index') ?>";
    </script>
    <script src="/js/custom/clubsAjax.js"></script>
@endsection
