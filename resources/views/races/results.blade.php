@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.results') }}
@endsection
@section('contentheader_title')
    {{ trans('title.results') }}
@endsection
@section('main-content')

@forelse ($categories as $category)
    <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">{{$category->categoryname}}</h3>
          <span><small>{{$category->length}}m / {{$category->climb}}m</small></span>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
                        <table class="table table-striped table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>{{ trans('title.name') }}</th>
                  <th>{{ trans('title.yearofbirth') }}</th>
                  <th>{{ trans('title.club') }}</th>
                  <th>{{ trans('title.bib_nr') }}</th>
                  <th>{{ trans('title.time') }}</th>
                  <th>{{ trans('title.loss') }}</th>
                   <th>{{ trans('title.kmtime') }}</th>
                </tr>
            </thead>
            <tbody>
            @if (is_array($category->results) || is_object($category->results))
                @forelse ($category->results as $index => $result)
                    <tr>
                        <td>
                            @switch($result->status)
                                @case('OK')
                                    @if($index > 0 && $result->timems == $category->results[$index - 1]->timems)
                                    {{$position}}.
                                    @else
                                    {{$loop->iteration}}.
                                    @php
                                    $position = $loop->iteration;
                                    @endphp
                                    @endif
                                    @break

                                @case('RUNNING')
                                    <p>&#x1F3C3</p>
                                    @break

                                 @case('DNF')
                                    DNF
                                    @break

                                @case('NC')
                                    NC
                                    @break

                                @case('DNQ')
                                    DNQ
                                    @break

                                @case('DNS')
                                    DNS
                                    @break

                                @default
                                    fail
                            @endswitch
                        </td>
                        <td>{{$result->lastname}} {{$result->firstname}}</td>
                        <td>{{$result->yearofbirth}}</td>
                        <td>{{$result->clubname}}</td>
                        <td>{{$result->bib_nr}}</td>
                        <td>{{ $result->timems ? date('H:i:s', $result->timems) : ''}}</td>
                        <td>
                            @if ($index >= 0 && $result->timems != '')
                                @php
                                    $seconds = ($result->timems - $category->results[$loop->first]->timems);
                                    $minutes = floor($seconds / 60);
                                    $seconds -= $minutes * 60;
                                    $loss = "$minutes:".date('s', $seconds);
                                @endphp
                                + {{ $loss }}
                            @endif
                        </td>
                        <td>
                            @if ($index >= 0 && $result->timems != '')
                                @php
                                    $seconds = ($result->timems / ($category->length / 1000));
                                    $minutes = floor($seconds / 60);
                                    $seconds -= $minutes * 60;
                                    $timeKm = "$minutes:".date('s', $seconds);
                                @endphp
                                {{$timeKm}}
                            @endif
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="8"><center>No results</center></td>
                </tr>
                @endforelse
                @else
                <tr>
                    <td colspan="8"><center>Start time is in the future yet</center></td>
                </tr>
                @endif
                </tbody>
              </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@empty
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-ban"></i> No Categories!</h4>
    <p>Firstly, you must add any category.</p>
</div>
@endforelse

@endsection
