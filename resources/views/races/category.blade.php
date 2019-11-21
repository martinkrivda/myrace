@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.category') }}
@endsection
@section('contentheader_title')
    {{ trans('title.categories') }}
@endsection


@section('main-content')
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$totalcategories}}</h3>

              <p>{{ trans('title.totalcategories') }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-database" aria-hidden="true"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$totalmencategories}}</h3>

              <p>{{ trans('title.malecategories') }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-male" aria-hidden="true"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$totalwomencategories}}</h3>

              <p>{{ trans('title.femalecategories') }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-female" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
<div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ trans('title.categoryinformation') }}</h3>

              <div class="box-tools">
                <a href="{{ URL::to('race/'.$edition_ID.'/category/create') }}" class="btn btn-success pull-right"><i class="fa fa-edit"></i> {{ trans('title.addcategory') }}</a>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="table-responsive">
              <table class="table">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>{{ trans('title.name') }}</th>
                  <th>{{ trans('title.gender') }}</th>
                  <th>{{ trans('title.length') }}</th>
                  <th>{{ trans('title.climb') }}</th>
                  <th>{{ trans('title.entryfee') }}</th>
                  <th>{{ trans('title.currency') }}</th>
                  <th>{{ trans('title.starttime') }}</th>
                  <th>{{ trans('title.sinterval') }}</th>
                  <th>{{ trans('title.timelimit') }}</th>
                  <th>{{ trans('title.capacity') }}</th>
                  <th>{{ trans('title.checkage') }}</th>
                  <th>{{ trans('title.birthfrom') }}</th>
                  <th>{{ trans('title.birthto') }}</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->category_ID }}</td>
                        <td>{{ $category->categoryname }}</td>
                        <td>{{ $category->gender }}</td>
                        <td>{{ $category->length }} m</td>
                        <td>{{ $category->climb }} m</td>
                        <td>{{ $category->entryfee }}</td>
                        <td>{{ $category->currency }}</td>
                        <td>{{ $category->starttime }}</td>
                        <td>{{ $category->sinterval }}</td>
                        <td>{{ $category->timelimit }}</td>
                        <td>{{ $category->capacity }}</td>
                        <td>
                          @if ($category->checkage == 1)
                              {{Form::checkbox('checkage', '$category->checkage', true, array('style' => 'margin-left: 15%;', 'disabled' => 'disabled'))}}
                          @else
                              {{Form::checkbox('checkage', '$category->checkage', false, array('style' => 'margin-left: 15%;', 'disabled' => 'disabled'))}}
                          @endif
                        </td>
                        <td>{{ $category->birthfrom }}</td>
                        <td>{{ $category->birthto }}</td>
                        <!-- show, edit, and delete buttons -->
                        <td data-id="{{$category->category_ID}}">
                            <!-- delete the category (uses the destroy method DESTROY /race/category/{edition_ID}/{id} -->
                            <!-- we will add this later since its a little more complicated than the other two buttons -->

                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                            <a class="btn btn-sm btn-success pull-left" href="{{ URL::to('race/'.$edition_ID.'/category/'.$category->category_ID) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                            <a class="btn btn-sm btn-info pull-left" style="margin-left: 3px;" href="{{ URL::to('race/'.$edition_ID.'/category/'.$category->category_ID.'/edit') }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            {{ Form::open(array('url' => URL::to('race/'.$edition_ID.'/category/'.$category->category_ID), 'id' => 'deleteForm', 'method' => 'POST', 'onsubmit' => 'return confirm("Do you really want to delete the category?");', 'class' => 'pull-left', 'style' => 'margin-left: 3px;')) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array('class' => 'btn btn-sm btn-danger remove-category', 'type' => 'submit'))}}
                            {{ Form::close() }}

            </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="13"><center>No Category</center></td>
                </tr>
                @endforelse
                </tbody>
              </table>
            </div>
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
@endsection
