<div class="modal fade" id="modalDet{{ $provider->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del {{ $provider->type == 'provider' ? 'Proveedor' : 'Cliente' }}</h5>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="form-group">
                        <label for="inputTypeDocument" class="form-label">Tipo de Documento</label>
                        <span>{{ $provider->document_type }} {{ $provider->document }}</span>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="inputBusinessName" class="form-label">Razon Social</label>
                    <span>{{ $provider->business_name }}</span>
                </div>

                <div class="form-group mb-3">
                    <label for="inputEmail" class="form-label">Correo</label>
                    <span>{{ $provider->email ?? 'No registrado' }}</span>
                </div>

                <div class="form-group mb-3">
                    <label for="inputPhone" class="form-label">Telefono Principal</label>
                    <span>{{ $provider->phone ?? 'No registrado' }}</span>
                </div>

                <div class="form-group mb-3">
                    <label for="inputPhoneSecondary" class="form-label">Telefono Segundario</label>
                    <span>{{ $provider->phone_secondary ?? 'No registrado' }}</span>
                </div>
                @if ($provider->type == 'provider')
                    <div class="form-group mb-3">
                        <label for="direction" class="form-label">Domicilio Fiscal</label>
                        <span>{{ $provider->direction ?? 'No registrado' }}</span>
                    </div>
                @else
                    <div class="form-group mb-3">
                        <label for="direction" class="form-label">Agente de Retención?</label>
                        <span>{{ $provider->retention_agent ? "Si" : 'No' }}</span>
                    </div>
                @endif

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
