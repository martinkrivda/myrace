 <!-- Create Item Modal -->
    <div class="modal fade" id="create-race" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <form class="formrace" action="{{ route('races-data.store') }}" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ trans('title.addrace') }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="racename" class=" form-control-label">{{ trans('title.racename') }}</label><input type="text" id="racename"
                                name="racename" placeholder="{{ trans('title.fillracename') }}"
                                pattern="[a-zA-Z \.\-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ0-9]{1,70}"
                                class="form-control" maxlength="70" required />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="location" class=" form-control-label">{{ trans('title.location') }}</label><input
                                type="text" id="location" name="location"
                                placeholder="{{ trans('title.filllocation') }}"
                                pattern="[a-zA-Z \.\-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ0-9]{1,50}"
                                class="form-control" maxlength="50" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5">
                        <div class="form-group">
                            <label for="organiser" class=" form-control-label">{{ trans('title.organiser') }}</label>
                            <select name="organiser" id="organiser" class="form-control select2">
                            @foreach($organisers as $organiser)
                                <option value="{{ $organiser->organiser_ID }}" >{{ $organiser->orgname }}</option>
                            @endforeach
                            </select>
                            @if ($errors->has('organiser'))
                              <div class="error">{{ $errors->first('organiser') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="form-group">
                            <label for="web" class=" form-control-label">{{ trans('title.web') }}</label><input
                                type="url" id="web" name="web"
                                placeholder="{{ trans('title.fillweb') }}"
                                class="form-control" maxlength="50" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="form-group">
                            <label for="email" class=" form-control-label">{{ trans('title.email') }}</label><input
                                type="email" id="email" name="email"
                                placeholder="{{ trans('title.fillemail') }}"
                                class="form-control" maxlength="100" />
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="phone" class=" form-control-label">{{ trans('title.phone') }}</label><input
                                type="tel" id="phone" name="phone"
                                placeholder="{{ trans('title.fillphone') }}"
                                class="form-control" maxlength="13" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-default" data-dismiss="modal">{{ trans('adminlte_lang::message.close') }}</button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="btn btn-primary crud-race-submit" value="{{ trans('adminlte_lang::message.submit') }}">
            </div>
        </div>
        </form>
    </div>
</div>
