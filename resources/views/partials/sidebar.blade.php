<aside class="main-sidebar sidebar-light-orange elevation-2">
  <a href="{{url('/')}}" class="brand-link">
    <img src="{{asset('img/PKS_logo_lte.png')}}" alt="AdminLTE Logo" class="img-circle brand-image">
    <span class="brand-text font-weight-bolder">PKS</span>
  </a>
  <div class="sidebar">
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
          $active->verif = Request::segment(1) == 'verifikasi' ?'active':'';
          $active->kelompok = Request::segment(1) == 'kelompok' ?'active':'';
          $active->pencarian = Request::segment(1) == 'pencarian' ?'active':'';
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
                <i class="fas fa-id-card nav-icon orange"></i>
                <p>Anggota</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{url('/verifikasi')}}" class="nav-link {{$active->verif}}">
            <i class="nav-icon fas fa-check-square"></i>
            <p>
              Verifikasi
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{url('/kelompok')}}" class="nav-link {{$active->kelompok}}">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Kelompok
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{url('/pencarian')}}" class="nav-link {{$active->pencarian}}">
            <i class="nav-icon fas fa-search"></i>
            <p>
              Pencarian
            </p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>