@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden min-vh-100 d-flex justify-content-center">
      <div class="d-flex justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-10">
            <div class="card mb-0 pb-4 pt-2">
              <div class="card-body">
                <a href="#" class="text-nowrap logo-img text-center d-block py-2 w-100">
                  <img src="{{ asset('images/logos/favicon.png') }}" width="50" alt="">
                </a>
                <h2 class="mb-1 text-center" style="font-weight: 800; letter-spacing: 2px;">North</h2>
                <p class="text-center my-2">Sistema de Facturacion e Inventario</p>
                <h1 class="text-center my-5" style="color: #174feb; font-weight: 800; letter-spacing: 3px;">Bienvenido</h1>
                <div class="mt-4 d-flex align-items-center justify-content-center">
                  <small style="color: #5a6a85cf; letter-spacing: 3px;">{{ env('APP_VERSION') }}</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('../layouts/message')
@endsection
