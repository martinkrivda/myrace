@extends('adminlte::page')

@section('htmlheader_title')
    {{trans('menu.releasenotes')}}
@endsection
@section('contentheader_title')
    {{ trans('menu.releasenotes') }}
@endsection


@section('main-content')

<div class="row">
        <div class="col-md-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-code-fork"></i>

              <h3 class="box-title">{{ trans('menu.releasenotes') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <h4>Verze 0.0.1-alpha</h4>
                <ul>
                <li>oficiálně první verze aplikace</li>
                </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

@endsection
