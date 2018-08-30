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
    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
		<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
      var url = "<?php echo route('runners-data.index')?>";
    </script>
    <script src="/js/runnersAjax.js"></script> 
