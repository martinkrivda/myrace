@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.information') }}
@endsection
@section('contentheader_title')
    {{ trans('title.information') }}
@endsection


@section('main-content')
@if($raceinfo->cancelled == 1)
    <div class="callout callout-danger">
        <h4>{{ trans('title.racecanceled') }}!</h4>
        <p>{{$raceinfo->cancelreason}}</p>
    </div>
@endif
<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-flag-o" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ trans('title.racename') }}</span>
              <span class="info-box-number">{{$raceinfo->editionname}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-calendar" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ trans('title.date') }}</span>
              <span class="info-box-number">{{$raceinfo->date}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-clock-o" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ trans('title.firststart') }}</span>
              <span class="info-box-number">{{$raceinfo->firststart}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-location-arrow" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ trans('title.location') }}</span>
              <span class="info-box-number">{{$raceinfo->location}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ trans('title.basicinformation') }}</h3>

              <div class="box-tools">

              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th>ID:</th>
                  <td>{{$raceinfo->edition_ID}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.racename') }}:</th>
                  <td>{{$raceinfo->editionname}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.abbreviation') }}:</th>
                  <td>{{$raceinfo->race_abbr}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.edition') }}:</th>
                  <td>{{$raceinfo->edition_nr}}.</td>
                </tr>
                <tr>
                  <th>{{ trans('title.date') }}:</th>
                  <td>{{date('d.m.Y', strtotime($raceinfo->date))}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.location') }}:</th>
                  <td>{{$raceinfo->location}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.firststart') }}:</th>
                  <td>{{$raceinfo->firststart}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.eventofficetill') }}:</th>
                  <td>{{date('d.m.Y h:i', strtotime($raceinfo->eventoffice))}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.organiser') }}:</th>
                  <td>{{$raceinfo->orgname}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.competition') }}:</th>
                  <td>{{$raceinfo->competition}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.gps') }}:</th>
                  <td>{{$raceinfo->gps}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.web') }}:</th>
                  <td><a href="{{$raceinfo->web}}">{{$raceinfo->web}}</a></td>
                </tr>
                <tr>
                  <th>{{ trans('title.email') }}:</th>
                  <td><a href="mailto:{{$raceinfo->email}}">{{$raceinfo->email}}</a></td>
                </tr>
                <tr>
                  <th>{{ trans('title.eventdirector') }}:</th>
                  <td>{{$raceinfo->eventdirector}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.mainreferee') }}:</th>
                  <td>{{$raceinfo->mainreferee}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.entriesmanager') }}:</th>
                  <td>{{$raceinfo->entriesmanager}}</td>
                </tr>
                <tr>
                  <th>{{ trans('title.jury') }}:</th>
                  <td>{{$raceinfo->jury1}}, {{$raceinfo->jury2}}, {{$raceinfo->jury3}}</td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
    <!-- /.col -->
            <!-- /.col -->
        <div class="col-md-6">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">{{ trans('title.category') }}</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              The body of the box
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
</div>
<!-- /.row -->

@endsection