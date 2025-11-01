<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>North</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/favicon.png') }}"/>
  <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('import/alertifyjs/css/alertify.css') }}">
  <script src="{{ asset('import/alertifyjs/alertify.js') }}"></script>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                {{-- mover a respaldo --}}
                {{-- <div class="d-flex mb-5" style="gap: 30px;">
                    <select class="form-control" id="">
                        <option value="">Seleccione intervalo</option>
                        <option value="">Diario</option>
                        <option value="">Semanal</option>
                        <option value="">Mensual</option>
                        <option value="">Anual</option>
                    </select>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div> --}}
                <a href="#" class="text-nowrap logo-img text-center d-block py-2 w-100">
                  <img src="{{ asset('images/logos/favicon.png') }}" width="45" alt="">
                </a>
                <h1 class="mb-1 text-center" style="font-weight: 800; letter-spacing: 2px;">North</h1>
                <p class="text-center">Sistema de Facturacion e Inventario</p>
                <form action="{{ url('/login') }}" method="POST" autocomplete="off">
                  {{ csrf_field() }}
                  <div class="mb-3">
                    <label for="inputEmail" class="form-label">Usuario</label>
                    <input name="userName" type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" maxlength="50" value="{{ old('userName') }}">
                  </div>

                  <div class="mb-4">
                    <label for="inputPassword" class="form-label">Contraseña</label>
                    <div class="input-group">
                      <input id="password" name="userPassword" type="password" class="form-control" id="inputPassword" minlength="8" value="{{ old('userPassword') }}">
                      <button id="btn_search" type="button" class="btn btn-outline-primary" onClick="showHiden('password')">
                        <span id="iconShow"><i class="ti ti-eye"></i></span>
                        <span id="iconHidden" class="d-none"><i class="ti ti-eye-off"></i></span>
                      </button>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Iniciar Sesion</button>
                </form>

                <div class="d-flex align-items-center justify-content-center">
                  <p class="fs-4 mb-0 fw-bold">¿Olvidaste tu contraseña?</p>
                  <a class="text-primary fw-bold ms-2" style="cursor: pointer; font-size: 15px" data-toggle="modal" data-target="#modalVerifiedEmail">Recuperar acceso</a>

                  <!-- ModalVerifiedEmail -->
                  <div class="modal fade" id="modalVerifiedEmail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Verificación de Correo</h5>
                        </div>
                        <form method="POST" action="{{ url('check/email') }}" autocomplete="off">
                          {{ csrf_field() }}

                          <div class="modal-body">
                            <div class="form-group mb-3">
                              <label for="inpurEmail" class="form-label">Correo</label>
                              <input name="email" type="email" class="form-control" id="inpurEmail" required minlenght="8" value="{{ old('email') }}">
                            </div>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Verificar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mt-4 d-flex align-items-center justify-content-center">
                  <small style="color: #5a6a85cf; letter-spacing: 3px;">{{ env('APP_VERSION') }}</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

  	  @include('../layouts/message');
    </div>
  </div>

  <script src="{{ asset('import/alertifyjs/alertify.min.js') }}"></script>
  <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('import/js/jquery.min.js') }}"></script>
  <script src="{{ asset('import/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/configurationInputsPassword.js') }}"></script>
</body>

</html>
