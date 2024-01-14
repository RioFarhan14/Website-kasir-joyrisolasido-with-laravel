<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center justify-content-md-start" href="#">
    <div class="sidebar-brand-icon rotate-n-15">
      <img src="{{ asset('img/admin.png') }}" alt="">
    </div>
    <div class="sidebar-brand-text mx-3">Admin</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider mb-3" />
  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ $activeSidebar == 'dashboard' ? 'active' : '' }} mx-md-2">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <img src="{{ asset('img/dashboard.png') }}" alt="" />
      <span>Dashboard</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider" />

  <!-- Nav Item - Pembayaran -->
  <li class="nav-item {{ $activeSidebar == 'pembayaran' ? 'active' : '' }} mx-md-2">
    <a class="nav-link" href="{{ route('pembayaran') }}">
      <img src="{{ asset('img/pembayaran.png') }}" alt="" />
      <span>Pembayaran</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider" />

  <!-- Nav Item - Inventori -->
  <li class="nav-item {{ $activeSidebar == 'inventori' ? 'active' : '' }} mx-md-2">
    <a class="nav-link" href="{{ route('inventori') }}">
      <img src="{{ asset('img/inventori.png') }}" alt="" />
      <span>Inventori</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider" />

  <!-- Nav Item - Data Pelanggan -->
  <li class="nav-item {{ $activeSidebar == 'customer' ? 'active' : '' }} mx-md-2">
    <a class="nav-link" href="{{ route('customer') }}">
      <img src="{{ asset('img/table.png') }}" alt="" />
      <span>Data Pelanggan</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider" />

  <!-- Nav Item - Laporan -->
  <li class="nav-item {{ $activeSidebar == 'laporan' ? 'active' : '' }} mx-md-2">
    <a class="nav-link" href="{{ route('laporan') }}">
      <img src="{{ asset('img/laporan.png') }}" alt="" />
      <span>Laporan</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider" />
</ul>