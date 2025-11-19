<div class="form-group col-12 col-md-4 mb-3">
    <label for="inputTypeDocument" class="form-label">Tipo de Documento</label>
    <select name="type_document" class="form-control" required value="{{ old('type_document') }}">
        <option value="0">- Seleccione -</option>
        @foreach ($document_types as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-12 col-md-8 mb-3">
    <label for="inputDocument" class="form-label">Documento</label>
    <input name="document" type="text" class="form-control" id="inputAggDocumentC" required 
        minlength="8" maxlength="12" pattern="[0-9]+" inputmode="numeric" value="{{ old('document') }}" 
        >
    <p class="text-danger small d-none" id="documentAggMessageC">El documento debe de contar con una logitud de 8 a 12
        caracteres de solo numeros</p>
</div>
<div class="form-group col-12 col-md-6 mb-3">
    <label for="inputBusinessName" class="form-label">Razon Social</label>
    <input name="business_name" type="text" class="form-control" id="inputAggBusinessNameC" required minlenght="1"
        maxlenght="200" value="{{ old('business_name') }}">
    <p class="text-danger small d-none" id="nameAggMessageC">La razon social es requerida con minimo 6 caracteres de
        longitud</p>
</div>

<div class="form-group col-12 col-md-6 mb-3">
    <label for="inputPhone" class="form-label">Telefono Principal</label>
    <input name="phone" type="number" class="form-control" id="inputAggPhoneC" minlength="10" maxlength="12"
        value="{{ old('phone') }}">
    <small class="text-muted">Opcional</small>
    <p class="text-danger small mb-0 d-none" id="phoneAggMessageC">El telefono principal solo puede contener numeros, con
        un a logitud entre 10 a 12 caracteres</p>
</div>
<div class="form-group col-12 col-md-6 mb-3">
    <label for="inputEmail" class="form-label">Correo</label>
    <input name="email" type="email" class="form-control" id="inputAggEmailC" minlength="10"
        value="{{ old('email') }}">
    <small class="text-muted">Opcional</small>
    <p class="text-danger small mb-0 d-none" id="emailAggMessageC">El correo debe tener un formato valido, con un minimo
        de 5 caracteres de longitud antes del "@"</p>
</div>


<div class="form-group col-12 col-md-6 mb-3">
    <label for="inputPhoneSecondary" class="form-label">Telefono Segundario</label>
    <input name="phone_secondary" type="number" class="form-control" id="inputAggPhoneSecondaryC" minlenght="10"
        maxlenght="11" value="{{ old('phone_secondary') }}">
    <small class="text-muted">Opcional</small>
    <p class="text-danger small mb-0 d-none" id="phoneSecondaryAggMessageC">El telefono secundario solo puede contener
        numeros, con un a logitud entre 10 a 12 caracteres</p>
</div>
