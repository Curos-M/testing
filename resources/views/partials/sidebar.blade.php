<aside class="main-sidebar sidebar-light-orange elevation-2">
  <a href="../../index3.html" class="brand-link">
    <img src="{{asset('img/PKS_logo_ltes.png')}}" alt="AdminLTE Logo" class="brand-image">
    <span class="brand-text font-weight-light">&nbsp;</span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-1" alt="User Image">
      </div>
      <div class="info">
          <a href="#" class="d-block">{{$username??null}}</a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <!-- sesi -->
        <?php
          $active = new \stdClass;
          $active->dash = Request::segment(1) == null ?'active':'';
          $active->master['active'] = (Request::segment(1) == 'user' || Request::segment(1) == 'role' || Request::segment(1) == 'anggota' ) ?'active':'';
          $active->master['open'] = (Request::segment(1) == 'user' || Request::segment(1) == 'role' || Request::segment(1) == 'anggota' ) ?'menu-is-opening menu-open':'';
          $active->master['user'] = Request::segment(1) == 'user' ?'active':'';
          $active->master['role'] = Request::segment(1) == 'role' ?'active':'';
          $active->master['anggota'] = Request::segment(1) == 'anggota' ?'active':'';
        ?>
        <!-- endsesi -->
        <li class="nav-item">
          <a href="{{url('/')}}" class="nav-link {{$active->dash}}">
            <i class="nav-icon fas fa-th-list"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item {{$active->master['open']}}">
          <a href="#" class="nav-link {{$active->master['active']}}">
            <i class="nav-icon fas fa-database"></i>
            <p>
              Master Data
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('/user')}}" class="nav-link {{$active->master['user']}}">
                <i class="fas fa-user nav-icon orange"></i>
                <p>User</p>
              </a>
            <li class="nav-item">
              <a href="{{url('/role')}}" class="nav-link {{$active->master['role']}}">
                <i class="fas fa-id-badge nav-icon orange"></i>
                <p>Peran</p>
              </a>
            </li>
            </li>
            <li class="nav-item">
              <a href="{{url('/anggota')}}" class="nav-link {{$active->master['anggota']}}">
                <i class="fas fa-users nav-icon orange"></i>
                <p>Anggota</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</aside>