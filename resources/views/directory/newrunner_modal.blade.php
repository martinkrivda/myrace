 <!-- Create Item Modal -->
    <div class="modal fade" id="create-runner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <form class="formrunner" action="{{ route('runners-data.store') }}" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">{{ trans('adminlte_lang::message.addrunner') }}</h4>
          </div>
          <div class="modal-body">
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
                    type="text" id="club" name="club"
                    pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ\.]{1,70}"
                    placeholder="{{ trans('adminlte_lang::message.fillclub') }}"
                    class="form-control" maxlength="70" autocomplete="off"/>
                    <input type="hidden" id="club_ID" name="club_ID" patter="\d{1,10}"
                    class="form-control" maxlength="10" autocomplete="off"/>
                  <!--<datalist id="clubs" list="clubs">
                  </datalist>-->
                  <div id="livesearchclubs"></div>
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
            <div class="row">
              <div class="col-xs-5">
                <div class="form-group">
                  <label for="country" class="form-control-label">{{ trans('adminlte_lang::message.country') }}</label>
                  <select name="country" id="country"
                    class="form-control">
                    <option disabled selected required>{{ trans('adminlte_lang::message.pleaseselect') }}</option>
                    @foreach($countries as $country)
                      <option value="{{ $country->country_code }}" >{{ $country->name }}</option>
                    @endforeach

                </select>
                @if ($errors->has('country'))
                  <div class="error">{{ $errors->first('country') }}</div>
                @endif
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
          <button type="reset" class="btn btn-default" data-dismiss="modal">{{ trans('adminlte_lang::message.close') }}</button>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="submit" class="btn btn-primary crud-submit" value="{{ trans('adminlte_lang::message.submit') }}">
        </div>
        </div>
        </form>
      </div>
    </div>
