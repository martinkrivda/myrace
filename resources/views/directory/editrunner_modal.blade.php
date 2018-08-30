<!-- MODAL EDIT -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <form class="formrunner" action="{{url('/do_editrunner')}}/{{$runner->runner_ID}}" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ trans('adminlte_lang::message.close') }}"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">{{ trans('adminlte_lang::message.editrunner') }}</h4>
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
          <input type="hidden" name="runner_ID" value="{{ $runner->runner_ID }}">
		  <div class="modal-body">
			<div class="row">
				<div class="col-xs-6">
					<div class="form-group">
						<label for="firstname" class=" form-control-label">{{ trans('adminlte_lang::message.firstname') }}</label><input type="text" id="firstname"
							name="firstname" placeholder="{{ trans('adminlte_lang::message.fillfirstname') }}"
							pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,50}"
							value="{{ $runner->firstname }}"
							class="form-control" maxlength="50" required />
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<label for="lastname" class="form-control-label">{{ trans('adminlte_lang::message.lastname') }}</label><input
							type="text" id="lastname" name="lastname"
							placeholder="{{ trans('adminlte_lang::message.filllastname') }}"
							pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ]{1,255}"
							value="{{ $runner->lastname }}"
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
							value="{{ $runner->vintage }}"
							class="form-control" required />
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label for="gender" class="form-control-label">{{ trans('adminlte_lang::message.gender') }}</label><select
							name="gender" id="gender"
							class="form-control">
							<option value="0">{{ trans('adminlte_lang::message.pleaseselect') }}</option>
							 @if($runner->gender=='male')
							<option value="male" selected>{{ trans('adminlte_lang::message.male') }}</option>
							<option value="female">{{ trans('adminlte_lang::message.female') }}</option>
							@else
							<option value="male">{{ trans('adminlte_lang::message.male') }}</option>
							<option value="female" selected>{{ trans('adminlte_lang::message.female') }}</option>
							@endif
						</select>
					</div>
				</div>
				<div class="col-xs-5">
					<div class="form-group">
						<label for="club" class="form-control-label">{{ trans('adminlte_lang::message.club') }}</label><input
							type="text" id="club" name="club" list="clubs"
							pattern="[a-zA-Z \-ěščřžýáíéóúůďťňĎŇŤŠČŘŽÝÁÍÉÚŮ\.]{1,70}"
							placeholder="{{ trans('adminlte_lang::message.fillclub') }}"
							value="{{ $runner->club }}"
							class="form-control" maxlength="70" />
						<datalist id="clubs">
						</datalist>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<div class="form-group">
						<label for="email" class="form-control-label">E-mail</label><input
							type="email" id="email" name="email"
							placeholder="{{ trans('adminlte_lang::message.fillemail') }}"
							value="{{ $runner->email }}"
							class="form-control" maxlength="255" />
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group">
						<label for="phone" class="form-control-label">{{ trans('adminlte_lang::message.phone') }}</label><input
							type="tel" id="phone" name="phone"
							placeholder="{{ trans('adminlte_lang::message.fillphone') }}"
							value="{{ $runner->phone }}"
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
							<option value="0">{{ trans('adminlte_lang::message.pleaseselect') }}</option>
							@foreach($countries as $country)
							@if($country->country_code===$runner->country)
								<option value="{{ $country->country_code }}" selected>{{ $country->name }}</option>
							@else
								<option value="{{ $country->country_code }}" >{{ $country->name }}</option>
							@endif
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
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('adminlte_lang::message.close') }}</button>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="submit" class="btn btn-primary" value="{{ trans('adminlte_lang::message.savechanges') }}">
        </div>
        </form> 
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <script type="text/javascript">
   $.ajaxSetup({
    headers: {
     'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
   });
   $('.formrunner').submit(function(event){
      event.preventDefault();
      var data = $('.formrunner').serializeArray();
      $.ajax({
        url : $('.formrunner').attr('action'),
        method : 'POST',
        data : data,
        success : function(response) {
          // console.log(response);
          if (response.status == 'error') {
			console.log(response);
            var html_error = '';
            //html_error += '<ul>';
            $.each(response.message, function (error_key, error_message){
              //html_error += error_key;
              $.each(error_message, function (message){
                html_error += this +' ';
              });
            });
            //html_error += '</ul>';
			swal({
				title: "Oops... Something went wrong!",
				type: 'warning',
				html:  html_error
			});
            $('.alert-ajax').html(html_error);
            $('.alert-ajax').show();
          }else{
            window.location.replace('/runners');
          }
        }
      });
    });
  </script>