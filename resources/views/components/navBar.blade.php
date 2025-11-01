<!--  Header Start -->
<header class="app-header" style="width: 100%; position: relative;">
  <nav class="navbar navbar-expand-lg navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
        <li class="nav-item dropdown" data-toggle="tooltip" title="Tasa BCV">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="ti ti-building-bank"></i>
            <!-- <div class="notification bg-primary rounded-circle"></div> -->
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up negative-margin-right" aria-labelledby="drop1">
            <div class="message-body py-3">
                <form method="POST" action="{{ url('changebcv/4') }}" autocomplete="off">
				    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">

                    <input name="name" type="hidden" class="form-control" id="inputName" required value="Tasa BCV">

                    <div class="form-group mb-3 d-flex justify-content-center">
                        <input name="value" type="text" class="form-control w-75" id="inputValue" required min="1" placeholder="Tasa BCV" value="{{ Cache::get('bcv') }}">
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-outline-warning w-75">Actualizar</button>
                    </div>
				</form>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown" data-toggle="tooltip" title="Notificacion">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="ti ti-building-store"></i>
            @if(count(Cache::get('productsOut')) != 0)
              <div class="notification bg-danger rounded-circle"></div>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up negative-margin-right" aria-labelledby="drop1">
            <h6 class="text-center py-2" style="border-bottom: 1px solid #0000002e;">Productos a reponer</h6>
            <div class="message-body pt-0 px-1 container-table">
                @if(count(Cache::get('productsOut')) != 0)
                    <table class="table scroll">
                        <tbody>
                            @foreach(Cache::get('productsOut')  as $product)
                            <tr>
                                <td class="text-center" style="padding: 4px !important">{{ $product->description }}</td>
                                <td style="padding: 4px !important">{{ $product->existence }} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="py-1 px-3 text-center" style="line-height: 18px !important">
                        <small class="fw-semibold">No hay productos proximos a agotarse</small>
                    </div>
                @endif
            </div>
          </div>
        </li>
      </ul>
      <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
          <li class="nav-item dropdown">
            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
              aria-expanded="false">
              <img src="{{ asset('images/profile/user-1.jpg') }}" alt="" width="35" height="35" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
              <div class="message-body">
                <a href="{{ url('profile') }}" class="d-flex align-items-center gap-2 dropdown-item">
                  <i class="ti ti-user fs-6"></i>
                  <p class="mb-0 fs-3">Mi Perfil</p>
                </a>
                <a href="{{ url('logout') }}" class="btn btn-outline-primary mx-3 mt-2 d-block">Salir</a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!--  Header End -->
