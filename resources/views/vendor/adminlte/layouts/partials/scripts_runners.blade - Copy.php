	  <!--<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">-->
	  <link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
	  	 <!-- jQuery -->
        <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>

		 <!-- popper -->
        <script src="{{ asset('js/popper.min.js') }}"></script>
		 <!-- plugins -->
        <script src="{{ asset('js/plugins.js') }}"></script>
        <!-- DataTables -->
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
		<!-- SweetAlerts -->
        <script src="{{ asset('js/sweetalert2.all.js') }}"></script>
		@include('sweetalert::alert')
		<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
		<script type="text/javascript">
 $.ajaxSetup({
  headers: {
   'X-CSRF-TOKEN': $('input[name="_token"]').val()
  }
 });
  </script>
	  <script type="text/javascript">
  $(document).ready(function() {
    $('#runners-table').DataTable({
		"columnDefs":[
              	   {
              	    "targets":[8],
              	    "orderable":false,
              	   },
              	  ],
	});
} );
// modal create runner
	$('.modalCreateTrigger').click(function(event){
		console.log('Modal open');
    event.preventDefault();
        $.ajax({
            url     : "{{url('modal_newrunner')}}",
            method  : 'POST',
            success : function(response){
                $('.modalKu').html(response);
                $('#addRunner').modal('show');
            }
        });
  });
  // MODAL EDIT
    function modalEditTriger(runner_ID){
      $.ajax({
        url     : "{{url('modal_editrunner')}}",
        method  : 'POST',
        data    : {
          'runner_ID' : runner_ID
        },
        success : function(response){
          // console.log(response);
          $('.modalKu').html(response);
          $('#myModal').modal('show');
        }
      });
	}
	function modalDeleteTriger(runner_ID){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax(
    {
        url: "runners/delete/"+runner_ID,
        type: 'delete', // replaced from put
        dataType: "JSON",
        data: {
            "runner_ID": runner_ID // method and token not needed in data
        },
        success: function (response)
        {
            console.log(response); // see the reponse sent
        },
        error: function(xhr) {
         console.log(xhr.responseText); // this line will save you tons of hours while debugging
        // do something here because of error
       }
    });
}
$(document).on('click', '#delete', function (e) {
    e.preventDefault();
    var runner_ID = $(this).data('runner_ID');
    swal({
            title: "Are you sure!",
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes!",
            showCancelButton: true,
        },
        function() {
			$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
            $.ajax({
                type: "POST",
                url: "{{url('runners/delete')}}",
                data: {'runner_ID':runner_ID},
                success: function (response) {
					console.log(response); // see the reponse sent
                       $('.runner' + $('.runner_ID').text()).remove();
                    }         
            });
    });
});
  </script>