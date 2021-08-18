<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="../../index3.html" class="brand-link">
    <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{env('APP_NAME')}}</span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
          <a href="#" class="d-block">{{$username??null}}</a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-database"></i>
            <p>
              Master Data
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('/user')}}" class="nav-link">
                <i class="fas fa-user nav-icon"></i>
                <p>User</p>
              </a>
            <li class="nav-item">
              <a href="{{url('/role')}}" class="nav-link">
                <i class="fas fa-id-badge nav-icon"></i>
                <p>Peran</p>
              </a>
            </li>
            </li>
            <li class="nav-item">
              <a href="{{url('/anggota')}}" class="nav-link">
                <i class="fas fa-users nav-icon"></i>
                <p>Anggota</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</aside>