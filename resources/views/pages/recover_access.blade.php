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
                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('images/logos/favicon.png') }}" width="45" alt="">
                </a>
                <p class="text-center">Sistema de Facturacion e Inventario</p>
                <form action="{{ url('/recover/access') }}" method="POST" autocomplete="off">
                  {{ csrf_field() }}

                  <div class="mb-4">
                    <label for="inputAsk" class="form-label">Pregunta:
                      <span style="font-weight: normal;">{{ $ask->ask }}</span>
                    </label>
                    <input name="answer" type="text" class="form-control" id="inputAsk" required value="{{ old('answer') }}">
                    <input hidden name="id" type="text" value="{{ $ask->id }}" style="display: none; visibility: hidden;">
                  </div>

                  <div class="mb-4">
                    <label for="inputPassword" class="form-label">Contraseña</label>
                    <div class="input-group">
                      <input id="password"  name="password" type="password" class="form-control" id="inputPassword" required value="{{ old('password') }}">
                      <button id="btn_search" type="button" class="btn btn-outline-primary" onClick="showHiden('password')">
                        <span id="iconShow"><i class="ti ti-eye"></i></span>
                        <span id="iconHidden" class="d-none"><i class="ti ti-eye-off"></i></span>
                      </button>
                    </div>
                  </div>

                  <div class="mb-4">
                    <label for="inpurRepeatPassword" class="form-label">Repetir Contraseña</label>
                    <div class="input-group">
                      <input id="repeat_password" name="repeat_password" type="password" class="form-control" id="inpurRepeatPassword" required value="{{ old('repeat_password') }}">
                      <button id="btn_search" type="button" class="btn btn-outline-primary" onClick="showHiden('repeat_password')">
                        <span id="iconShow"><i class="ti ti-eye"></i></span>
                        <span id="iconHidden" class="d-none"><i class="ti ti-eye-off"></i></span>
                      </button>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Recuperar Acceso</button>
                </form>

                <div class="d-flex align-items-center justify-content-center">
                  <a class="text-primary fw-bold ms-2" href="{{ url('/') }}">Volver al Login</a>
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
  <script src="{{ asset('js/configurationInputsPassword.js') }}"></script>
</body>

</html>
