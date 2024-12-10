
<div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> {{ 'Cantidad Presentacion' }}</b> </div>
            </div>
               <input type="text" class="form-control"  maxlength="50"  id="cantidad_presentacion" name="cantidad_presentacion" type="text" value="{{ isset($detalle_despacho->cantidad_presentacion) ? $detalle_despacho->cantidad_presentacion : ''}}" >

>

        </div>
</div>

<div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> {{ 'Cantidad Unidad' }}</b> </div>
            </div>
               <input type="text" class="form-control"  maxlength="50"  id="cantidad_unidad" name="cantidad_unidad" type="text" value="{{ isset($detalle_despacho->cantidad_unidad) ? $detalle_despacho->cantidad_unidad : ''}}" >

>

        </div>
</div>

<div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> {{ 'Materia Prima Id' }}</b> </div>
            </div>
               <input type="text" class="form-control"  maxlength="50"  id="materia_prima_id" name="materia_prima_id" type="number" value="{{ isset($detalle_despacho->materia_prima_id) ? $detalle_despacho->materia_prima_id : ''}}" >

>

        </div>
</div>

<div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> {{ 'Despacho Id' }}</b> </div>
            </div>
               <input type="text" class="form-control"  maxlength="50"  id="despacho_id" name="despacho_id" type="number" value="{{ isset($detalle_despacho->despacho_id) ? $detalle_despacho->despacho_id : ''}}" >

>

        </div>
</div>



<div class="float-right">
    <button type="submit" class="btn-primary btn">
        {{ $formMode === 'edit' ? 'Actualizar' : 'Registrar' }}
    </button>

</div>
