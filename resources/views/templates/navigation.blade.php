
  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CSIA</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>CSIA</b>stekindo</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('AdminLTE-2.3.11/dist/img/avatar.png') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{\Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div >
                  <!-- <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
                  <form method="post" action="{{ url('logout') }}" style="display: inline">
                      {{ csrf_field() }}
                    <button class="btn btn-default" type="submit">Sign Out</button>
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('AdminLTE-2.3.11/dist/img/avatar.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{\Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview {{Request::is('/') ? 'active' : ''}}">
          <a href="{{ url('') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        @if(Auth::user()->role_id == 1 
        || Auth::user()->role_id == 2
        || Auth::user()->role_id == 3 
        || Auth::user()->role_id == 4
        || Auth::user()->role_id == 5)
        <li class="{{Request::is('divisi') ? 'active' : ''}}">
            <a href="{{ url('divisi') }}">
              <i class="fa fa-tasks"></i> <span>Divisi</span>
            </a>
        </li>
        @endif

        @if(Auth::user()->role_id==1)
        <li class="{{Request::is('users') ? 'active' : ''}}">
            <a href="{{ url('users') }}">
              <i class="fa fa-users"></i> <span>Kelola User</span>
            </a>
        </li>
        @endif

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
