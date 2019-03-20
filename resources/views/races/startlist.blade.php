@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.startlist') }}
@endsection
@section('contentheader_title')
    {{ trans('title.startlist') }}
@endsection
@section('main-content')
<div class="row">
    <div class="col-md-12">
      <!-- Application buttons -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">{{trans('title.controlpanel')}}</h3>
        </div>
        <div class="box-body">
          <p></p>
          <!-- Button generate times modal -->
           @can('starttime.generate', Auth::user())
          <button type="button" id="btnGenerate" class="btn btn-app" data-toggle="modal" data-target="#generate-starttime">
            <i class="fa fa-cogs"></i> {{trans('title.generateStartTime')}}
          </button>
          <a class="btn btn-app" id="assignTags">
            <i class="fa fa-tags"></i> {{trans('title.assignTags')}}
          </a>
          <a class="btn btn-app" id="drawStartList">
            <i class="fa fa-random"></i> {{trans('title.drawStartList')}}
          </a>
          <a class="btn btn-app" id="refresh">
            <i class="fa fa-refresh"></i> {{trans('title.refresh')}}
          </a>
          @endcan
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</div>


      <div class="box box-success">
        <div class="box-header with-border">
          <span><i class="fa fa-th-list" aria-hidden="true"></i></span>
          <h3 class="box-title">{{trans('title.startTime')}}</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
            <div class="col-xs-2"></div>
            <div class="col-xs-2"></div>
            <div class="col-xs-2"></div>
            <div class="col-xs-2"></div>
            <div class="col-xs-2"></div>
            <div class="col-xs-2">
              @can('starttime.create', Auth::user())
              <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create-starttime"><i class="fa fa-edit"></i> {{ trans('title.addStartTime') }}</button>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              @endcan
            </div>
          </div>
          {!! $dataTable->table(['class' => 'table table-striped table-hover'], false) !!}
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      @include('races.startlist.generatetime_modal')
      @include('races.startlist.create_modal')

@endsection
@section('scripts')
@parent
<script type="text/javascript">
    var generateTimeUrl = "<?php echo route('generatetime', $edition_ID) ?>";
    var assignTagsUrl = "<?php echo route('assigntags', $edition_ID) ?>";
    var drawStartListUrl = "<?php echo route('drawstartlist', $edition_ID) ?>";
    var categoryListUrl = "<?php echo route('categorylist-data', $edition_ID) ?>";
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
<script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/custom/starttimeAjax.js') }}" type="text/javascript"></script>
{!! $dataTable->scripts() !!}
{!! Toastr::message() !!}
@endsection