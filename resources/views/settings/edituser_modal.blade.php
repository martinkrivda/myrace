<!-- Edit Item Modal -->
    <div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <form class="formuser" action="" method="PUT">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">{{ trans('adminlte_lang::message.editrunner') }}</h4>
          </div>
          <div class="modal-body">
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
                </ul>
              </div>
            @endif
            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="firstname" class=" form-control-label">{{ trans('adminlte_lang::message.firstname') }}</label><input type="text" id="firstname"
                    name="firstname" placeholder="{{ trans('adminlte_lang::message.fillfirstname') }}"
                    pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,50}"
                    class="form-control" maxlength="50" required />
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="lastname" class="form-control-label">{{ trans('adminlte_lang::message.lastname') }}</label><input
                    type="text" id="lastname" name="lastname"
                    placeholder="{{ trans('adminlte_lang::message.filllastname') }}"
                    pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,255}"
                    class="form-control" maxlength="255" required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-3">
                <div class="form-group">
                  <label for="vintage" class=" form-control-label">{{ trans('adminlte_lang::message.vintage') }}</label><input
                    type="number" id="vintage" name="vintage" min="1900"
                    max="<?php echo date("Y"); ?>" step="1"
                    placeholder="{{ trans('adminlte_lang::message.vintage') }}"
                    class="form-control" required />
                </div>
              </div>
              <div class="col-xs-4">
                <div class="form-group">
                  <label for="gender" class="form-control-label">{{ trans('adminlte_lang::message.gender') }}</label><select
                    name="gender" id="gender"
                    class="form-control">
                    <option disabled selected value>{{ trans('adminlte_lang::message.pleaseselect') }}</option>
                    <option value="male">{{ trans('adminlte_lang::message.male') }}</option>
                    <option value="female">{{ trans('adminlte_lang::message.female') }}</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-5">
                <div class="form-group">
                  <label for="club" class="form-control-label">{{ trans('adminlte_lang::message.club') }}</label><input
                    type="text" id="clubedit" name="club"
                    pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ\.]{1,70}"
                    placeholder="{{ trans('adminlte_lang::message.fillclub') }}"
                    class="form-control" maxlength="70" autocomplete="off"/>
                    <input type="hidden" id="club_ID" name="club_ID" patter="\d{1,10}"
                    class="form-control" maxlength="10" autocomplete="off"/>
                  <!--<datalist id="clubs">
                  </datalist>-->
                  <div id="livesearchclubsedit"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-8">
                <div class="form-group">
                  <label for="email" class="form-control-label">E-mail</label><input
                    type="email" id="email" name="email"
                    placeholder="{{ trans('adminlte_lang::message.fillemail') }}"
                    class="form-control" maxlength="255" />
                </div>
              </div>
              <div class="col-xs-4">
                <div class="form-group">
                  <label for="phone" class="form-control-label">{{ trans('adminlte_lang::message.phone') }}</label><input
                    type="tel" id="phone" name="phone"
                    placeholder="{{ trans('adminlte_lang::message.fillphone') }}"
                    class="form-control" maxlength="13" />
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
