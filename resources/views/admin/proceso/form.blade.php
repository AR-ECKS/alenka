<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<div class="row">
    <div class="col-sm-5">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Materia prima recibida' }}</b></div>
            </div>
            <select class="form-control" id="despacho_id" name="despacho_id" required>
                <option value="">Selecciona un despacho</option>
                @foreach ($despachos as $despacho)
                    <option value="{{ $despacho->id }}" {{ isset($proceso) && $proceso->despacho_id == $despacho->id ? 'selected' : '' }}>
                        {{ $despacho->codigo }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-user-edit" style="padding-right:5px"></i><b>Código</b></div>
            </div>
            <input type="text" class="form-control" maxlength="50" id="codigo" name="codigo" value="{{ $codigo }}" readonly>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-calendar-alt" style="padding-right:5px"></i><b>{{ 'Fecha' }}</b></div>
            </div>
            <input readonly type="date" class="form-control" id="fecha" name="fecha" value="{{ isset($fechaActual) ? $fechaActual : date('Y-m-d') }}">
        </div>
    </div>


</div>
<div class="col-sm-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <table class="table table-responsive table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Materia Prima</th>
                            <th>Cantidad Presentación</th>
                            <th>Cantidad Unidad</th>
                        </tr>
                    </thead>
                    <tbody id="detalleDespachoBody">
                        <!-- Aquí van los detalles del despacho -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="alert alert-primary text-center" role="alert">
                    <h5 class="mb-3">Salida de tachos completos</h5>
                    <div class="d-flex align-items-center justify-content-center">
                        <p class="mb-0 mr-2">Salieron:</p>
                        <input type="number" class="form-control" style="max-width:5em" id="baldes" name="baldes" value="{{ isset($proceso->baldes) ? $proceso->baldes : '' }}">
                        <p class="mb-0 mr-2 mx-2"> tachos completos, cada tacho contiene</p>
                        <input type="number" class="form-control" style="max-width:5em" id="cantidad" name="cantidad" value="{{ isset($proceso->cantidad) ? $proceso->cantidad : '' }}">
                        <p class="mb-0 mx-2"> Kg</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-sm-6">
                <div class="alert alert-success text-center" role="alert">
                    <div class="d-flex flex-column align-items-center">
                        <h5 class="mb-0">Salida de tachos incompletos</h5>
                        <div class="custom-control custom-switch mt-3">
                            <input type="checkbox" class="custom-control-input" id="incompleto" name="incompleto" value="{{ isset($proceso->incompleto) ? $proceso->incompleto : '' }}">
                            <label class="custom-control-label" for="incompleto"></label>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mt-3">
                            <p class="mb-0 mr-2">Salió un tacho incompleto con:</p>
                            <input type="number" style="max-width: 5em;" class="form-control form-control-sm mx-2 text-center" id="cantidad_incompleto" name="cantidad_incompleto" value="{{ isset($proceso->cantidad_incompleto) ? $proceso->cantidad_incompleto : '' }}" disabled>
                            <p class="mb-0">kg</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="col-sm-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Total Kg' }}</b></div>
                    </div>
                    <input type="text" class="form-control" id="total" name="total" value="{{ isset($proceso->total) ? $proceso->total : '' }}" readonly>
                </div>
            </div>


            <div class="col-sm-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Observación' }}</b></div>
                    </div>
                    <input type="text" class="form-control" maxlength="50" id="observacion" name="observacion" value="{{ isset($proceso->observacion) ? $proceso->observacion : '' }}">
                </div>
            </div>
        </div>
        </div>

        <div class="float-right">
            <button type="submit" class="btn-primary btn">{{ $formMode === 'edit' ? 'Actualizar' : 'Registrar' }}</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function calculateTotal() {
            let baldes = parseFloat(document.getElementById('baldes').value) || 0;
            let cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
            let cantidadIncompleto = parseFloat(document.getElementById('cantidad_incompleto').value) || 0;

            let total = (baldes * cantidad) + cantidadIncompleto;
            document.getElementById('total').value = total;
        }

        document.getElementById('baldes').addEventListener('input', calculateTotal);
        document.getElementById('cantidad').addEventListener('input', calculateTotal);
        document.getElementById('cantidad_incompleto').addEventListener('input', calculateTotal);

        document.getElementById('incompleto').addEventListener('change', function() {
            let cantidadIncompleto = document.getElementById('cantidad_incompleto');
            if (this.checked) {
                cantidadIncompleto.removeAttribute('disabled');
            } else {
                cantidadIncompleto.setAttribute('disabled', 'disabled');
                cantidadIncompleto.value = 0; // Resetear valor si el checkbox está desactivado
            }
            calculateTotal();
        });

        calculateTotal(); // Calcular el total inicial al cargar la página
    });
</script>
<script>
    $(document).ready(function() {
        // Escuchar el cambio en el select de despachos
        $('#despacho_id').change(function() {
            var despachoId = $(this).val();
            if (despachoId) {
                // Hacer una solicitud AJAX para obtener los detalles de despacho
                $.ajax({
                    url: "{{ route('getDetalleDespacho') }}",
                    type: "GET",
                    data: {
                        despacho_id: despachoId
                    },
                    success: function(response) {
                        // Mostrar en consola los datos recibidos
                        console.log('Datos recibidos:', response);

                        // Limpiar el cuerpo de la tabla
                        $('#detalleDespachoBody').empty();

                        if (response.length > 0) {
                            // Recorrer los datos recibidos y agregar filas a la tabla
                            $.each(response, function(index, detalle) {
                                var row = '<tr>' +

                                    '<td>' + detalle.materia_prima.nombre +
                                    '</td>' +
                                    '<td><b>' + detalle.cantidad_presentacion +
                                    '</b>' +
                                    ' ' + detalle.materia_prima.presentacion + 's' +
                                    '</td>' +
                                    '<td><b>' + detalle.cantidad_unidad + '</b> ' +
                                    detalle.materia_prima.unidad_medida +
                                    '</td>' +
                                    '</tr>';
                                $('#detalleDespachoBody').append(row);
                            });

                        } else {
                            console.log('No llegan datos.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar detalles de despacho:', error);
                    }
                });
            } else {
                // Limpiar la tabla si no se selecciona ningún despacho
                $('#detalleDespachoBody').empty();
                console.log('No se ha seleccionado un despacho.');
            }
        });

        // Trigger para cargar detalles si hay un despacho seleccionado inicialmente
        $('#despacho_id').trigger('change');
    });
</script>
