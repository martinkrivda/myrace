<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ url('home') }}"><i class='fa fa-dashboard'></i> <span>{{ trans('adminlte_lang::message.dashboard') }}</span></a></li>
			<li class="header">{{ trans('adminlte_lang::message.races') }}</li>
            <li><a href="#"><i class='fa fa-laptop'></i> <span>25. ročník MCVV</span></a></li>
			<li class="header">{{ trans('adminlte_lang::message.directory') }}</li>
            <li class="treeview">
                <a href="#"><i class='fa fa-book'></i> <span>{{ trans('adminlte_lang::message.registrations') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('runners') }}"><i class='fa fa-user'></i>{{ trans('adminlte_lang::message.runners') }}</a></li>
                    <li><a href="{{ url('clubs') }}"><i class='fa fa-home'></i>{{ trans('adminlte_lang::message.clubs') }}</a></li>
                </ul>
            </li>
			<li><a href="{{ url('email') }}"><i class='fa fa-envelope'></i> <span>{{ trans('adminlte_lang::message.email') }}</span></a></li>
			<li class="header">{{ trans('adminlte_lang::message.settings') }}</li>
			 <li class="treeview">
                <a href="#"><i class='fa fa-gears'></i> <span>{{ trans('adminlte_lang::message.preferences') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('users') }}"><i class='fa fa-users'></i>{{ trans('adminlte_lang::message.users') }}</a></li>
                    <li><a href="{{ url('races') }}"><i class='fa fa-trophy'></i>{{ trans('adminlte_lang::message.races_sml') }}</a></li>
					<li><a href="{{ url('tags') }}"><i class='fa fa-tags'></i>{{ trans('adminlte_lang::message.tags') }}</a></li>
					<li><a href="{{ url('advancedsetting') }}"><i class='fa fa-wrench'></i>{{ trans('adminlte_lang::message.advanced') }}</a></li>
                </ul>
            </li>
			<li><a href="{{ url('organizer') }}"><i class='fa fa-briefcase'></i> <span>{{ trans('adminlte_lang::message.organizer') }}</span></a></li>
			<li><a href="{{ url('newsletter') }}"><i class='fa fa-bullhorn'></i> <span>{{ trans('adminlte_lang::message.newsletters') }}</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
