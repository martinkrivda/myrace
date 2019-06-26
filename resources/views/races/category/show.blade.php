@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.showcategory') }}
@endsection
@section('contentheader_title')
    {{ trans('title.showcategory') }}
@endsection


@section('main-content')
<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('race/'.$edition_ID.'/category/') }}">{{ trans('title.viewallcategories') }}</a></li>
        <li><a href="{{ URL::to('race/'.$edition_ID.'/category/create') }}">{{ trans('title.createcategory') }}</a></li>
    </ul>
</nav>


<div class="box box-default">
    <div class="box-header with-border">
        <i aria-hidden="true" class="fa fa-newspaper-o"></i>

        <h3 class="box-title">{{ $category->categoryname }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table">
            <tr>
              <th style="width: 20%">ID:</th>
              <td>{{$category->category_ID}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.categoryname') }}:</th>
              <td>{{$category->categoryname}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.course') }}:</th>
              <td>{{$category->coursename}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.gender') }}:</th>
              <td>{{$category->gender}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.length') }}:</th>
              <td>{{$category->length}} m</td>
            </tr>
            <tr>
              <th>{{ trans('title.climb') }}:</th>
              <td>{{$category->climb}} m</td>
            </tr>
            <tr>
              <th>{{ trans('title.entryfee') }}:</th>
              <td>{{$category->entryfee}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.currency') }}:</th>
              <td>{{$category->currency}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.starttime') }}:</th>
              <td>{{$category->starttime}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.sinterval') }}:</th>
              <td>{{$category->sinterval}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.timelimit') }}:</th>
              <td>{{$category->timelimit}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.capacity') }}:</th>
              <td>{{$category->capacity}}</td>
            </tr>
            <tr>
                <th>{{ trans('title.checkage') }}:</th>
                <td>
                @if ($category->checkage == 1)
                    {{Form::checkbox('checkage', '$category->checkage', true, array('disabled' => 'disabled'))}}
                @else
                    {{Form::checkbox('checkage', '$category->checkage', false, array('disabled' => 'disabled'))}}
                @endif

                </td>
            </tr>
            <tr>
              <th>{{ trans('title.birthfrom') }}:</th>
              <td>{{$category->birthfrom}}</td>
            </tr>
            <tr>
              <th>{{ trans('title.birthto') }}:</th>
              <td>{{$category->birthto}}</td>
            </tr>
        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->



@endsection
