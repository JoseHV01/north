<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="{{ url('dashboard') }}" class="text-nowrap logo-img">
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
          <i class="ti ti-x fs-8"></i>
        </div>
      </div>
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            <li class="nav-small-cap">
                <a href="{{ url('dashboard') }}" aria-expanded="false">
                <span class="hide-menu" style="color: #2A3547;">Inicio</span>
                </a>
            </li>

            @foreach (Cache::get('permissions') as $permission)
                @if ($permission == 'Ventas')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ url('bills/sales') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-report-money"></i>
                        </span>
                        <span class="hide-menu">Ventas</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ url('sales/create') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-plus"></i>
                        </span>
                        <span class="hide-menu">Nueva Venta</span>
                        </a>
                    </li>
                @endif

                @if ($permission == 'Compras')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ url('bills/shopping') }}" aria-expanded="false">
                            <span>
                            <i class="ti ti-brand-shopee"></i>
                            </span>
                            <span class="hide-menu">Compras</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ url('shopping/create') }}" aria-expanded="false">
                            <span>
                            <i class="ti ti-plus"></i>
                            </span>
                            <span class="hide-menu">Nueva Compra</span>
                        </a>
                    </li>
                @endif

                @if ($permission == 'Proveedores')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ url('providers') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">Clientes / Proveedores</span>
                        </a>
                    </li>
                @endif

                {{-- @if ($permission == 'Clientes')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ url('customers') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">Clientes</span>
                        </a>
                    </li>
                @endif --}}

                @if ($permission == 'Productos')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ url('products') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-building-store"></i>
                        </span>
                        <span class="hide-menu">Productos</span>
                        </a>
                    </li>
                @endif
            @endforeach

            @if(auth()->user()->id_rol == 1)
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Administrativo</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('reports') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-chart-line"></i>
                        </span>
                        <span class="hide-menu">Reportes y Graficas</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('categorys') }}" aria-expanded="false">
                        <span>
                        <i class="ti ti-category-2"></i>
                        </span>
                        <span class="hide-menu">Categorias</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('shapes_payment') }}" aria-expanded="false">
                        <span>
                        <i class="ti ti-ruler-2"></i>
                        </span>
                        <span class="hide-menu">Formas de Pago</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('rates') }}" aria-expanded="false">
                        <span>
                        <i class="ti ti-building-bank"></i>
                        </span>
                        <span class="hide-menu">Tasas</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('company') }}" aria-expanded="false">
                        <span>
                        <i class="ti ti-clipboard-text"></i>
                        </span>
                        <span class="hide-menu">Empresa</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('users') }}" aria-expanded="false">
                        <span>
                        <i class="ti ti-user"></i>
                        </span>
                        <span class="hide-menu">Usuarios</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('logs') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-activity"></i>
                        </span>
                        <span class="hide-menu">Bitacora</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('backup/db') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-database-export"></i>
                        </span>
                        <span class="hide-menu">Respaldar BD</span>
                    </a>
                </li>
            @endif

            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Ayuda</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ asset('documentation/documentation.pdf') }}" aria-expanded="false" target="_blank">
                <span>
                    <i class="ti ti-books"></i>
                </span>
                <span class="hide-menu">Documentacion</span>
                </a>
            </li>
        </ul>
      </nav>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
  </aside>
  <!--  Sidebar End -->
