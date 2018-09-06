 <!-- Create Item Modal -->
    <div class="modal fade" id="create-club" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <form class="formclub" action="{{ route('clubs-data.store') }}" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">{{ trans('adminlte_lang::message.addclub') }}</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-xs-5">
                <div class="form-group">
                  <label for="clubname" class=" form-control-label">{{ trans('adminlte_lang::message.nameofclub') }}</label> <input type="text" id="clubname"
                    name="clubname" placeholder="{{ trans('adminlte_lang::message.fillnameofclub') }}"
                    pattern="[a-zA-Z \.\-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,70}"
                    class="form-control" maxlength="70" required />
                </div>
              </div>
              <div class="col-xs-4">
                <div class="form-group">
                  <label for="clubname2" class=" form-control-label">{{ trans('adminlte_lang::message.nameofclub2') }}</label><input type="text" id="clubname2"
                    name="clubname2" placeholder="{{ trans('adminlte_lang::message.fillnameofclub2') }}"
                    pattern="[a-zA-Z \.\-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,50}"
                    class="form-control" maxlength="50" />
                </div>
              </div>
              <div class="col-xs-3">
                <div class="form-group">
                  <label for="clubabbr" class=" form-control-label">{{ trans('adminlte_lang::message.clubabbr') }}</label><input
                    type="text" id="clubabbr" name="clubabbr"
                    placeholder="{{ trans('adminlte_lang::message.fillclubabbr') }}"
                    pattern="[a-zA-Z\-0-9]{3,10}"
                    value="<?php echo htmlspecialchars(@$_POST['clubcode']); ?>"
                    class="form-control" maxlength="10" required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-5">
                <div class="form-group">
                  <label for="street" class=" form-control-label">{{ trans('adminlte_lang::message.street') }}</label><input
                    type="text" id="street" name="street"
                    placeholder="{{ trans('adminlte_lang::message.fillstreet') }}"
                    pattern="[a-zA-Z \.\-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ0-9]{1,30}"
                    class="form-control" maxlength="30" />
                </div>
              </div>
              <div class="col-xs-4">
                <div class="form-group">
                  <label for="city" class=" form-control-label">{{ trans('adminlte_lang::message.city') }}</label><input
                    type="text" id="city" name="city"
                    placeholder="{{ trans('adminlte_lang::message.fillcity') }}"
                    pattern="[a-zA-Z \.\-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ0-9]{1,30}"
                    class="form-control" maxlength="30" />
                </div>
              </div>
              <div class="col-xs-3">
                <div class="form-group">
                  <label for="postalcode" class="form-control-label">{{ trans('adminlte_lang::message.zip') }}</label><input
                    type="text" id="postalcode" name="postalcode" pattern="\d{3} ?\d{2}"
                    placeholder="{{ trans('adminlte_lang::message.fillzip') }}"
                    class="form-control" maxlength="6" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-8">
                <div class="form-group">
                  <label for="email" class="form-control-label">E-mail</label><input
                    type="email" id="email" name="email"
                    placeholder="{{ trans('adminlte_lang::message.fillemail') }}"
                    class="form-control" maxlength="100" />
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
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="taxid" class="form-control-label">{{ trans('adminlte_lang::message.taxid') }}</label><input
                    type="text" id="taxid" name="taxid"
                    placeholder="{{ trans('adminlte_lang::message.filltaxid') }}" pattern="^\d{8}$"
                    class="form-control" maxlength="8" />
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="vatid" class="form-control-label">{{ trans('adminlte_lang::message.vatid') }}</label><input
                    type="text" id="vatid" name="vatid"
                    placeholder="{{ trans('adminlte_lang::message.fillvatid') }}" pattern="^(CZ|SK)\d{8}$"
                    class="form-control" maxlength="10" />
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
              <div class="col-xs-5">
                <div class="form-group">
                  <label for="webpage" class=" form-control-label">Web</label><input
                    type="url" id="webpage" name="webpage"
                    placeholder="{{ trans('adminlte_lang::message.fillweb') }}"
                    pattern="^(http\:\/\/|https\:\/\/)?([a-z0-9][a-z0-9\-]*\.)+[a-z0-9][a-z0-9\-]*$"
                    class="form-control" maxlength="50" />
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
