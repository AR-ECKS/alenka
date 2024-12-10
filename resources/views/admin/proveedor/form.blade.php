<div class="row">

    <div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> Razon Social:</b> </div>
            </div>
            <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="50" name="razon_social" placeholder="" value="{{ isset($proveedor->razon_social) ? $proveedor->razon_social : ''}}"
        </div>
    </div>

    </div>
<script>

</script>
    <div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> Pais:</b> </div>
            </div>
            <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="50" name="pais" placeholder=""  value="{{ isset($proveedor->pais) ? $proveedor->pais : ''}}">
        </div>
    </div>
    <div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> Direccion:</b> </div>
            </div>
            <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="50" name="direccion" placeholder=""  value="{{ isset($proveedor->direccion) ? $proveedor->direccion : ''}}">
        </div>
    </div>
    <div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> Telefono:</b> </div>
            </div>
            <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="50" name="telefono" placeholder=""  value="{{ isset($proveedor->telefono) ? $proveedor->telefono: ''}}">
        </div>
    </div>
    <div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> Celular:</b> </div>
            </div>
            <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="50" name="celular" placeholder=""  value="{{ isset($proveedor->celular) ? $proveedor->celular : ''}}">
        </div>
    </div>
    <div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> Correo:</b> </div>
            </div>
            <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="50" name="correo" placeholder=""  value="{{ isset($proveedor->correo) ? $proveedor->correo : ''}}">
        </div>
    </div>
    <div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> Página web:</b> </div>
            </div>
            <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="50" name="pagina_web" placeholder=""  value="{{ isset($proveedor->pagina_web) ? $proveedor->pagina_web : ''}}">
        </div>
    </div>
    <hr>
    <div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> Nombre Representante:</b> </div>
            </div>
            <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="50" name="nombre_representante" placeholder=""  value="{{ isset($proveedor->nombre_representante) ? $proveedor->nombre_representante : ''}}">
        </div>
    </div>
    <div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b>Telefono Representante:</b> </div>
            </div>
            <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="50" name="telefono_representante" placeholder=""  value="{{ isset($proveedor->telefono_representante) ? $proveedor->telefono_representante : ''}}">
        </div>
    </div>
</div>



<div class="float-right">
    <button type="submit" class="btn-primary btn">
        {{ $formMode === 'edit' ? 'Actualizar' : 'Registrar' }}
    </button>

</div>
