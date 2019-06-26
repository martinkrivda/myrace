@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.course') }}
@endsection
@section('contentheader_title')
    {{ trans('title.courses') }}
@endsection


@section('main-content')
<div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ trans('title.courseInfo') }}</h3>

              <div class="box-tools">
                <a href="{{ URL::to('race/'.$edition_ID.'/course/create') }}" class="btn btn-success pull-right"><i class="fa fa-edit"></i> {{ trans('title.addCourse') }}</a>
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
                  <th>{{ trans('title.surface') }}</th>
                  <th>{{ trans('title.length') }}</th>
                  <th>{{ trans('title.climb') }}</th>
                  <th>{{ trans('title.description') }}</th>
                  <th>{{ trans('title.gpx') }}</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courses as $course)
                    <tr>
                        <td>{{ $course->course_ID }}</td>
                        <td>{{ $course->coursename }}</td>
                        <td>{{ $course->surface }}</td>
                        <td>{{ $course->length }} m</td>
                        <td>{{ $course->climb }} m</td>
                        <td>{!! $course->description !!}</td>
                        <td>
                            @if($course->gpx)
                            <button onclick="window.open('data:text/xml;charset=utf-8,'+encodeURIComponent('{{$course->gpx}}'), '', '_blank')"><img src="{{ asset('img/gpx-open-file-format.png') }}" alt="GPX"></button>
                            @endif

                        </td>
                        <!-- show, edit, and delete buttons -->
                        <td data-id="{{$course->course_ID}}">
                            <!-- delete the course (uses the destroy method DESTROY /race/course/{edition_ID}/{id} -->
                            <!-- we will add this later since its a little more complicated than the other two buttons -->

                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                            <a class="btn btn-sm btn-success pull-left" href="{{ URL::to('race/'.$edition_ID.'/course/'.$course->course_ID) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                            <a class="btn btn-sm btn-info pull-left" style="margin-left: 3px;" href="{{ URL::to('race/'.$edition_ID.'/course/'.$course->course_ID.'/edit') }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            {{ Form::open(array('url' => URL::to('race/'.$edition_ID.'/course/'.$course->course_ID), 'id' => 'deleteForm', 'method' => 'POST', 'onsubmit' => 'return confirm("Do you really want to delete the course?");', 'class' => 'pull-left', 'style' => 'margin-left: 3px;')) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array('class' => 'btn btn-sm btn-danger remove-course', 'type' => 'submit'))}}
                            {{ Form::close() }}

            </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="8"><center>No course</center></td>
                </tr>
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
@section('scripts')
@parent
<script type="text/javascript">

</script>
@endsection
