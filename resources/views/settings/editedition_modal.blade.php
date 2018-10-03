 <!-- Create Item Modal -->
    <div class="modal fade" id="edit-edition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <form class="formedition" action="" method="PUT">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ trans('title.editedition') }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="form-group">
                            <label for="editionname" class=" form-control-label">{{ trans('title.editionname') }}</label><input type="text" id="editionname"
                                name="editionname" placeholder="{{ trans('title.filleditionname') }}"
                                pattern="[a-zA-Z \.\-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ0-9]{1,70}"
                                class="form-control" maxlength="70" required />
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="edition_nr" class=" form-control-label">{{ trans('title.edition_nr') }}</label><input
                                type="number" id="edition_nr" name="edition_nr"
                                placeholder="{{ trans('title.filledition') }}"
                                class="form-control" min="1" max="9999" step="1"
                                required />
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="race" class="form-control-label">{{ trans('title.race') }}</label>
                            <select name="race" id="race" class="form-control select2">
                            @foreach($races as $race)
                                <option value="{{ $race->race_ID }}" >{{ $race->racename }}</option>
                            @endforeach
                            </select>
                            @if ($errors->has('race'))
                              <div class="error">{{ $errors->first('race') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="date" class=" form-control-label">{{ trans('title.eventdate') }}</label><input type="date" id="date" name="date"
                                placeholder="{{ trans('title.filleventdate') }}"
                                class="form-control" min="2000-01-01" required />
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="firststart" class=" form-control-label">{{ trans('title.firststart') }}</label><input type="time" id="firststart"
                                name="firststart" placeholder="{{ trans('title.fillfirststart') }}"
                                pattern="\d{1,2}:\d{2}(:\d{2})?"
                                class="form-control" required />
                        </div>
                    </div>
                    <div class="col-xs-5">
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
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="gps" class=" form-control-label">{{ trans('title.gps') }}</label><input
                                type="text" id="gps" name="gps"
                                placeholder="{{ trans('title.fillgps') }}"
                                pattern="/^(\-?\d+(\.\d+)?)N?,\s*(\-?\d+(\.\d+)?)E?$/"
                                class="form-control" maxlength="100" required/>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="eventoffice" class=" form-control-label">{{ trans('title.eventofficetill') }}</label><input type="datetime-local"
                                id="eventoffice" name="eventoffice"
                                placeholder="{{ trans('title.filleventofficetime') }}"
                                class="form-control" required />
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="web" class=" form-control-label">{{ trans('title.web') }}</label><input
                                type="url" id="web" name="web"
                                placeholder="{{ trans('title.fillweb') }}"
                                class="form-control" maxlength="50" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5">
                        <div class="form-group">
                            <label for="entrydate1" class=" form-control-label">{{ trans('title.entrydate1') }}</label><input type="datetime-local"
                                id="entrydate1" name="entrydate1"
                                placeholder="{{ trans('title.fillentrydate1') }}"
                                class="form-control" min="2000-01-01" required />
                        </div>
                    </div>

                    <div class="col-xs-7">
                        <div class="form-group">
                            <label for="competition" class=" form-control-label">{{ trans('title.competition') }}</label><input
                                type="text" id="competition" name="competition"
                                placeholder="{{ trans('title.fillcompetition') }}"
                                pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ\.]{1,155}"
                                class="form-control" maxlength="155" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="eventdirector" class=" form-control-label">{{ trans('title.eventdirector') }}</label><input type="text" id="eventdirector"
                                name="eventdirector"
                                placeholder="{{ trans('title.filleventdirector') }}"
                                pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,50}"
                                class="form-control" maxlength="50" />
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="mainreferee" class=" form-control-label">{{ trans('title.mainreferee') }}</label><input type="text" id="mainreferee"
                                name="mainreferee"
                                placeholder="{{ trans('title.fillmainreferee') }}"
                                pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,50}"
                                class="form-control" maxlength="50" />
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="entriesmanager" class=" form-control-label">{{ trans('title.entriesmanager') }}</label><input type="text" id="entriesmanager"
                                name="entriesmanager"
                                placeholder="{{ trans('title.fillentriesmanager') }}"
                                pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,50}"
                                class="form-control" maxlength="50" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="jury1" class=" form-control-label">{{ trans('title.jury1') }}</label><input
                                type="text" id="jury1" name="jury1"
                                placeholder="{{ trans('title.filljury1') }}"
                                pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,50}"
                                class="form-control" maxlength="50" />
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="jury2" class=" form-control-label">{{ trans('title.jury2') }}</label><input
                                type="text" id="jury2" name="jury2"
                                placeholder="{{ trans('title.filljury2') }}"
                                pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,50}"
                                class="form-control" maxlength="50" />
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="jury3" class=" form-control-label">{{ trans('title.jury3') }}</label><input
                                type="text" id="jury3" name="jury3"
                                placeholder="{{ trans('title.filljury3') }}"
                                pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,50}"
                                class="form-control" maxlength="50" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-default" data-dismiss="modal">{{ trans('adminlte_lang::message.close') }}</button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="btn btn-primary crud-edition-submit-edit" value="{{ trans('adminlte_lang::message.submit') }}">
            </div>
        </div>
        </form>
    </div>
</div>
