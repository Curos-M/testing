<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          {{$username??null}}
          <i class="fa fa-caret-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          @if($anggota_id != 0)
          <a href="{{url('/')}}" class="dropdown-item">
            Profile
          </a>
          <div class="dropdown-divider"></div>
          @endif
          <a href="#" class="dropdown-item">
            Ganti Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{url('logout')}}" class="dropdown-item">
            Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>