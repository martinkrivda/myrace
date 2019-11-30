@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.tags') }}
@endsection
@section('contentheader_title')
    {{ trans('title.tags') }}
@endsection


@section('main-content')
      <!-- Small boxes (Stat box) -->
                <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$totaltags}}</h3>

              <p>{{ trans('title.totaltags') }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-tags" aria-hidden="true"></i>
            </div>
          </div>
<div class="row">
        <!-- /.col -->
        <div class="col-xs-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ trans('title.tagrecords') }}</h3>

              <div class="box-tools">
                <a href="{{ URL::to('tags/create') }}" class="btn btn-success pull-right"><i class="fa fa-edit"></i> {{ trans('title.addtag') }}</a>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! $dataTable->table(['class' => 'table'], false) !!}
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
    <!-- /.col -->

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
<!-- /.row -->

<store-tag></store-tag>

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
