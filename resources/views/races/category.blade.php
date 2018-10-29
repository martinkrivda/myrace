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
              <table class="table">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>{{ trans('title.name') }}</th>
                  <th>{{ trans('title.gender') }}</th>
                  <th>{{ trans('title.length') }}</th>
                  <th>{{ trans('title.length') }}</th>
                  <th>{{ trans('title.climb') }}</th>
                  <th>{{ trans('title.entryfee') }}</th>
                  <th>{{ trans('title.currency') }}</th>
                  <th>{{ trans('title.starttime') }}</th>
                  <th>{{ trans('title.sinterval') }}</th>
                  <th>{{ trans('title.timelimit') }}</th>
                  <th>{{ trans('title.checkage') }}</th>
                  <th>{{ trans('title.birthfrom') }}</th>
                  <th>{{ trans('title.birthto') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->category_ID }}<td>
                        <td>{{ $category->categoryname }}<td>
                        <!-- show, edit, and delete buttons -->
                        <td>
                            <!-- delete the category (uses the destroy method DESTROY /race/category/{edition_ID}/{id} -->
                            <!-- we will add this later since its a little more complicated than the other two buttons -->

                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                            <a class="btn btn-small btn-success" href="{{ URL::to('race/category/'.$edition_ID.'/'. $category->category_ID) }}">Show</a>
                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                            <a class="btn btn-small btn-info" href="{{ URL::to('race/category/'.$edition_ID.'/' . $category->category_ID . '/edit') }}">Edit</a>

            </td>
                    </tr>
                @empty
                    <td colspan="13"><center>No Category</center><td>
                @endforelse
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection
