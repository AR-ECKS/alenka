<h5>Datos generales de la materia</h5>
<div class="row">

    <div class="col-sm-2">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Código' }}</b>
                </div>
            </div>
            <input type="text" class="form-control" maxlength="50" id="codigo" name="codigo"
                value="{{ isset($materia_prima->codigo) ? $materia_prima->codigo : $new_code }}" readonly>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Categoría' }}</b>
                </div>
            </div>
            <select class="form-control" id="categoria_id" required>
                <option value="" disabled {{ is_null($categoria_id) ? 'selected' : '' }}>Seleccione una categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $categoria->id == $categoria_id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Subcategoría' }}</b>
                </div>
            </div>
            <select class="form-control" id="subcategoria_id" name="subcategoria_id" required>
                <option value="" disabled {{ !isset($materia_prima->subcategoria_id) ? 'selected' : '' }}>Seleccione una subcategoría</option>
                @foreach($subcategorias as $subcategoria)
                    <option value="{{ $subcategoria->id }}" {{ isset($materia_prima->subcategoria_id) && $materia_prima->subcategoria_id == $subcategoria->id ? 'selected' : '' }}>
                        {{ $subcategoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>



    <div class="col-sm-3">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Proveedor' }}</b>
                </div>
            </div>
            <select class="form-control" id="proveedor_id" name="proveedor_id" required>
                <option value="">Seleccione un proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}"
                        {{ isset($materia_prima->proveedor_id) && $materia_prima->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->razon_social }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="col-sm-4">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b>
                        {{ 'Nombre' }}</b> </div>
            </div>
            <input type="text" class="form-control" maxlength="50" id="nombre" name="nombre" type="text" required
                value="{{ isset($materia_prima->nombre) ? $materia_prima->nombre : '' }}">



        </div>
    </div>

    <div class="col-sm-8">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b>
                        {{ 'Descripcion' }}</b> </div>
            </div>
            <input type="text" class="form-control" maxlength="50" id="descripcion" name="descripcion" type="text"
                value="{{ isset($materia_prima->descripcion) ? $materia_prima->descripcion : '' }}">



        </div>
    </div>

</div><br>
<h5>Datos especificos de la materia prima</h5>
<div class="row">

    <div class="col-sm-6">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b>
                        {{ 'Presentacion' }}</b> </div>
            </div>
            <select required class="form-control" name="presentacion" id="presentacion" required>
                <option value="" disabled {{ !isset($materia_prima->presentacion) ? 'selected' : '' }}>Seleccione una presentación</option>
                <option value="Bolsa" {{ isset($materia_prima->presentacion) && $materia_prima->presentacion == 'Bolsa' ? 'selected' : '' }}>Bolsa</option>
                <option value="Caja" {{ isset($materia_prima->presentacion) && $materia_prima->presentacion == 'Caja' ? 'selected' : '' }}>Caja</option>
                <option value="Botella" {{ isset($materia_prima->presentacion) && $materia_prima->presentacion == 'Botella' ? 'selected' : '' }}>Botella</option>
                <option value="Lata" {{ isset($materia_prima->presentacion) && $materia_prima->presentacion == 'Lata' ? 'selected' : '' }}>Lata</option>
                <option value="Paquete" {{ isset($materia_prima->presentacion) && $materia_prima->presentacion == 'Paquete' ? 'selected' : '' }}>Paquete</option>
                <option value="Saco" {{ isset($materia_prima->presentacion) && $materia_prima->presentacion == 'Saco' ? 'selected' : '' }}>Saco</option>
                <option value="Tarro" {{ isset($materia_prima->presentacion) && $materia_prima->presentacion == 'Tarro' ? 'selected' : '' }}>Tarro</option>
                <option value="Tarrina" {{ isset($materia_prima->presentacion) && $materia_prima->presentacion == 'Tarrina' ? 'selected' : '' }}>Tarrina</option>
                <option value="Vaso" {{ isset($materia_prima->presentacion) && $materia_prima->presentacion == 'Vaso' ? 'selected' : '' }}>Vaso</option>
                <!-- Agrega más opciones según sea necesario -->
            </select>



        </div>
    </div>


    <div class="col-sm-3 {{ $errors->has('unidad_medida') ? 'has-error' : '' }}">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b>Unidad de
                        Medida</b> </div>
            </div>
            <select class="form-control" name="unidad_medida" id="unidad_medida" required>
                <option value="" disabled selected>Seleccione una unidad</option>
                <option value="Unidad"
                    {{ isset($materia_prima->unidad_medida) && $materia_prima->unidad_medida == 'Unidad' ? 'selected' : '' }}>
                    Unidad</option>
                <option value="kg"
                    {{ isset($materia_prima->unidad_medida) && $materia_prima->unidad_medida == 'kg' ? 'selected' : '' }}>
                    kg (Kilogramos)</option>
                <option value="g"
                    {{ isset($materia_prima->unidad_medida) && $materia_prima->unidad_medida == 'g' ? 'selected' : '' }}>
                    g (Gramos)</option>
                <option value="mg"
                    {{ isset($materia_prima->unidad_medida) && $materia_prima->unidad_medida == 'mg' ? 'selected' : '' }}>
                    mg (Miligramos)</option>
                <option value="lb"
                    {{ isset($materia_prima->unidad_medida) && $materia_prima->unidad_medida == 'lb' ? 'selected' : '' }}>
                    lb (Libras)</option>
                <option value="oz"
                    {{ isset($materia_prima->unidad_medida) && $materia_prima->unidad_medida == 'oz' ? 'selected' : '' }}>
                    oz (Onzas)</option>
                <option value="ton"
                    {{ isset($materia_prima->unidad_medida) && $materia_prima->unidad_medida == 'ton' ? 'selected' : '' }}>
                    ton (Toneladas)</option>
                <option value="l"
                    {{ isset($materia_prima->unidad_medida) && $materia_prima->unidad_medida == 'l' ? 'selected' : '' }}>
                    l (Litros)</option>

                <option value="mt"
                    {{ isset($materia_prima->unidad_medida) && $materia_prima->unidad_medida == 'mt' ? 'selected' : '' }}>
                    mt (Metros)</option>
                <!-- Agrega más opciones según sea necesario -->
            </select>
        </div>
    </div>
    <div class="col-sm-3 {{ $errors->has('cantidad') ? 'has-error' : '' }}">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit"
                        style="padding-right:5px"></i><b>Cantidad</b> </div>
            </div>
            <input type="number" class="form-control" id="cantidad" name="cantidad" maxlength="10"
                placeholder="Ingrese la cantidad"
                value="{{ isset($materia_prima->cantidad) ? $materia_prima->cantidad : '' }}" required>
        </div>
        {!! $errors->first('cantidad', '<p class="help-block">:message</p>') !!}
    </div>


    <div class="col-sm-4">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b
                        id="precio_compra_label">
                        {{ 'Precio Compra' }}</b> </div>
            </div>
            <input type="text" class="form-control" maxlength="50" id="precio_compra" name="precio_compra"
                type="number" required
                value="{{ isset($materia_prima->precio_compra) ? $materia_prima->precio_compra : '' }}">
        </div>
    </div>

    <div class="col-sm-4">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b
                        id="costo_unidad_label">
                        {{ 'Costo Unidad' }}</b> </div>
            </div>
            <input type="text" class="form-control" maxlength="50" id="costo_unidad" name="costo_unidad"
                type="number" value="{{ isset($materia_prima->costo_unidad) ? $materia_prima->costo_unidad : '' }}">
        </div>
    </div>


    {{-- <div class="col-sm-4">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b>
                        {{ 'Imagen' }}</b> </div>
            </div>
            <input type="text" class="form-control" maxlength="50" id="imagen" name="imagen" type="text"
                value="{{ isset($materia_prima->imagen) ? $materia_prima->imagen : '' }}">



        </div>
    </div> --}}
</div>
<br>
<h5>Datos en almacén de la materia prima</h5>

<div class="row">


    <br><br><br>
    {{-- <div class="col-sm-6">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b>
                        {{ 'Stock' }}</b> </div>
            </div>
            <input type="text" class="form-control" maxlength="50" id="stock" name="stock" type="number" required
                value="{{ isset($materia_prima->stock) ? $materia_prima->stock : '' }}">



        </div>
    </div> --}}

    <div class="col-sm-6">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b>
                        {{ 'Stock Minimo' }}</b> </div>
            </div>
            <input type="text" class="form-control" maxlength="50" id="stock_minimo" name="stock_minimo" required
                type="number" value="{{ isset($materia_prima->stock_minimo) ? $materia_prima->stock_minimo : '' }}">


        </div>
    </div>
</div>


<div class="float-right">
    <button type="submit" class="btn-primary btn">
        {{ $formMode === 'edit' ? 'Actualizar' : 'Registrar' }}
    </button>

</div>

<script>
    $('#categoria_id').on('change', function() {
        var categoria_id = this.value;
        console.log('Selected categoria_id: ' + categoria_id);

        $.ajax({
            url: '{{ route('getSubcategorias') }}?categoria_id=' + categoria_id,
            type: 'get',
            success: function(res) {
                console.log("Subcategorías:", res);
                $('#subcategoria_id').empty().append(
                    '<option value="">Seleccione una subcategoría</option>');
                $.each(res, function(key, subcategoria) {
                    $('#subcategoria_id').append('<option value="' + subcategoria.id +
                        '">' + subcategoria.nombre + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.log('AJAX error:', error);
                console.log('Status:', status);
                console.log('XHR:', xhr);
            }
        });
    });
</script>

<script>
    document.getElementById('presentacion').addEventListener('input', function() {
        var presentacion = this.value;
        document.getElementById('precio_compra_label').textContent = 'Precio Compra por ' + presentacion +
            ' (Bs)';
        document.getElementById('precio_venta_label').textContent = 'Precio Venta por ' + presentacion +
        ' (Bs)';
    });

    // Función para actualizar los textos de los labels cuando se selecciona una unidad de medida
    document.getElementById('unidad_medida').addEventListener('input', function() {
        var unidad = this.value;
        document.getElementById('costo_unidad_label').textContent = 'Costo por ' + unidad + ' (Bs)';
        document.getElementById('venta_unidad_label').textContent = 'Venta por ' + unidad + ' (Bs)';
    });

    // Función para actualizar costo por unidad y precio de compra al modificar precio compra
    document.getElementById('precio_compra').addEventListener('input', function() {
        actualizarCostoUnidad();
    });

    // Función para actualizar precio compra y costo por unidad al modificar costo por unidad
    document.getElementById('costo_unidad').addEventListener('input', function() {
        actualizarPrecioCompra();
    });

    // Función para actualizar precio venta al modificar venta por unidad
    document.getElementById('venta_unidad').addEventListener('input', function() {
        actualizarPrecioVenta();
    });

    // Función para actualizar venta por unidad al modificar precio venta
    document.getElementById('precio_venta').addEventListener('input', function() {
        actualizarVentaUnidad();
    });

    // Función para actualizar costo por unidad al modificar cantidad
    document.getElementById('cantidad').addEventListener('input', function() {
        actualizarCostoUnidad();
    });

    // Función para actualizar precio compra al modificar cantidad o costo por unidad
    function actualizarPrecioCompra() {
        var costoUnidad = parseFloat(document.getElementById('costo_unidad').value);
        var cantidad = parseFloat(document.getElementById('cantidad').value);
        var precioCompra = costoUnidad * cantidad;
        document.getElementById('precio_compra').value = isNaN(precioCompra) ? '' : precioCompra.toFixed(2);
    }

    // Función para actualizar costo por unidad al modificar precio compra o cantidad
    function actualizarCostoUnidad() {
        var precioCompra = parseFloat(document.getElementById('precio_compra').value);
        var cantidad = parseFloat(document.getElementById('cantidad').value);
        var costoUnidad = precioCompra / cantidad;
        document.getElementById('costo_unidad').value = isNaN(costoUnidad) ? '' : costoUnidad.toFixed(2);
    }

    // Función para actualizar precio venta al modificar cantidad o venta por unidad
    function actualizarPrecioVenta() {
        var ventaUnidad = parseFloat(document.getElementById('venta_unidad').value);
        var cantidad = parseFloat(document.getElementById('cantidad').value);
        var precioVenta = ventaUnidad * cantidad;
        document.getElementById('precio_venta').value = isNaN(precioVenta) ? '' : precioVenta.toFixed(2);
    }

    // Función para actualizar venta por unidad al modificar precio venta o cantidad
    function actualizarVentaUnidad() {
        var precioVenta = parseFloat(document.getElementById('precio_venta').value);
        var cantidad = parseFloat(document.getElementById('cantidad').value);
        var ventaUnidad = precioVenta / cantidad;
        document.getElementById('venta_unidad').value = isNaN(ventaUnidad) ? '' : ventaUnidad.toFixed(2);
    }
</script>
