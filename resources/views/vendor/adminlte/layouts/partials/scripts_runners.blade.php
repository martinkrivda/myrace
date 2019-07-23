	    <link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
	  	 <!-- jQuery -->
        <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>

		 <!-- popper -->
        <script src="{{ asset('js/popper.min.js') }}"></script>
		 <!-- plugins -->
        <script src="{{ asset('js/plugins.js') }}"></script>
		<!-- SweetAlerts -->
        <script src="{{ asset('js/sweetalert2.all.js') }}"></script>

        <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
        <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
        <!-- DataTables -->
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.bootstrap.min.js') }}" charset="utf-8"></script>

        <link href="{{ asset('css/bootstrap-switch.min.css') }}" rel="stylesheet">
        <script src="{{ asset('js/bootstrap-switch.min.js') }}"></script>

        <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
        <script src="{{ asset('js/select2.min.js') }}"></script>
        <script type = "text/javascript">
          var url = window.location;
          // for sidebar menu entirely but not cover treeview
          $('ul.sidebar-menu a').filter(function() {
          return this.href == url;
          }).parent().addClass('active');
          // for treeview
          $('ul.treeview-menu a').filter(function() {
          return this.href == url;
          }).closest('.treeview').addClass('active');
        </script>
