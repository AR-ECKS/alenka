<div class="col-sm-12">
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b>
                    {{ 'Nombre' }}</b> </div>
        </div>
        <input type="text" class="form-control" maxlength="50" id="nombre" name="nombre" type="text"
            value="{{ isset($subcategorium->nombre) ? $subcategorium->nombre : '' }}">

        >

    </div>
</div>

<div class="col-sm-12">
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b>
                    {{ 'Descripcion' }}</b> </div>
        </div>
        <input type="text" class="form-control" maxlength="50" id="descripcion" name="descripcion" type="text"
            value="{{ isset($subcategorium->descripcion) ? $subcategorium->descripcion : '' }}">

        >

    </div>
</div>

<div class="col-sm-12">
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="fas fa-user-edit" style="padding-right:5px"></i><b> {{ 'Categoría' }}</b>
            </div>
        </div>
        <select class="form-control" id="categoria_id" name="categoria_id">
            <option value="">Seleccione una categoría</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}" {{ (isset($subcategorium->categoria_id) && $subcategorium->categoria_id == $categoria->id) ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
    </div>
</div>




<div class="float-right">
    <button type="submit" class="btn-primary btn">
        {{ $formMode === 'edit' ? 'Actualizar' : 'Registrar' }}
    </button>

</div>
