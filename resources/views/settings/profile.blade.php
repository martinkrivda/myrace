@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.userProfile') }}
@endsection
@section('contentheader_title')
    {{ trans('title.userProfile') }}
@endsection


@section('main-content')
<div class="row">
        <div class="col-md-3">
            <user-profile :auth-user="{{ Auth::user() }}" :user-roles="{{ $roles->toJson() }}"></user-profile>

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('title.aboutOrg')}}</h3>
            </div>
            <!-- /.box-header -->
            <user-organiser :auth-user="{{ Auth::user() }}" :user-organisers="{{ $organisers->toJson() }}"></user-organiser>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
            </ul>
                <user-detail :auth-user="{{ Auth::user() }}"></user-detail>
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
@endsection
