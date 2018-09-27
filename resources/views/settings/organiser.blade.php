@extends('adminlte::page')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.organiser') }}
@endsection
@section('contentheader_title')
	{{ trans('adminlte_lang::message.organisersettings') }}
@endsection
@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-success">
				<div class="box-header">
					<div class="row">
						<div class="col-xs-2">
						  <span><i class="fa fa-suitcase" aria-hidden="true"></i></span>
						  <h3 class="box-title">{{ trans('adminlte_lang::message.organiser') }}</h3>
						</div>
						<div class="col-xs-2"></div>
						<div class="col-xs-2"></div>
						<div class="col-xs-2"></div>
						<div class="col-xs-2"></div>
						<div class="col-xs-2"></div>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
				{{ csrf_field() }}
				<!-- Organiser name -->
        {!!Form::model($organiser, ['route' => ['organiser.update', $organiser[0]->organiser_ID]]) !!}
              	<div class="form-group">
                	<label for="orgname">{{ trans('adminlte_lang::message.nameofclub') }}:</label>
                	<div class="input-group">
                 		 <div class="input-group-addon">
                 		 	<i class="fa fa-university" aria-hidden="true"></i>
                  		</div>
                  		<input type="text" id="orgname" name="orgname"
                    pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ\.]{1,70}"
                    placeholder="{{ trans('adminlte_lang::message.fillclub') }}"
                    class="form-control pull-right" maxlength="70" autocomplete="off" value="{{ $organiser[0]->orgname }}" required/>
                    <input type="hidden" id="organiser_ID" name="organiser_ID" patter="\d{1,10}"
                    class="form-control pull-right" maxlength="10" autocomplete="off" value="{{ $organiser[0]->organiser_ID }}"/>
                	</div>
                	<!-- /.input group -->
              	</div>
              	<!-- /.form group -->
              	<!-- Organiser name 2 -->
              	<div class="form-group">
                	<label for="orgname2">{{ trans('adminlte_lang::message.nameofclub2') }}:</label>
                	<div class="input-group">
                 		 <div class="input-group-addon">
                 		 	<i class="fa fa-university" aria-hidden="true"></i>
                  		</div>
                  		<input type="text" id="orgname2" name="orgname2"
                    pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ\.,]{1,50}"
                    placeholder="{{ trans('adminlte_lang::message.fillclub') }}"
                    class="form-control pull-right" maxlength="50" autocomplete="off" value="{{ $organiser[0]->orgname2 }}"/>
                	</div>
                	<!-- /.input group -->
              	</div>
              	<!-- /.form group -->
              	<!-- Organiser ABBR -->
              	<div class="form-group">
                	<label for="organiser_abbr">{{ trans('adminlte_lang::message.abbr') }}:</label>
                	<div class="input-group">
                 		 <div class="input-group-addon">
                 		 	<i class="fa fa-tag" aria-hidden="true"></i>
                  		</div>
                  		<input type="text" id="organiser_abbr" name="organiser_abbr"
                    pattern="[a-zA-Z\-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ\.]{1,10}"
                    placeholder="{{ trans('adminlte_lang::message.fillclub') }}"
                    class="form-control pull-right" maxlength="50" autocomplete="off" value="{{ $organiser[0]->organiser_abbr }}"/>
                	</div>
                	<!-- /.input group -->
              	</div>
              	<!-- /.form group -->
              	<!-- Organiser street -->
              	<div class="form-group">
                	<label for="street">{{ trans('adminlte_lang::message.street') }}:</label>
                	<div class="input-group">
                 		 <div class="input-group-addon">
                 		 	<i class="fa fa-address-card" aria-hidden="true"></i>
                  		</div>
                  		<input type="text" id="street" name="street"
                    pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ\.0-9]{1,30}"
                    placeholder="{{ trans('adminlte_lang::message.fillclub') }}"
                    class="form-control pull-right" maxlength="30" autocomplete="off" value="{{ $organiser[0]->street }}"/>
                	</div>
                	<!-- /.input group -->
              	</div>
              	<!-- /.form group -->
              	<!-- Organiser city -->
              	<div class="form-group">
                	<label for="city">{{ trans('adminlte_lang::message.city') }}:</label>
                	<div class="input-group">
                 		 <div class="input-group-addon">
                 		 	<i class="fa fa-address-card" aria-hidden="true"></i>
                  		</div>
                  		<input type="text" id="city" name="city"
                    pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ\.]{1,30}"
                    placeholder="{{ trans('adminlte_lang::message.fillclub') }}"
                    class="form-control pull-right" maxlength="30" autocomplete="off" value="{{ $organiser[0]->city }}"/>
                	</div>
                	<!-- /.input group -->
              	</div>
              	<!-- /.form group -->
              	<!-- Organiser ZIP -->
              	<div class="form-group">
                	<label for="postalcode">{{ trans('adminlte_lang::message.zip') }}:</label>
                	<div class="input-group">
                 		 <div class="input-group-addon">
                 		 	<i class="fa fa-address-card" aria-hidden="true"></i>
                  		</div>
                  		<input type="text" id="postalcode" name="postalcode"
                    pattern="\d{3} ?\d{2}"
                    placeholder="{{ trans('adminlte_lang::message.fillzip') }}"
                    class="form-control pull-right" maxlength="6" autocomplete="off" value="{{ $organiser[0]->postalcode }}"/>
                	</div>
                	<!-- /.input group -->
              	</div>
              	<!-- /.form group -->
              	<!-- Organiser country -->
              	<div class="form-group">
                	<label for="country">{{ trans('adminlte_lang::message.country') }}:</label>
                	<div class="input-group">
                 		 <div class="input-group-addon">
                 		 	<i class="fa fa-address-card" aria-hidden="true"></i>
                  		</div>
                  		 <select name="country" id="country"
                    class="form-control">
                    <option disabled required>{{ trans('adminlte_lang::message.pleaseselect') }}</option>
                    @foreach($countries as $country)
                    @if ($organiser[0]->country == $country->country_code)
                      <option value="{{ $country->country_code }}" selected>{{ $country->name }}</option>
                    @else
                    	<option value="{{ $country->country_code }}">{{ $country->name }}</option>
                    @endif
                    @endforeach
                  </select>
                 	@if ($errors->has('country'))
                    <div class="error">{{ $errors->first('country') }}</div>
                   	@endif
                	</div>
                	<!-- /.input group -->
              	</div>
              	<!-- /.form group -->
              	<!-- Organiser TAXID -->
              	<div class="form-group">
                	<label for="taxid">{{ trans('adminlte_lang::message.taxid') }}:</label>
                	<div class="input-group">
                 		 <div class="input-group-addon">
                 		 	<i class="fa fa-chain-broken" aria-hidden="true"></i>
                  		</div>
                  		<input type="text" id="taxid" name="taxid"
                    pattern="^\d{8}$"
                    placeholder="{{ trans('adminlte_lang::message.filltaxid') }}"
                    class="form-control pull-right" maxlength="8" autocomplete="off" value="{{ $organiser[0]->taxid }}"/>
                	</div>
                	<!-- /.input group -->
              	</div>
              	<!-- /.form group -->
              	<!-- Organiser VATID -->
              	<div class="form-group">
                	<label for="vatid">{{ trans('adminlte_lang::message.vatid') }}:</label>
                	<div class="input-group">
                 		 <div class="input-group-addon">
                 		 	<i class="fa fa-chain-broken" aria-hidden="true"></i>
                  		</div>
                  		<input type="text" id="vatid" name="vatid"
                    pattern="^(CZ|SK)\d{8}$"
                    placeholder="{{ trans('adminlte_lang::message.fillvatid') }}"
                    class="form-control pull-right" maxlength="10" autocomplete="off" value="{{ $organiser[0]->vatid }}"/>
                	</div>
                	<!-- /.input group -->
              	</div>
              	<!-- /.form group -->
              	<!-- Organiser Bankaccount -->
              	<div class="form-group">
                	<label for="bankaccount">{{ trans('adminlte_lang::message.bankaccount') }}:</label>
                	<div class="input-group">
                 		 <div class="input-group-addon">
                 		 	<i class="fa fa-money" aria-hidden="true"></i>
                  		</div>
                  		<input type="text" id="bankaccount" name="bankaccount"
                    pattern="^[0-9\-]$"
                    placeholder="{{ trans('adminlte_lang::message.fillbankaccount') }}"
                    class="form-control pull-right" maxlength="50" autocomplete="off" value="{{ $organiser[0]->bankaccount }}"/>
                	</div>
                	<!-- /.input group -->
              	</div>
              	<!-- /.form group -->
              	<!-- Organiser Bankcode -->
              	<div class="form-group">
                	<label for="bankcode">{{ trans('adminlte_lang::message.bankcode') }}:</label>
                	<div class="input-group">
                 		 <div class="input-group-addon">
                 		 	<i class="fa fa-money" aria-hidden="true"></i>
                  		</div>
                  		<input type="text" id="bankcode" name="bankcode"
                    pattern="^[0-9]{4}$"
                    placeholder="{{ trans('adminlte_lang::message.fillbankcode') }}"
                    class="form-control pull-right" maxlength="4" autocomplete="off" value="{{ $organiser[0]->bankcode }}"/>
                	</div>
                	<!-- /.input group -->
              	</div>
              	<!-- /.form group -->
              	<!-- Organiser Web -->
              	<div class="form-group">
                	<label for="web">{{ trans('adminlte_lang::message.web') }}:</label>
                	<div class="input-group">
                 		 <div class="input-group-addon">
                 		 	<i class="fa fa-cloud" aria-hidden="true"></i>
                  		</div>
                  		<input type="url" id="web" name="web"
                    placeholder="{{ trans('adminlte_lang::message.fillweb') }}"
                    class="form-control pull-right" maxlength="50" autocomplete="off" value="{{ $organiser[0]->web }}"/>
                	</div>
                	<!-- /.input group -->
              	</div>
              	<!-- /.form group -->
                {{Form::button('<i class="fa fa-magic" aria-hidden="true"></i> '. trans('forms.submit'), ['class' => 'btn btn-success', 'type' => 'submit'])}}
        {!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        var url = "<?php echo route('runners-data.index') ?>";
    </script>
    <script src="/js/custom/runnersAjax.js"></script>
@endsection


