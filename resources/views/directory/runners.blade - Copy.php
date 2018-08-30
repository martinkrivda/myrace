@extends('adminlte::page')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.runners') }}
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
		{{ csrf_field() }}
			<table id="runners-table" class="table table-striped table-hover dataTable" role="grid" aria-describedby="runners-table_info">
                                <thead>
                                    <tr>
                                      <th>ID</th>
                                      <th>Jméno</th>
                                      <th>Příjmení</th>
                                      <th>Ročník</th>
                                      <th>Pohlaví</th>
                                      <th>Země</th>
									  <th>E-mail</th>
									  <th>Telefon</th>
									  <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($runners as $data)
                                    <tr>
                                      <td>{{ $data->runner_ID }} </td>
                                      <td>{{ $data->firstname }} </td>
                                      <td>{{ $data->lastname }} </td>
                                      <td>{{ $data->vintage }} </td>
                                      <td>{{ $data->gender }} </td>
									  <td>{{ $data->country }} </td>
									  <td>{{ $data->email }} </td>
									  <td>{{ $data->phone }} </td>
                                      <td>
                                        <a onClick="modalEditTriger({{$data->id}})" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                                        <a onClick="modalDeleteTrigger({{$data->id}})" class="btn btn-danger"><i class="fa fa-close"></i></a>
                                      </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                     <th>ID</th>
                                      <th>Jméno</th>
                                      <th>Příjmení</th>
                                      <th>Ročník</th>
                                      <th>Pohlaví</th>
                                      <th>Země</th>
									  <th>E-mail</th>
									  <th>Telefon</th>
									  <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
		</div>
	</div>
@endsection
