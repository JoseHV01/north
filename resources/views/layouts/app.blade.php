<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>North | @yield('title')</title>
  <link rel="shortcut icon" type="image/png" href="https://north-production.up.railway.app/images/logos/favicon.png"/>
  <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/desing.css') }}"/>
  <link rel="stylesheet" href="{{ asset('import/alertifyjs/css/alertify.css') }}">
  <link rel="stylesheet" href="{{ asset('import/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
  <!-- CSS de Choices.js -->
  <link rel="stylesheet" href="{{ asset('libs/choices/choices.min.css') }}">
  <!-- JS de Choices.js -->
  <script src="{{ asset('libs/choices/choices.min.js') }}"></script>
  <script src="{{ asset('import/alertifyjs/alertify.js') }}"></script>
  <script src="{{ asset('import/jquery-validation/lib/jquery.js') }}"></script>
  <script src="{{ asset('import/jquery-validation/dist/jquery.validate.js') }}"></script>
</head>

<body>
    @auth
        <div class="modal fade" id="modalExtendSession" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Session vendida por inactividad</h5>
                    </div>
                    <form method="POST" action="{{ url("extend-session") }}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <h6>¿Desea extender la session?</h6>
                        </div>

                        <div class="modal-footer">
                            <a id="btnDismissModal" href="{{ url('logout') }}" class="btn btn-dark" data-dismiss="modal">No</a>
                            <button type="submit" class="btn btn-primary">Si</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth

  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    @include("components.sideBar")

    <div class="body-wrapper min-vh-100" style="background: #fafaff;">
      @include("components.navBar")
      <div class="container-fluid pt-5">
        @yield('content')
      </div>
    </div>
  </div>

  {{-- <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('import/alertifyjs/alertify.min.js') }}"></script>
    <script src="{{ asset('import/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    {{-- <script src="{{ asset('js/alerts.js') }}"></script> --}}
    <script src="{{ asset('js/validate_form.js') }}"></script>
    <script src="{{ asset('libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('import/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('import/chart/chart.js') }}"></script>

    @auth
        <script src="{{ asset('js/sessions.js') }}"></script>
    @endauth
    @yield('scripts')
</body>

</html>
