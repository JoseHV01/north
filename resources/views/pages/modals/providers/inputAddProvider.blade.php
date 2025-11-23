<div class="form-group col-12 col-md-4 mb-3">
    <label for="inputTypeDocument_{{ $prefix ?? 'default' }}" class="form-label">Tipo de Documento</label>
    <select name="type_document" class="form-control" required value="{{ old('type_document') }}" id="inputTypeDocument_{{ $prefix ?? 'default' }}">
        <option value="0">- Seleccione -</option>
        @foreach ($document_types as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-12 col-md-8 mb-3">
    <label for="inputAggDocument_{{ $prefix ?? 'default' }}" class="form-label">Documento</label>
    <input name="document" type="number" class="form-control" id="inputAggDocument_{{ $prefix ?? 'default' }}" required value="{{ old('document') }}" minlength="8" maxlength="12" pattern="[0-9]+" inputmode="numeric" data-validate="document">
    <p class="text-danger small d-none validation-msg">El documento debe de contar con una logitud de 8 a 12
        caracteres de solo numeros</p>
</div>
<div class="form-group col-12 col-md-6 mb-3">
    <label for="inputAggBusinessName_{{ $prefix ?? 'default' }}" class="form-label">Razon Social</label>
    <input name="business_name" type="text" class="form-control" id="inputAggBusinessName_{{ $prefix ?? 'default' }}" required minlength="1"
        maxlength="200" value="{{ old('business_name') }}" data-validate="businessName">
    <p class="text-danger small d-none validation-msg">La razon social es requerida con minimo 6 caracteres de
        longitud</p>
</div>

<div class="form-group col-12 col-md-6 mb-3">
    <label for="inputAggPhone_{{ $prefix ?? 'default' }}" class="form-label">Telefono Principal</label>
    <input name="phone" type="number" class="form-control" id="inputAggPhone_{{ $prefix ?? 'default' }}" minlength="10" maxlength="12"
        value="{{ old('phone') }}" data-validate="phone" data-optional="true">
    <small class="text-muted">Opcional</small>
    <p class="text-danger small mb-0 d-none validation-msg">El telefono principal solo puede contener numeros, con
        un a logitud entre 10 a 12 caracteres</p>
</div>
<div class="form-group col-12 col-md-6 mb-3">
    <label for="inputAggEmail_{{ $prefix ?? 'default' }}" class="form-label">Correo</label>
    <input name="email" type="email" class="form-control" id="inputAggEmail_{{ $prefix ?? 'default' }}" minlength="10"
        value="{{ old('email') }}" data-validate="email" data-optional="true">
    <small class="text-muted">Opcional</small>
    <p class="text-danger small mb-0 d-none validation-msg">El correo debe tener un formato valido, con un minimo
        de 5 caracteres de longitud antes del "@"</p>
</div>


<div class="form-group col-12 col-md-6 mb-3">
    <label for="inputAggPhoneSecondary_{{ $prefix ?? 'default' }}" class="form-label">Telefono Segundario</label>
    <input name="phone_secondary" type="number" class="form-control" id="inputAggPhoneSecondary_{{ $prefix ?? 'default' }}" minlength="10"
        maxlength="11" value="{{ old('phone_secondary') }}" data-validate="phone" data-optional="true">
    <small class="text-muted">Opcional</small>
    <p class="text-danger small mb-0 d-none validation-msg">El telefono secundario solo puede contener
        numeros, con un a logitud entre 10 a 12 caracteres</p>
</div>
