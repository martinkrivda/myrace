@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.showregistration') }}
@endsection
@section('contentheader_title')
    {{ trans('title.showregistration') }}
@endsection


@section('main-content')
<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('race/'.$edition_ID.'/registration/') }}">{{ trans('title.viewallregistrations') }}</a></li>
        <li><a href="{{ URL::to('race/'.$edition_ID.'/registration/create') }}">{{ trans('title.newregistration') }}</a></li>
    </ul>
</nav>


<div class="box box-default">
    <div class="box-header with-border">
        <i aria-hidden="true" class="fa fa-newspaper-o"></i>

        <h3 class="box-title">{{ $registration->lastname }} {{ $registration->firstname }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table">
            <tr>
              <th style="width: 20%">ID:</th>
              <td>{{$registration->registration_ID}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.reggroup') }}:</th>
              <td>{{$registration->registrationsum}} ({{$registration->regsummary_ID}}) - {{$registration->summaryemail}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.name') }}:</th>
              <td>{{$registration->lastname}} {{$registration->firstname}} ({{$registration->runner_ID}})</td>
            </tr>
            <tr>
              <th>{{ trans('title.yearofbirth') }}:</th>
              <td>{{$registration->yearofbirth}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.club') }}:</th>
              <td>{{$registration->clubname}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.gender') }}:</th>
              <td>{{$registration->gender}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.category') }}:</th>
              <td>{{$registration->categoryname}}  <small>({{$registration->length}}m / {{$registration->climb}}m)</small></td>
            </tr>
            <tr>
              <th>{{ trans('title.bib_nr') }}:</th>
              <td>{{$registration->bib_nr}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.epc') }}:</th>
              <td>{{$registration->EPC}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.starttime') }}:</th>
              <td>{{ $registration->stime != null ? ($registration->startInMinutes .' = '. date('H:i:s', strtotime($registration->stime))) : ''}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.finishtime') }}:</th>
              <td></td>
            </tr>
            <tr>
              <th>{{ trans('title.email') }}:</th>
              <td>{{$registration->email}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.phone') }}:</th>
              <td>{{$registration->phone}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.country') }}:</th>
              <td>{{$registration->country}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.entryfee') }}:</th>
              <td>{{$registration->entryfee}} {{$registration->currency}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.payref') }}:</th>
              <td>{{$registration->payref}}</td>
            </tr>
           <tr>
                <th>{{ trans('title.paid') }}:</th>
                <td>
                @if ($registration->paid == 1)
                    {{Form::checkbox('paid', '$registration->paid', true, array('disabled' => 'disabled'))}}
                @else
                    {{Form::checkbox('paid', '$registration->paid', false, array('disabled' => 'disabled'))}}
                @endif

                </td>
            </tr>
            <tr>
                <th>{{ trans('title.notcompeting') }}:</th>
                <td>
                @if ($registration->NC == 1)
                    {{Form::checkbox('notcompeting', '$registration->NC', true, array('disabled' => 'disabled'))}}
                @else
                    {{Form::checkbox('notcompeting', '$registration->NC', false, array('disabled' => 'disabled'))}}
                @endif

                </td>
            </tr>
             <tr>
                <th>{{ trans('title.dns') }}:</th>
                <td>
                @if ($registration->DNS == 1)
                    {{Form::checkbox('DNS', '$registration->DNS', true, array('disabled' => 'disabled'))}}
                @else
                    {{Form::checkbox('DNS', '$registration->DNS', false, array('disabled' => 'disabled'))}}
                @endif

                </td>
            </tr>
            <tr>
                <th>{{ trans('title.dnf') }}:</th>
                <td>
                @if ($registration->DNF == 1)
                    {{Form::checkbox('DNF', '$registration->DNF', true, array('disabled' => 'disabled'))}}
                @else
                    {{Form::checkbox('DNF', '$registration->DNF', false, array('disabled' => 'disabled'))}}
                @endif

                </td>
            </tr>
            <tr>
                <th>{{ trans('title.dnq') }}:</th>
                <td>
                @if ($registration->DNQ == 1)
                    {{Form::checkbox('DNQ', '$registration->DNQ', true, array('disabled' => 'disabled'))}}
                @else
                    {{Form::checkbox('DNQ', '$registration->DNQ', false, array('disabled' => 'disabled'))}}
                @endif

                </td>
            </tr>
            <tr>
              <th>{{ trans('title.note') }}:</th>
              <td>{{$registration->note}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.creator') }}:</th>
              <td>{{$registration->userlastname}} {{$registration->userfirstname}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.created_at') }}:</th>
              <td>{{$registration->created_at}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.updated_at') }}:</th>
              <td>{{$registration->updated_at}}</td>
            </tr>

        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
