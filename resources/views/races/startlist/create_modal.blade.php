 <!-- Create Item Modal -->
    <div class="modal fade" id="create-starttime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <form class="formstarttime" action="{{ route('startlist.store', $edition_ID) }}" method="POST">
          @csrf
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">{{ trans('title.addStartTime') }}</h4>
          </div>
          <div class="modal-body">
            <div class="row">
            <div class='col-sm-6'>
                <div class="form-group">
                  <label for="starttime">{{trans('title.start_nr')}}</label>
                    <div class="input-group">
                        <input type="number" min="1" max="99999" step="1" class="form-control" name="start_nr" id="start_nr" title="Start number" required />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-tag"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class='col-sm-6'>
                <div class="form-group">
                  <label for="starttime">{{trans('title.starttime')}}</label>
                    <div class="input-group date" id="datetimepicker1">
                        <input type="text" class="form-control" name="starttime" id="starttime" title="Time of starts" required />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      {{ Form::label('category', trans('title.category')) }}
                      <div class="input-group">
                      {{Form::select('category', $categories, null, array(
                          'required' => 'required',
                          'id' => 'category',
                          'class'=>'form-control',
                      ))}}
                      <span class="input-group-addon">
                            <span class="glyphicon glyphicon-folder-open"></span>
                            </span>
                    </div>
                  </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
          <button type="reset" class="btn btn-default" data-dismiss="modal">{{ trans('adminlte_lang::message.close') }}</button>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="submit" class="btn btn-primary starttime-submit" value="{{ trans('adminlte_lang::message.submit') }}">
        </div>
        </div>
        </form>
      </div>
    </div>
