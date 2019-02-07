@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.registrations') }}
@endsection
@section('contentheader_title')
    {{ trans('title.registrations') }}
@endsection


@section('main-content')
<!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$totalregistrations}}</h3>

              <p>{{ trans('title.totalregistrations') }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-address-card-o" aria-hidden="true"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$countofclub}}</h3>

               <p>{{ trans('title.countofclub') }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-university" aria-hidden="true"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$totalmenregistered}}</h3>

               <p>{{ trans('title.maleregistrations') }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-male" aria-hidden="true"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$totalwomenregistered}}</h3>

              <p>{{ trans('title.femaleregistrations') }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-female" aria-hidden="true"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <!-- =========================================================== -->
<div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ trans('title.registrations') }}</h3>

              @can('registrations.create', Auth::user())
                <div class="box-tools">
                  <a href="{{ URL::to('race/'.$edition_ID.'/registration/create') }}" class="btn btn-success pull-right"><i class="fa fa-edit"></i> {{ trans('title.newregistration') }}</a>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
              @endcan
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! $dataTable->table(['class' => 'table table-striped table-hover'], false) !!}
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

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
{!! $dataTable->scripts() !!}
{!! Toastr::message() !!}
@endsection
