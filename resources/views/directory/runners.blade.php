@extends('adminlte::page')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.runners') }}
@endsection
@section('contentheader_title')
	{{ trans('adminlte_lang::message.runnersdirectory') }}
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
						  <span><i class="fa fa-graduation-cap"></i></span>
						  <h3 class="box-title">{{ trans('adminlte_lang::message.runners') }}</h3>
						</div>
						<div class="col-xs-2"></div>
						<div class="col-xs-2"></div>
						<div class="col-xs-2"></div>
						<div class="col-xs-2"></div>
						<div class="col-xs-2">
							<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create-runner"><i class="fa fa-edit"></i> {{ trans('adminlte_lang::message.addrunner') }}</button>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						</div>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
				{{ csrf_field() }}
					<table id="runners-table" class="table table-striped table-hover dataTable" role="grid" aria-describedby="runners-table_info">
						<thead>
							<tr>
							  <th>ID</th>
							  <th>{{ trans('adminlte_lang::message.firstname') }}</th>
							  <th>{{ trans('adminlte_lang::message.lastname') }}</th>
							  <th>{{ trans('adminlte_lang::message.vintage') }}</th>
							  <th>{{ trans('adminlte_lang::message.gender') }}</th>
							  <th>{{ trans('adminlte_lang::message.country') }}</th>
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
							 <th>{{ trans('adminlte_lang::message.firstname') }}</th>
							 <th>{{ trans('adminlte_lang::message.lastname') }}</th>
							 <th>{{ trans('adminlte_lang::message.vintage') }}</th>
							 <th>{{ trans('adminlte_lang::message.gender') }}</th>
							 <th>{{ trans('adminlte_lang::message.country') }}</th>
							 <th>E-mail</th>
							 <th>{{ trans('adminlte_lang::message.phone') }}</th>
							 <th>{{ trans('adminlte_lang::message.actions') }}</th>
							</tr>
						</tfoot>
					</table>
				</div>
		</div>
	</div>
	@include('directory.newrunner_modal')
	@include('directory.editrunner_modal')

@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        var url = "<?php echo route('runners-data.index') ?>";
    </script>
    <script src="/js/custom/runnersAjax.js"></script>
@endsection


