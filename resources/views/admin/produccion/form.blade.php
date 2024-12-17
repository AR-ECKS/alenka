    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}
@push('custom_css')
    <link rel="stylesheet" href="{{ asset('libs/bootstrap-5.3.3-dist/css/bootstrap.min.css') }}">
    @livewireStyles
@endpush
    <div class="row">

        <div class="col-sm-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-user-edit" style="padding-right:5px"></i>
                        <b>{{ 'Código' }}</b>
                    </div>
                </div>
                <input readonly type="text" class="form-control" maxlength="50" id="codigo" name="codigo"
                    value="{{ $codigo }}">
            </div>
        </div>



        <div class="col-sm-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"
                            style="padding-right:5px"></i><b>{{ 'Fecha' }}</b></div>
                </div>
                <input readonly type="date" class="form-control" id="fecha" name="fecha"
                    value="{{ isset($fechaActual) ? $fechaActual : date('Y-m-d') }}">
            </div>
        </div>

        <div class="col-sm-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"> <i class="fas fa-user-edit"
                            style="padding-right:5px"></i><b>Proceso</b>
                    </div>
                </div>
                <input type="text" class="form-control" maxlength="50" id="proceso_id_mostrar"
                    value="{{ $proceso->codigo }}" readonly>
                <input type="hidden" id="proceso_id" name="proceso_id" value="{{ $proceso->id }}">
            </div>
        </div>


        <div class="col-sm-12">
            <div class="alert alert-primary text-center" role="alert">
                <h6 class="mb-1" style="color: #000"> <b class="mx-2">{{ $fin_total_baldes }} </b>baldes totales, que son <b class="mx-2">{{ $fin_total_kg }}</b> kilos </h6>
                <h5 class="mb-3"> <b id="totalBaldesDisponibles" class="mx-2">
                        {{ $total_baldes }} </b>baldes disponibles, que son <b id="totalKgDisponibles"
                        class="mx-2">
                        {{ $total_kg }} </b>kilos </h5>
                    {{ json_encode($lista_detalles_produccion) }}
            </div>
        </div>



        <div class="col-md-2">
            <div class="form-group">
                <label for="cantidad_baldes" class="control-label">{{ 'Cantidad en Baldes:' }}</label>
                <input class="form-control" name="cantidad_baldes" type="number" id="cantidad_baldes">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="cantidad_kilos" class="control-label">{{ 'Cantidad en Kilos:' }}</label>
                <input class="form-control" name="cantidad_kilos" type="number" id="cantidad_kilos">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="usuario" class="control-label">{{ 'Seleccionar Usuario:' }}</label>
                <select class="form-control" id="usuario" name="usuario">
                    <option value="">Seleccione un usuario...</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" data-maquina="{{ $usuario->maquina }}">
                            {{ $usuario->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="maquina" class="control-label">{{ 'Máquina Asignada:' }}</label>
                <select class="form-control" id="maquina" name="maquina">
                    <option value="">Seleccione una máquina...</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->maquina }}" data-usuario="{{ $usuario->id }}">
                            {{ $usuario->maquina }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Capturar el evento de cambio en el selector de usuarios
                $('#usuario').change(function() {
                    var selectedUserId = $(this).val();
                    var selectedMaquina = $(this).find(':selected').data('maquina');

                    // Asignar el valor de la máquina al selector correspondiente
                    $('#maquina').val(selectedMaquina);

                    // Marcar como seleccionado el usuario correspondiente a la máquina
                    $('#maquina').trigger('change');
                });

                // Capturar el evento de cambio en el selector de máquina
                $('#maquina').change(function() {
                    var selectedMaquina = $(this).val();
                    var selectedUserId = $(this).find(':selected').data('usuario');

                    // Asignar el valor del usuario al selector correspondiente
                    $('#usuario').val(selectedUserId);
                });
            });
        </script>


        <div class="col-md-1">
            <div class="form-group">
                <label for="agregar">&nbsp;</label>
                <button id="agregar" class="btn btn-success">Agregar</button>
            </div>
        </div>

        <div class="col-sm-12">
            <!-- Tabla para mostrar los datos ingresados -->
            <div class="table-responsive">
                <table id="tablaCarrito" class="table table-sm table-striped table-bordered pt w-100">
                    <thead class="thead-dark">
                        <tr>
                            <th>Cantidad Tachos</th>
                            <th>Cantidad Kilos</th>
                            <th>Usuario</th>
                            <th>Maquina</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyCarrito">
                        <!-- Aquí se agregarán los productos seleccionados dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>


        <div class="col-sm-12">
            <!-- Observación -->
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Observacion' }}</b>
                    </div>
                </div>
                <input type="text" class="form-control" maxlength="50" id="observacion" name="observacion"
                    value="{{ isset($produccion->observacion) ? $produccion->observacion : '' }}">
            </div>
        </div>
    </div>
    <input type="hidden" id="carrito" name="carrito">
    <div class="float-right">
        <!-- Botón para guardar o actualizar el formulario -->
        <button type="submit" class="btn-primary btn">
            {{ $formMode === 'edit' ? 'Actualizar' : 'Registrar' }}
        </button>
    </div>

    {{-- INIT CUSTOM LIVEWIRE --}}
    {{-- <div class="row"> --}}
        {{-- @livewire('producciones-index', ['id_proceso' => $proceso->id]) --}}
    {{-- </div> --}}
    {{-- END CUSTOM LIVEWIRE --}}

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            var carrito = []; // Array para almacenar los datos ingresados
            var totalBaldesDisponibles = {{ $proceso->total_baldes }};
            var totalKgDisponibles = {{ $proceso->total_cantidad }}; // Función para agregar los datos a la tabla
            function agregarAlCarrito(cantidadBaldes, cantidadKilos, operadorId, maquina) {
                // Limpiar el operador eliminando saltos de línea y espacios innecesarios
                var operadorNombre = $('#usuario option:selected').text().trim().replace(/\s+/g, ' ');

                // Validar que no se exceda el límite
                if (cantidadBaldes > totalBaldesDisponibles || cantidadKilos > totalKgDisponibles) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La cantidad ingresada excede los límites disponibles.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                // Validar que el usuario no esté ya en el carrito
                var usuarioYaSeleccionado = carrito.some(function(item) {
                    return item.operadorId === operadorId;
                });

                if (usuarioYaSeleccionado) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Usuario ya seleccionado',
                        text: 'Por favor, seleccione otro usuario.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                    return; // Salir de la función si el usuario ya está seleccionado
                }

                var item = {
                    cantidadBaldes: cantidadBaldes,
                    cantidadKilos: cantidadKilos,
                    operadorId: operadorId, // Agregar el ID del operador al objeto
                    operadorNombre: operadorNombre, // Agregar el nombre del operador al objeto
                    maquina: maquina
                };

                carrito.push(item); // Agregar objeto al array
                console.log('Producto añadido:', item); // Mostrar en consola el producto añadido
                actualizarTabla(); // Actualizar la tabla
                actualizarDisponibles(); // Actualizar la cantidad disponible

                // Limpiar campos solo si la operación fue exitosa
                // Verificar si el usuario fue agregado al carrito
                var usuarioAgregado = carrito.some(function(item) {
                    return item.operadorId === operadorId;
                });


                $('#usuario').val('');
                $('#maquina').val('');


                actualizarCampoCarrito(); // Actualizar campo oculto 'carrito'
            }


            // Función para actualizar la tabla
            function actualizarTabla() {
                $('#tbodyCarrito').empty(); // Limpiar contenido previo

                carrito.forEach(function(item, index) {
                    var fila = '<tr>' +
                        '<td>' + item.cantidadBaldes + '</td>' +
                        '<td>' + item.cantidadKilos + '</td>' +
                        '<td>' + item.operadorNombre + '</td>' + // Mostrar nombre del operador
                        '<td>' + item.maquina + '</td>' +
                        '<td>' +
                        '<button class="btn btn-sm btn-danger eliminar" data-index="' + index +
                        '">Eliminar</button>' +
                        '</td>' +
                        '</tr>';
                    $('#tbodyCarrito').append(fila); // Agregar fila a la tabla
                });

                // Asignar evento click a los botones eliminar
                $('.eliminar').click(function() {
                    var index = $(this).data('index');
                    var deletedItem = carrito.splice(index, 1)[0]; // Eliminar elemento del carrito

                    totalBaldesDisponibles += deletedItem.cantidadBaldes; // Sumar los baldes devueltos
                    totalKgDisponibles += deletedItem.cantidadKilos; // Sumar los kilos devueltos
                    console.log(totalBaldesDisponibles + '///////////////' + totalKgDisponibles);

                    actualizarTabla(); // Actualizar la tabla después de eliminar
                    actualizarDisponibles2(); // Actualizar la cantidad disponible
                    actualizarCampoCarrito(); // Actualizar campo oculto 'carrito'
                    console.log(totalBaldesDisponibles + '++++++++++++++++++' +totalKgDisponibles);

                    console.log(deletedItem.cantidadBaldes + '-------------' + deletedItem.cantidadKilos);
                });
            }

              // Función para actualizar la cantidad disponible
              function actualizarDisponibles2() {
                console.log(totalBaldesDisponibles + '...................' +totalKgDisponibles);


                $('#totalBaldesDisponibles').text(totalBaldesDisponibles.toFixed(1));
                $('#totalKgDisponibles').text(totalKgDisponibles.toFixed(1));
            }
            // Función para actualizar la cantidad disponible
            function actualizarDisponibles() {
                totalBaldesDisponibles -= parseFloat($('#cantidad_baldes').val());
                totalKgDisponibles -= parseFloat($('#cantidad_kilos').val());

                $('#totalBaldesDisponibles').text(totalBaldesDisponibles.toFixed(1));
                $('#totalKgDisponibles').text(totalKgDisponibles.toFixed(1));
            }

            // Función para actualizar el campo oculto 'carrito' con los datos actuales
            function actualizarCampoCarrito() {
                $('#carrito').val(JSON.stringify(carrito)); // Convertir el array a JSON y asignarlo al campo oculto
            }

            // Evento change del input cantidad_baldes
            $('#cantidad_baldes').on('input', function() {
                var cantidadBaldes = $(this).val();
                if(0 > cantidadBaldes ){
                    cantidadBaldes = 1;
                    $(this).val(cantidadBaldes);
                }
                var cantidadKilos = cantidadBaldes * {{ $proceso->cantidad }};
                $('#cantidad_kilos').val(cantidadKilos.toFixed(1));
            });

            // Evento change del input cantidad_kilos
            $('#cantidad_kilos').on('input', function() {
                var cantidadKilos = $(this).val();
                if(0 > cantidadKilos ){
                    cantidadKilos = 1;
                    $(this).val(cantidadKilos);
                }
                var cantidadBaldes = cantidadKilos / {{ $proceso->cantidad }};
                $('#cantidad_baldes').val(cantidadBaldes.toFixed(1));
            });
            $('#agregar').click(function(event) {
                event.preventDefault(); // Prevenir comportamiento por defecto del botón (enviar formulario)

                var cantidadBaldes = parseFloat($('#cantidad_baldes').val());
                var cantidadKilos = parseFloat($('#cantidad_kilos').val());
                var operador = $('#usuario').val(); // Obtener el ID del usuario seleccionado para la validación
                var operadorNombre = $('#usuario option:selected').text(); // Obtener el nombre del usuario seleccionado para mostrar

                var maquina = $('#maquina').val();

                // Validar que los campos no estén vacíos y no se exceda el límite
                if (cantidadBaldes && cantidadKilos && operador && maquina) {
                    // Validar que el usuario no esté ya en el carrito
                    var usuarioYaSeleccionado = false;
                    carrito.forEach(function(item) {
                        if (item.operador === operador) {
                            usuarioYaSeleccionado = true;
                            return false; // Salir del bucle forEach si se encontró un usuario repetido
                        }
                    });

                    if (usuarioYaSeleccionado) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Usuario ya seleccionado',
                            text: 'Por favor, seleccione otro usuario.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Aceptar'
                        });
                    } else {
                        agregarAlCarrito(cantidadBaldes, cantidadKilos, operador,
                        maquina); // Pasar operador en lugar de operadorNombre
                        $('#cantidad_baldes').val('');
                        $('#cantidad_kilos').val('');
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Campos incompletos',
                        text: 'Por favor complete todos los campos.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });

            // Evento submit del formulario
            $('form').submit(function(event) {
                // Actualizar campo oculto 'carrito' antes de enviar el formulario
                actualizarCampoCarrito();

                /* if(carrito.length > 0){
                    //pasa
                } else {
                    event.preventDefault();
                } */
            });

            // Prevenir envío del formulario al presionar Enter
            $('form').keypress(function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    return false;
                }
            });

        });
    </script>
@push('custom_js')
    {{-- <script src="{{asset('js/jquery.js')}}"></script> --}}

    @livewireScripts
    <script>
        document.addEventListener('livewire:load', function() {
            console.log('LOAD SUCCESSFULLY');
            Livewire.on('mensaje',(sms) => {
                console.log(sms);
            })
        });
    </script>
@endpush
