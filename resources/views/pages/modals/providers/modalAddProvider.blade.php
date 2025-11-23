<!-- ModalAgg -->
    <div class="modal fade" id="modalAgg" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Cliente/Proveedor</h5>
                </div>
                <div class="modal-body">
                    <div class="card-header tab-card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One"
                                    aria-selected="true">Cliente</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two"
                                    aria-selected="false">Proveedor</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active pt-4" id="one" role="tabpanel" aria-labelledby="one-tab">
                            <form method="POST" action="{{ url('customers') }}" autocomplete="off">
                                {{ csrf_field() }}

                               <div class="row mb-3">
                                    @include('pages.modals.providers.inputAddProvider', ['prefix' => 'customer'])
                                    <div class="col-12 mb-3 mb-md-3">
                                        <div class="form-group form-check">
                                            <input type="checkbox" value="1" class="form-check-input" id="inputRetentionAgent_customer" name="retention_agent">
                                            <label class="form-check-label" for="inputRetentionAgent_customer" name="retention_agent">Agente de Retencion</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer pb-0">
                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Agregar</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade pt-4" id="two" role="tabpanel" aria-labelledby="two-tab">
                            <form method="POST" action="{{ url('providers') }}" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="row mb-3"> 
                                    @include('pages.modals.providers.inputAddProvider', ['prefix' => 'provider'])
                                    <div class="form-group col-12 mb-3">
                                        <label for="aggDirectionProvider_provider" class="form-label">Domicilio Fiscal</label>
                                        <input name="direction" type="text" class="form-control" id="aggDirectionProvider_provider" value="{{ old('direction') }}" required data-validate="direction">
                                        <p class="text-danger small d-none validation-msg">El Domicilio Fiscal de contener minimo 10 caracteres</p>
                                    </div>
                                </div>
                                <div class="modal-footer pb-0">
                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>