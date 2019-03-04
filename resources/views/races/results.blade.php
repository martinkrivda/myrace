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
                  <th>{{ trans('title.start_nr') }}</th>
                  <th>{{ trans('title.time') }}</th>
                </tr>
            </thead>
                @forelse ($category->results as $result)
                    <tr>
                        <td>
                            @switch($result->status)
                                @case('OK')
                                    {{$loop->iteration}}.
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
                        <td>{{$result->start_nr}}</td>
                        <td>{{ $result->timems ? date('H:i:s', $result->timems) : ''}}</td>
                    </tr>
                @empty
                <tr>
                    <td colspan="6"><center>No results</center></td>
                </tr>
                @endforelse
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
