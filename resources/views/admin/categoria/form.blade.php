
<div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> {{ 'Nombre' }}</b> </div>
            </div>
               <input type="text" class="form-control"  maxlength="50"  id="nombre" name="nombre" type="text" value="{{ isset($categorium->nombre) ? $categorium->nombre : ''}}" >

>

        </div>
</div>

<div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> {{ 'Descripcion' }}</b> </div>
            </div>
               <input type="text" class="form-control"  maxlength="50"  id="descripcion" name="descripcion" type="text" value="{{ isset($categorium->descripcion) ? $categorium->descripcion : ''}}" >

>

        </div>
</div>



<div class="float-right">
    <button type="submit" class="btn-primary btn">
        {{ $formMode === 'edit' ? 'Actualizar' : 'Registrar' }}
    </button>

</div>
