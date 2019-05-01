@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.users') }}
@endsection
@section('contentheader_title')
    {{ trans('title.users') }}
@endsection
@section('main-content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $totalusers }}</h3>
              <p>{{trans('title.countofusers')}}</p>
            </div>
            <div class="icon">
              <i class="fa fa-users" aria-hidden="true"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
             <h3>{{ $totalroles }}</h3>
              <p>{{trans('title.countOfRoles')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $totalpermission }}</h3>
              <p>{{trans('title.countOfPermission')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->

    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <div class="row">
                        <div class="col-xs-2">
                          <span><i class="fa fa-users" aria-hidden="true"></i></span>
                          <h3 class="box-title">{{ trans('title.listofusers') }}</h3>
                        </div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-2">
                            <a class="btn btn-success pull-right" href="{{ url('register') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> {{ trans('title.adduser') }}</a>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                {{ csrf_field() }}
                    <table id="users-table" class="table table-striped table-hover dataTable" role="grid" aria-describedby="users-table_info">
                        <thead>
                            <tr>
                              <th>ID</th>
                              <th>{{ trans('title.username') }}</th>
                              <th>{{ trans('title.name') }}</th>
                              <th>{{ trans('title.type') }}</th>
                              <th>{{ trans('title.active') }}</th>
                              <th>{{ trans('title.lastlogin') }}</th>
                              <th>{{ trans('title.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                             <th>ID</th>
                              <th>{{ trans('title.username') }}</th>
                              <th>{{ trans('title.name') }}</th>
                              <th>{{ trans('title.type') }}</th>
                              <th>{{ trans('title.active') }}</th>
                              <th>{{ trans('title.lastlogin') }}</th>
                              <th>{{ trans('title.actions') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
        </div>
    </div>
    @include('settings.user.edit_modal')

@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        var url = "<?php echo route('users-data.index') ?>";
    </script>
    <script src="/js/custom/usersAjax.js"></script>
@endsection