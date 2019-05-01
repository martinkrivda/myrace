 <!-- Create Item Modal -->
    <div class="modal fade" id="update-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <form class="formuser" action="" method="PUT">
          @csrf
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">{{ trans('title.updateUser') }}</h4>
          </div>
          <div class="modal-body">
             <div class="row">
            <div class='col-sm-12'>
                <div class="form-group">
                    {{ Form::label('userID', 'ID') }}
                      {{ Form::number('userID', null,
                    array(
                      'class'=>'form-control',
                      'placeholder'=>trans('title.fillID'),
                      'id' => 'userID',
                      'maxlength' => '5',
                      'disabled' => 'disabled',
                      'required' => 'required',
                    ))}}
                </div>
            </div>
        </div>
            <div class="row">
            <div class='col-sm-12'>
                <div class="form-group">
                    {{ Form::label('username', trans('title.username')) }}
                      {{ Form::text('username', null,
                    array(
                      'class'=>'form-control',
                      'placeholder'=>trans('title.fillusername'),
                      'id' => 'username',
                      'maxlength' => '255',
                      'pattern' => '[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ\.0-9]{1,255}',
                      'required' => 'required',
                    ))}}
                </div>
            </div>
            <div class='col-sm-12'>
                <div class="form-group">
                    {{ Form::label('lastname', trans('title.lastname')) }}
                        {{ Form::text('lastname', null,
                    array(
                        'class'=>'form-control',
                        'placeholder'=>trans('title.filllastname'),
                        'id' => 'lastname',
                        'maxlength' => '255',
                        'pattern' => '[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,255}',
                        'required' => 'required',
                    ))}}
                </div>
            </div>
            <div class='col-sm-12'>
                <div class="form-group">
                    {{ Form::label('firstname', trans('title.firstname')) }}
                        {{ Form::text('firstname', null,
                    array(
                        'class'=>'form-control',
                        'placeholder'=>trans('title.fillfirstname'),
                        'id' => 'username',
                        'maxlength' => '255',
                        'pattern' => '[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,50}',
                        'required' => 'required',
                    ))}}
                </div>
            </div>
        </div>
             <div class="row">
                <div class='col-sm-12'>
                    <div class="form-group">
                        {{ Form::label('email', trans('title.email')) }}
                          {{ Form::email('email', null,
                        array(
                          'class'=>'form-control',
                          'placeholder'=>trans('title.fillemail'),
                          'id' => 'email',
                          'maxlength' => '255',
                          'required' => 'required',
                        ))}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class='col-sm-12'>
                    <div class="form-group">
                        {{ Form::label('lastlogin', trans('title.lastlogin')) }}
                          {{ Form::text('lastlogin', null,
                        array(
                          'class'=>'form-control',
                          'placeholder'=>trans('title.lastlogin'),
                          'id' => 'lastlogin',
                          'maxlength' => '50',
                          'disabled' => 'disabled',
                        ))}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label >
                            <input type="checkbox" name="active" id="active"> {{trans('title.active')}}
                        </label>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
          <button type="reset" class="btn btn-default" data-dismiss="modal">{{ trans('adminlte_lang::message.close') }}</button>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="submit" class="btn btn-primary crud-submit-edit" value="{{ trans('adminlte_lang::message.submit') }}">
        </div>
        </div>
        </form>
      </div>
    </div>
