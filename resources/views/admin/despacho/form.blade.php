<div class="row">

    <div class="col-sm-6">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-user-edit" style="padding-right:1px"></i><b>{{ 'Entregar a' }}</b>
                </div>
            </div>
            <select class="form-control" id="usuario" name="receptor" required>
                <option value="" disabled selected>Por favor seleccione un usuario</option>
                @foreach ($users->filter(fn($user) => $user->primary_role && $user->primary_role->name === 'MOLINO') as $user)
                    <option value="{{ $user->id }}"
                        {{ isset($despacho->user_id) && $despacho->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} - {{ $user->primary_role->name }}
                    </option>
                @endforeach

            </select>

        </div>
    </div>



    <div class="col-sm-6">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Fecha' }}</b>
                </div>
            </div>
            <input type="text" class="form-control" id="fecha" name="fecha"
                value="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-user-edit" style="padding-right:1px"></i><b>{{ 'Sabor' }}</b>
                </div>
            </div>
            <select class="form-control" id="sabor" name="sabor" required>
                <option value="" disabled selected>Por favor seleccione el sabor de salida</option>
                @foreach ($sabores as $sabor)
                    <option value="{{ $sabor }}" > {{$sabor}} </option>
                @endforeach

            </select>

        </div>
    </div>

    <div class="col-sm-6">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Codigo' }}</b>
                </div>
            </div>
            <input type="text" class="form-control" maxlength="50" id="codigo" name="codigo" readonly
                value="{{ isset($codigo) ? $codigo : '' }}">
        </div>
    </div>


    <div class="col-sm-6">
        <table id="tablaProductos" style="font-size: 14px"
            class="table table-sm table-responsive table-striped table-bordered pt">
            <thead class="text-sm thead-dark" class="inventario">
                <tr>
                    <th>Producto</th>
                    <th>Stock Presentacion</th>
                    <th>Stock Unidad</th>
                    <th>Cantidad Presentacion</th>
                    <th>Cantidad Unidad</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($materia_primas as $index => $materia_prima)
                    <tr id="producto_{{ $index }}">
                        <td>{{ $materia_prima->nombre }}</td>
                        <td id="stock_presentacion_{{ $index }}">
                            <b>{{ $materia_prima->stock_presentacion }}</b> {{ $materia_prima->presentacion }}s</td>
                        <td id="stock_unidad_{{ $index }}"><b>{{ $materia_prima->stock_unidad }}</b>
                            {{ $materia_prima->unidad_medida }}</td>
                        <td>
                            <input type="text" class="form-control" id="presentacion_{{ $index }}"
                                data-cantidad="{{ $materia_prima->cantidad }}" data-max="{{ $materia_prima->stock_presentacion }}"
                                oninput="calcularUnidad({{ $index }})">
                        </td>
                        <td>
                            <input type="text" class="form-control" id="unidad_{{ $index }}"
                                data-cantidad="{{ $materia_prima->cantidad }}" data-max="{{ $materia_prima->stock_unidad }}"
                                oninput="calcularPresentacion({{ $index }})"
                                {{-- max="{{$materia_prima->cantidad}}" --}}>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success agregar-btn"
                                onclick="agregarProducto({{ $index }}, '{{ $materia_prima->id }}', '{{ $materia_prima->nombre }}', '{{ $materia_prima->presentacion }}', '{{ $materia_prima->unidad_medida }}', {{ $materia_prima->cantidad }}, {{ $materia_prima->stock_presentacion }}, {{ $materia_prima->stock_unidad }})"
                                style="display: {{ $materia_prima->stock_presentacion == 0 || $materia_prima->stock_unidad == 0 ? 'none' : 'inline-block' }};">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="col-sm-6">
        <table id="tablaCarrito" style="font-size: 14px"
            class="table table-sm table-responsive table-striped table-bordered pt">
            <thead class="text-sm thead-dark" class="inventario">
                <tr>
                    <th>Producto</th>
                    <th>Presentacion</th>
                    <th>U/Medida</th>
                    <th>Cantidad Presentacion</th>
                    <th>Cantidad Unidad</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se agregarán los productos seleccionados -->
            </tbody>
        </table>
    </div>

    <div class="col-sm-12">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Total' }}</b>
                </div>
            </div>
            <input type="text" class="form-control" id="total" readonly name="total" value="">
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Observacion' }}</b>
            </div>
        </div>
        <input type="text" class="form-control" maxlength="50" id="observacion" name="observacion"
            value="{{ isset($despacho->observacion) ? $despacho->observacion : '' }}">
    </div>
</div>

{{-- <div class="col-sm-12">
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Salida Esperada' }}</b>
            </div>
        </div>
        <input type="text" class="form-control" maxlength="50" id="salida_esperada" name="salida_esperada" value="{{ isset($despacho->salida_esperada) ? $despacho->salida_esperada : '' }}">
    </div>
</div> --}}

<input type="hidden" id="carrito" name="carrito">

<div class="float-right">
    <button type="submit" class="btn-primary btn" onclick="enviarCarrito()">
        Registrar
    </button>
</div>

<script>
    const operation = '{{$formMode}}';
    let carrito = [];

    function calcularUnidad(index) {
        let presentacionInput = document.getElementById(`presentacion_${index}`);
        let unidadInput = document.getElementById(`unidad_${index}`);
        let cantidad = parseFloat(presentacionInput.getAttribute('data-cantidad'));
        let max = parseFloat(presentacionInput.getAttribute('data-max'));
        let presentacionValue = parseFloat(presentacionInput.value);

        if (!isNaN(presentacionValue) && !isNaN(cantidad)) {
            //console.log(presentacionInput.value, '>',max);
            if(0 >= presentacionInput.value ){
                presentacionInput.value = 1.00;
            }
            if(presentacionInput.value > max) {
                presentacionInput.value = max;
            }
            unidadInput.value = presentacionInput.value * cantidad;
        } else {
            unidadInput.value = '';
        }
    }

    function calcularPresentacion(index) {
        let presentacionInput = document.getElementById(`presentacion_${index}`);
        let unidadInput = document.getElementById(`unidad_${index}`);
        let cantidad = parseFloat(unidadInput.getAttribute('data-cantidad'));
        let max = parseFloat(unidadInput.getAttribute('data-max'));
        let unidadValue = parseFloat(unidadInput.value);

        if (!isNaN(unidadValue) && !isNaN(cantidad)) {
            if(0 >= unidadInput.value ){
                unidadInput.value = 1.00;
            }
            if(unidadInput.value > max) {
                unidadInput.value = max;
            }
            presentacionInput.value = unidadInput.value / cantidad;
        } else {
            presentacionInput.value = '';
        }
    }


    function agregarProducto(index, id, nombre, presentacion, unidad_medida, cantidad, stock_presentacion,
    stock_unidad) {
        let presentacionInput = document.getElementById(`presentacion_${index}`);
        let unidadInput = document.getElementById(`unidad_${index}`);
        let presentacionValue = parseFloat(presentacionInput.value);
        let unidadValue = parseFloat(unidadInput.value);

        if (isNaN(presentacionValue) || isNaN(unidadValue)) {
            Swal.fire('Error', 'Por favor, ingrese cantidades válidas', 'error');
            return;
        }

        if (presentacionValue > stock_presentacion || unidadValue > stock_unidad) {
            Swal.fire('Error', 'Cantidad mayor al stock disponible', 'error');
            return;
        }

        let producto = {
            id: id, // Agregamos el id del producto al objeto producto
            index: index,
            nombre: nombre,
            presentacion: presentacion,
            unidad_medida: unidad_medida,
            cantidad_presentacion: presentacionValue || 0,
            cantidad_unidad: unidadValue || 0
        };

        let productoExistente = carrito.find(p => p.index === index);
        if (productoExistente) {
            Swal.fire('Error', 'El producto ya está en el carrito', 'error');
            return;
        }

        carrito.push(producto);
        actualizarTablaCarrito();

        document.querySelector(`#producto_${index} .agregar-btn`).disabled = true;

        actualizarStock(index, -presentacionValue, -unidadValue);

        limpiarInputs();
    }

    function actualizarTablaCarrito() {
        let tbodyCarrito = document.querySelector('#tablaCarrito tbody');
        tbodyCarrito.innerHTML = '';

        carrito.forEach(producto => {
            let row = `
                <tr>
                    <td>${producto.nombre}</td>
                    <td>${producto.presentacion}</td>
                    <td>${producto.unidad_medida}</td>
                    <td>${producto.cantidad_presentacion}</td>
                    <td>${producto.cantidad_unidad}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarProducto(${producto.index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbodyCarrito.insertAdjacentHTML('beforeend', row);
        });

        calcularTotal();
    }

    function eliminarProducto(index) {
        let producto = carrito.find(p => p.index === index);
        carrito = carrito.filter(p => p.index !== index);
        actualizarTablaCarrito();

        document.querySelector(`#producto_${index} .agregar-btn`).disabled = false;

        actualizarStock(index, producto.cantidad_presentacion, producto.cantidad_unidad);
    }

    function actualizarStock(index, cantidadPresentacion, cantidadUnidad) {
        let stockPresentacionElem = document.getElementById(`stock_presentacion_${index}`);
        let stockUnidadElem = document.getElementById(`stock_unidad_${index}`);

        let stockPresentacionActual = parseFloat(stockPresentacionElem.querySelector('b').innerText);
        let stockUnidadActual = parseFloat(stockUnidadElem.querySelector('b').innerText);

        let nuevaPresentacion = (stockPresentacionActual + cantidadPresentacion).toFixed(2);
        let nuevaUnidad = (stockUnidadActual + cantidadUnidad).toFixed(2);

        stockPresentacionElem.querySelector('b').innerText = nuevaPresentacion;
        stockUnidadElem.querySelector('b').innerText = nuevaUnidad;
    }

    function calcularTotal() {
        let totalUnidad = carrito.reduce((acc, producto) => acc + parseFloat(producto.cantidad_unidad), 0);
        document.getElementById('total').value = `${totalUnidad.toFixed(2)}`;
    }

    function enviarCarrito(ev) {
        /* console.log(JSON.stringify(carrito));
        ev.preventDefault();
        document.getElementById('carrito').value = JSON.stringify(carrito); */
    }

    function limpiarInputs() {
        document.querySelectorAll('#tablaProductos input[type="text"]').forEach(input => {
            input.value = '';
        });
    }
</script>
<script>
    $(document).ready(function() {
        $(".table").DataTable({
            lengthMenu: [10, 25, 50],
            order: [

                [3, "asc"],
            ],
            language: {
                decimal: "",
                emptyTable: "No hay datos",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(Filtro de _MAX_ total registros)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Mostrar _MENU_ registros",
                loadingRecords: "Cargando...",
                processing: "Procesando...",
                search: "Buscar:",
                zeroRecords: "No se encontraron coincidencias",

                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>',
                },
                aria: {
                    sortAscending: ": Activar orden de columna ascendente",
                    sortDescending: ": Activar orden de columna desendente",
                },
            },

        });

        // evitar que se envie el form
        $("form").on('submit', function(evt){
            const data = JSON.stringify(carrito);
            // validaciones del formulario
            if(operation=='create'){
                if(carrito.length == 0){
                    evt.preventDefault();
                    Swal.fire('Error', 'Sin materias primas para enviar. \nAl menos debe de existir 1 producto en el carrito', 'ERROR');
                    console.log('no esta completo ', operation);
                    return;
                } else {
                    document.getElementById('carrito').value = JSON.stringify(carrito);
                    /* evt.preventDefault();
                    console.log('enviado', carrito); */
                }
            } else {
                // en el caso de EDITAR
                document.getElementById('carrito').value = JSON.stringify(carrito);
            }
            // tu codigo aqui
        });
    });
</script>
