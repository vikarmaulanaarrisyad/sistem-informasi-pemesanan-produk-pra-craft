@push('css')
    <style>
        
    </style>
@endpush

<aside class="main-sidebar sidebar-light elevation-4 bg-light">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link bg-sidebar-hijau">
        <img src="{{ asset('Templates') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light text-white">Pra Craf</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('Templates/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block" data-toggle="tooltip" data-placement="top"
                    title="Edit Profil">{{ auth()->user()->name }}
                    <i class="fas fa-pencil-alt ml-2 text-sm text-primary"></i>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @if (auth()->user()->hasRole('admin'))
                    <li class="nav-header">MASTER</li>
                    <li class="nav-item">
                        <a href="{{ route('category.index') }}"
                            class="nav-link {{ request()->is('category*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>
                                Kategori

                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/widgets.html" class="nav-link">
                            <i class="nav-icon fas fa-folder"></i>
                            <p>
                                Produk
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/widgets.html" class="nav-link">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>
                                Pelanggan
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">Transaksi</li>
                    <li class="nav-item">
                        <a href="pages/widgets.html" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Pesanan
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/widgets.html" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                Penjualan
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/widgets.html" class="nav-link">
                            <i class="nav-icon fas fa-motorcycle"></i>
                            <p>
                                Pengiriman
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">Report</li>
                    <li class="nav-item">
                        <a href="pages/widgets.html" class="nav-link">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>
                                Laporan
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">Pengaturan</li>
                    <li class="nav-item">
                        <a href="pages/widgets.html" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Pengaturan
                            </p>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="pages/widgets.html" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Pembelian Produk
                            </p>
                        </a>
                    </li>
                @endif


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
