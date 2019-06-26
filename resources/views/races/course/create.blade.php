@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.createCourse') }}
@endsection
@section('contentheader_title')
    {{ trans('title.createCourse') }}
@endsection


@section('main-content')
<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('race/'.$edition_ID->edition_ID.'/course/') }}">{{ trans('title.viewallcourses') }}</a></li>
        <li><a href="{{ URL::to('race/'.$edition_ID->edition_ID.'/course/create') }}">{{ trans('title.createCourse') }}</a></li>
    </ul>
</nav>
  <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
                <i aria-hidden="true" class="fa fa-road"></i>
                <h3 class="box-title">{{ trans('title.createCourse') }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {{ Form::open(['url' => 'race/'.$edition_ID->edition_ID.'/course', 'method' => 'post', 'files' => true]) }}
              <div class="box-body">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    There were some problems adding the course.<br />
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="form-group">
                    {{ Form::label('coursename', trans('title.name')) }}
                    {{ Form::text('coursename', null,
                  array(
                    'class'=>'form-control',
                    'placeholder'=>trans('title.fillCourseName'),
                    'id' => 'coursename',
                    'maxlength' => '30',
                    'pattern' => '[a-zA-Z0-9 \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉĚÚŮ\.]{1,30}',
                    'required' => 'required',
                  ))}}
                </div>
                <div class="form-group">
                    {{ Form::label('surface', trans('title.surface')) }}
                    {{Form::select('surface', array('road' => trans('title.road'), 'path' => trans('title.path'), 'terrain' => trans('title.terrain'), 'miscellaneous' => trans('title.miscellaneous'), 'sand' => trans('title.sand')), null, array(
                    'required' => 'required',
                    'id' => 'surface',
                    'class'=>'form-control',
                    ))}}
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                        {{ Form::label('length', trans('title.length')) }}
                        {{ Form::number('length', null,
                            array(
                                'class'=>'form-control',
                                'placeholder'=>trans('title.filllength'),
                                'id' => 'length',
                                'min' => 1,
                                'max' => 2147483647,
                                'step'=>'1',
                            ))}}
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                        {{ Form::label('climb', trans('title.climb')) }}
                        {{ Form::number('climb', null,
                            array(
                                'class'=>'form-control',
                                'placeholder'=>trans('title.fillclimb'),
                                'id' => 'climb',
                                'min' => 1,
                                'max' => 2147483647,
                                'step'=>'1',
                            ))}}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                {{ Form::label('description', trans('title.description')) }}
                <textarea class="textarea" id="description" name="description" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            </div>

                <div class="form-group">
                  <label for="gpxfile">GPX file</label>
                  <input type="file" id="gpxfile" name="gpxfile">

                  <p class="help-block">GPX file with course route.</p>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                    {{ Form::submit(trans('title.addCourse'), array('class' => 'btn btn-primary')) }}
                    {{ Form::reset(trans('title.reset'), array('class' => 'btn')) }}


              </div>
            {{ Form::close() }}
          </div>
          <!-- /.box -->
      </div>
  </div>
@endsection
@section('scripts')
@parent
<link href="{{ asset('css/summernote.css') }}" rel="stylesheet">
<script src="{{ asset('js/summernote.js') }}" defer></script>
<script type="text/javascript">
    $(document).ready(function() {
    $('#description').summernote({
        placeholder: 'Place some text here',
        tabsize: 2,
        height: 100
    });
});

</script>
@endsection
