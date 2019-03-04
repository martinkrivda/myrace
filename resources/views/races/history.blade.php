@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.history') }}
@endsection
@section('contentheader_title')
    {{ trans('title.history') }}
@endsection
@section('main-content')
<div class="box box-error">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('title.audit')}}</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! $dataTable->table(['class' => 'table table-striped table-hover'], false) !!}
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

@endsection
@section('scripts')
@parent
<script type="text/javascript">
</script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="{{ asset('js/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/buttons.print.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/buttons.colVis.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/buttons.flash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/custom/registrationDelete.js') }}" type="text/javascript"></script>
{!! $dataTable->scripts() !!}
{!! Toastr::message() !!}
@endsection
