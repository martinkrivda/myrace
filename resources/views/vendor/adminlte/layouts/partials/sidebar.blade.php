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
                    <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip" title="{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
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

            @foreach($menu as $nav)
                <li class="treeview">
                    <a href="#"><i class='fa fa-rocket'></i> <span>{{$nav->edition_nr}}. {{trans('menu.editionof')}} {{$nav->race_abbr}}</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ URL::to('race/information/' . $nav->edition_ID) }}"><i class="fa fa-puzzle-piece" aria-hidden="true"></i> {{ trans('menu.information') }}</a></li>
                        <li><a href="{{ URL::to('race/'.$nav->edition_ID.'/category') }}"><i class="fa fa-newspaper-o" aria-hidden="true"></i> {{ trans('menu.category') }}</a></li>
                        @can('registrations.view', Auth::user())
                        <li><a href="{{ URL::to('race/'.$nav->edition_ID.'/registration') }}"><i class="fa fa-address-card-o" aria-hidden="true"></i> {{ trans('menu.registrations') }}</a></li>
                        @endcan
                        <li><a href="{{ URL::to('race/'. $nav->edition_ID .'/payment') }}"><i class="fa fa-money" aria-hidden="true"></i> {{ trans('menu.payments') }}</a></li>
                        <li><a href="{{ URL::to('race/'. $nav->edition_ID .'/rfidreader') }}"><i class="fa fa-rss" aria-hidden="true"></i> {{ trans('menu.rfidreader') }}</a></li>
                        <li><a href="{{ URL::to('race/'. $nav->edition_ID .'/startlist') }}"><i class="fa fa-list" aria-hidden="true"></i> {{ trans('menu.startlist') }}</a></li>
                        @can('results.view', Auth::user())
                        <li><a href="{{ URL::to('race/'. $nav->edition_ID .'/resultlist') }}"><i class="fa fa-list-alt" aria-hidden="true"></i> {{ trans('menu.resultlist') }}</a></li>
                        @endcan
                        <li><a href="{{ URL::to('race/speaker/' . $nav->edition_ID) }}"><i class="fa fa-microphone" aria-hidden="true"></i> {{ trans('menu.speaker') }}</a></li>
                        @can('registrations.audit', Auth::user())
                        <li><a href="{{ URL::to('race/'. $nav->edition_ID .'/history') }}"><i class="fa fa-history" aria-hidden="true"></i> {{ trans('menu.history') }}</a></li>
                        @endcan
                    </ul>
                </li>
            @endforeach


			<li class="header">{{ trans('adminlte_lang::message.directory') }}</li>
            <li class="treeview">
                <a href="#"><i class='fa fa-book'></i> <span>{{ trans('adminlte_lang::message.registrations') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('runners') }}"><i class='fa fa-user'></i>{{ trans('adminlte_lang::message.runners') }}</a></li>
                    <li><a href="{{ url('clubs') }}"><i class='fa fa-home'></i>{{ trans('adminlte_lang::message.clubs') }}</a></li>
                </ul>
            </li>
			<li class="header">{{ trans('adminlte_lang::message.settings') }}</li>
			 <li class="treeview">
                <a href="#"><i class='fa fa-gears'></i> <span>{{ trans('adminlte_lang::message.preferences') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('users') }}"><i class='fa fa-users'></i>{{ trans('adminlte_lang::message.users') }}</a></li>
                    <li><a href="{{ url('races') }}"><i class='fa fa-trophy'></i>{{ trans('adminlte_lang::message.races_sml') }}</a></li>
					<li><a href="{{ url('tags') }}"><i class='fa fa-tags'></i>{{ trans('adminlte_lang::message.tags') }}</a></li>
                </ul>
            </li>
			<li><a href="{{ url('organiser') }}"><i class='fa fa-briefcase'></i> <span>{{ trans('adminlte_lang::message.organiser') }}</span></a></li>
            <li><a href="{{ url('releasenotes') }}"><i class='fa fa-refresh'></i> <span>{{ trans('menu.releasenotes') }}</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
