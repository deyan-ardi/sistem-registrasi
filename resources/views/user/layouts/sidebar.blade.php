      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

          <!-- Sidebar - Brand -->
          <a class="sidebar-brand d-flex align-items-center justify-content-center mb-3 mt-3" href="/">
              @if (!empty($setting->image_sidebar))
                  <div class="sidebar-brand-icon">
                      <img width="75%" src="{{ asset('storage/' . $setting->image_sidebar) }}" alt="Kosong">
                  </div>
              @else
                  <div class="sidebar-brand-text mx-3">{{ $setting->name_system }}</div>
              @endif
          </a>

          <!-- Divider -->
          <hr class="sidebar-divider my-0">

          <!-- Nav Item - Dashboard -->
          <li class="nav-item{{ $sidebar == 1 ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('home') }}">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span></a>
          </li>

          <!-- Divider -->

          @if (Auth::check() && Auth::user()->level == 'admin')
              <hr class="sidebar-divider">
              <!-- Heading -->
              <div class="sidebar-heading">
                  Pengaturan Admin
              </div>
              <li class="nav-item{{ $sidebar == 2 ? ' active' : '' }}">
                  <a class="nav-link" href="{{ route('member') }}">
                      <i class="fas fa-fw fa-user-circle"></i>
                      <span>Manajemen Member</span></a>
              </li>

              <li class="nav-item{{ $sidebar == 5 ? ' active' : '' }}">
                  <a class="nav-link" href="{{ route('setting') }}">
                      <i class="fas fa-fw fa-cog"></i>
                      <span>Setting Web App</span></a>
              </li>
          @endif

          <!-- Divider -->
          <hr class="sidebar-divider">
          <!-- Nav Item - Tables -->
          <li class="nav-item{{ $sidebar == 3 ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('edit-profil') }}">
                  <i class="fas fa-fw fa-user-cog"></i>
                  <span>Informasi Profil</span></a>
          </li>
          <li class="nav-item{{ $sidebar == 6 ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('info') }}">
                  <i class="fas fa-fw fa-info-circle"></i>
                  <span>Tentang Web</span></a>
          </li>

          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">

          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
              <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>

      </ul>
      <!-- End of Sidebar -->
