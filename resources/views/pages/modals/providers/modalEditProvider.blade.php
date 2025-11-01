<div class="modal fade" id="modalEdit{{ $provider->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar {{ $provider->type == 'provider' ? 'Proveedor' : 'Cliente' }}</h5>
            </div>
            <form method="POST" action="{{ url($provider->type == "provider" ? "providers/$provider->id" : "customers/$provider->id") }}" autocomplete="off">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body" id="bodyModalEdit">
                    <div class="row mb-3">
                        <div class="form-group col-12 col-md-4 mb-3 mb-md-0">
                            <label for="inputTypeDocument" class="form-label">Tipo de Documento</label>
                            <select name="type_document" class="form-control" required
                                value="{{ old('type_document') }}">
                                @foreach ($document_types as $type)
                                    <option value="{{ $type->id }}"
                                        {{ $provider->id_document_type == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-8">
                            <label for="inputDocument" class="form-label">Documento</label>
                            <input name="document" type="number" class="form-control" id="inputEditDocument" required
                                minlenght="7" maxlenght="10"
                                value="{{ $provider->document ? $provider->document : old('document') }}">
                            <p class="text-danger small d-none" id="documentEditMesssage">El documento debe de contar
                                con una logitud de 7 a 10 caracteres de solo numeros</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-12 col-md-6 mb-3 mb-md-0">
                            <label for="inputBusinessName" class="form-label">Razon Social</label>
                            <input name="business_name" type="text" class="form-control" id="inputEditBusinessName"
                                required minlenght="1" maxlenght="50"
                                value="{{ $provider->business_name ? $provider->business_name : old('business_name') }}">
                            <p class="text-danger small d-none" id="nameEditMessage">La razon social es requerida con
                                minimo 6 caracteres de longitud</p>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="inputEmail" class="form-label">Correo</label>
                            <input name="email" type="email" class="form-control" id="inputEditEmail"
                                minlength="10" value="{{ $provider->email ? $provider->email : old('email') }}">
                            <small class="text-muted">Opcional</small>
                            <p class="text-danger small mb-0 d-none" id="emailEditMessage">El correo debe tener un
                                formato valido, con un minimo de 5 caracteres de longitud antes del "@"</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-12 col-md-6 mb-3 mb-md-0">
                            <label for="inputPhone" class="form-label">Telefono</label>
                            <input name="phone" type="number" class="form-control" id="inputEditPhone"
                                minlenght="10" maxlenght="11"
                                value="{{ $provider->phone ? $provider->phone : old('phone') }}">
                            <small class="text-muted">Opcional</small>
                            <p class="text-danger small mb-0 d-none" id="phoneEditMessage">El telefono principal solo
                                puede contener numeros, con un a logitud entre 10 a 12 caracteres</p>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="inputPhoneSecundary" class="form-label">Telefono Secundario</label>
                            <input name="phone_secondary" type="number" class="form-control" id="inputPhoneSecundary"
                                minlenght="10" maxlenght="11"
                                value="{{ $provider->phone_secondary ? $provider->phone_secondary : old('phone_secundary') }}">
                            <small class="text-muted">Opcional</small>
                            <p class="text-danger small mb-0 d-none" id="phoneSecondaryEditMessage">El telefono
                                secundario solo puede contener numeros, con un a logitud entre 10 a 12 caracteres</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        @if ($provider->type == 'provider')
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="directionProvider" class="form-label">Domicilio Fiscal</label>
                                    <input name="direction" type="text" class="form-control" id="editDirectionProvider"
                                        value="{{ $provider->direction ? $provider->direction : old('direction') }}"
                                        required>
                                    <p class="text-danger small d-none" id="editDirectionProviderMessage">El Domicilio
                                        Fiscal de contener minimo 10 caracteres</p>
                                </div>
                            </div>
                        @else
                            <div class="col-12 mb-3 mb-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" value="1" {!! $provider->retention_agent ? 'checked' : '' !!} required class="form-check-input" id="inputRetentionAgent" name="retention_agent">
                                    <label class="form-check-label" for="inputRetentionAgent" name="retention_agent">Agente de Retencion</label>
                                </div>
                            </div>
                        @endif
                    </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
                     <button type="submit" class="btn btn-warning">Editar</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
