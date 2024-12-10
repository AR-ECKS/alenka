
<div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> {{ 'Produccion Id' }}</b> </div>
            </div>
               <input type="text" class="form-control"  maxlength="50"  id="produccion_id" name="produccion_id" type="number" value="{{ isset($detalle_produccion->produccion_id) ? $detalle_produccion->produccion_id : ''}}" >

>

        </div>
</div>

<div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> {{ 'User Id' }}</b> </div>
            </div>
               <input type="text" class="form-control"  maxlength="50"  id="user_id" name="user_id" type="number" value="{{ isset($detalle_produccion->user_id) ? $detalle_produccion->user_id : ''}}" >

>

        </div>
</div>

<div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> {{ 'Baldes' }}</b> </div>
            </div>
               <input type="text" class="form-control"  maxlength="50"  id="baldes" name="baldes" type="text" value="{{ isset($detalle_produccion->baldes) ? $detalle_produccion->baldes : ''}}" >

>

        </div>
</div>

<div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> {{ 'Cantidad' }}</b> </div>
            </div>
               <input type="text" class="form-control"  maxlength="50"  id="cantidad" name="cantidad" type="text" value="{{ isset($detalle_produccion->cantidad) ? $detalle_produccion->cantidad : ''}}" >

>

        </div>
</div>



<div class="float-right">
    <button type="submit" class="btn-primary btn">
        {{ $formMode === 'edit' ? 'Actualizar' : 'Registrar' }}
    </button>

</div>
