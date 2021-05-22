      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

          <!-- Sidebar - Brand -->
          <a class="sidebar-brand d-flex align-items-center justify-content-center mb-3 mt-3" href="/">
              @if (!empty($setting->image_system))
                  <div class="sidebar-brand-icon">
                      <img style="height:85px; width:85px; object-fit:cover; object-position:center; "
                          src="{{ asset('storage/' . $setting->image_system) }}" class="rounded-circle" alt="Kosong">
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

              <li class="nav-item{{ $sidebar == 3 ? ' active' : '' }}">
                  <a class="nav-link" href="{{ route('vote') }}">
                      <i class="fas fa-fw fa-vote-yea"></i>
                      <span>Manajemen Evoting</span></a>
              </li>

              <li class="nav-item{{ $sidebar == 5 ? ' active' : '' }}">
                  <a class="nav-link" href="{{ route('setting') }}">
                      <i class="fas fa-fw fa-cog"></i>
                      <span>Setting Web App</span></a>
              </li>
          @endif

          <!-- Divider -->
          <hr class="sidebar-divider">

          <!-- Heading -->
          <div class="sidebar-heading">
              Fitur Pengguna
          </div>
          @if (!empty($activity))
              <li class="nav-item{{ $sidebar == 4 ? ' active' : '' }}">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                      aria-expanded="true" aria-controls="collapseThree">
                      <i class="fas fa-fw fa-chart-area"></i>
                      <span>Voting Kandidat</span>
                  </a>
                  <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                          <h6 class="collapse-header">Layanan:</h6>
                          <a class="collapse-item" href="{{ route('voting-activity') }}">Surat Suara</a>
                          <a class="collapse-item" href="{{ route('live-count') }}">Live Count</a>
                      </div>
                  </div>
              </li>
          @endif

          <!-- Nav Item - Tables -->
          <li class="nav-item{{ $sidebar == 6 ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('info') }}">
                  <i class="fas fa-fw fa-info-circle"></i>
                  <span>Info Web App</span></a>
          </li>

          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">

          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
              <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>

      </ul>
      <!-- End of Sidebar -->
