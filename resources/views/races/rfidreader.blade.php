@extends('adminlte::page')

@section('htmlheader_title')
	{{trans('title.rfidreader')}}
@endsection
@section('contentheader_title')
    {{ trans('title.rfidreader') }}
@endsection


@section('main-content')
	<div class="container-fluid spark-screen" onload="setFocusToTextBox()">
		<div class="row">
			<div class="col-md-9 col-md-offset-1">

				<div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Upozornění</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        Nahráváte čipy do databáze.
                    </div>
                    <!-- /.box-body -->
                </div>
			</div>
		</div>
	</div>
    <div id="insert-reader">
    {{ Form::open(array('url' => 'rfid-data', 'id' => 'rfidreader', 'data-resource' => $edition_ID, 'name' => 'rfidreader', 'method' => 'POST')) }}
    <div class="row">
        <div class="col-xs-3">
            <div class="form-group">
                {{ Form::label('gateway', trans('title.gateway')) }}
                {{Form::select('gateway', array('F' => trans('title.finish'), '1' => trans('title.split1')), null, array(
                'required' => 'required',
                'id' => 'gateway',
                'class'=>'form-control',
                ))}}
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box-body">
        <label for="rfid">RFID NO.</label> <input type="text" name="rfid"
            id="rfid" required autofocus autocomplete="off"/>
        <button id="submit" onclick='setFocusToTextBox()'>Finish</button>
    <span id="result"></span>
</div>
{{ Form::close() }}
</div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <div class="row">
                        <div class="col-xs-2">
                          <span><i class="fa fa-tags"></i></span>
                          <h3 class="box-title">{{ trans('title.readtags') }}</h3>
                        </div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-2"></div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <div class="table-responsive">
                    {{ csrf_field() }}
                    <table id="readtags-table" url="{{url('race/rfidreader/lasttag')}}" class="table table-striped table-hover dataTable" role="grid" aria-describedby="readtags-table_info">
                        <thead>
                            <tr>
                              <th>ID</th>
                              <th>{{ trans('title.epc') }}</th>
                              <th>{{ trans('title.gateway') }}</th>
                              <th>{{ trans('title.ip_adress') }}</th>
                              <th>{{ trans('title.time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                            <th>ID</th>
                              <th>{{ trans('title.epc') }}</th>
                              <th>{{ trans('title.gateway') }}</th>
                              <th>{{ trans('title.ip_adress') }}</th>
                              <th>{{ trans('title.time') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                            </div>
                        </div>
                    </div>
    </div>
@endsection
@section('scripts')
@parent
<script type="text/JavaScript">

function disableselect(e){
return false
}
function reEnable(){
return true
}
document.onselectstart=new Function ("return false")
if (window.sidebar){
document.onmousedown=disableselect
document.onclick=reEnable
}
function setFocusToTextBox(){
    document.getElementById("rfid").focus();
}
</script>
<script src="{{ asset('js/custom/rfidReader.js') }}" type="text/javascript"></script>
{!! Toastr::message() !!}
@endsection
