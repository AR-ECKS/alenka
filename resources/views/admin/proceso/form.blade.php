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
                    <option value="{{ $despacho->id }}" {{ isset($proceso) && $proceso->despacho_id == $despacho->id ? 'selected' : '' }}
                        data-sender="{{ $despacho->user->username}}"
                        data-receiber="{{ $despacho->receptor_u->username}}"
                        data-observation="{{ $despacho->observacion }}">
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
            <div class="col-sm-5" id="detalles">
                <div class="card card-proveedor">
                    <div class="card-body">
                        <div class="author">
                            <b>
                                <h5>Detalles de Despacho:</h5>
                            </b>

                        </div>
                        <div class="card-description">
                            <b>Envio de:</b> <span id="envioDe"></span> <br>
                            <b>Para:</b> <span id="para"></span> <br>
                            <b>Observación</b> <span id="observacion"></span> <br>
                            <b>Kg aproximados</b> <span id="kgAprox"></span> kg
                        </div>
                    </div>
                    {{-- <div class="card-footer">

                    </div> --}}
                </div>
            </div>
            <div class="col-sm-7">
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

        <div class="row">
            <div class="col-sm-6">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Total Kg' }}</b></div>
                    </div>
                    <input type="text" class="form-control" id="total" name="total" value="{{ isset($proceso->total) ? $proceso->total : '' }}" readonly>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-user-edit" style="padding-right:5px"></i><b>{{ 'Sabor' }}</b></div>
                    </div>
                    <input type="text" class="form-control" id="id_sabor" name="id_sabor" value="{{-- isset($proceso->total) ? $proceso->total : '' --}}">
                    {{-- <select class="form-control" id="nombre_sabor" name="id_sabor" required>
                        <option value="" disabled selected>Por favor seleccione una máquina</option>
                            <option value="1">Máquina 1</option>
                            <option value="2">Máquina 2</option>
                            <option value="3">Máquina 3</option>
                            <option value="4">Máquina 4</option>
                            <option value="5">Máquina 5</option>
                            <option value="6">Máquina 6</option>
                            <option value="7">Máquina 7</option>
                            <option value="8">Máquina 8</option>
                            <option value="9">Máquina 9</option>
                    </select> --}}
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
            const maxKg = Number.parseFloat( $('#kgAprox').text() );

            let total = (baldes * cantidad) + cantidadIncompleto;
            document.getElementById('total').value = total;

            if(total > maxKg){
                document.querySelector('#total').classList.add('is-invalid');
            } else {
                document.querySelector('#total').classList.remove('is-invalid')
            }
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
    const U_1LB_A_KG = .453592;

    $(document).ready(function() {
        // Escuchar el cambio en el select de despachos
        $('#despacho_id').change(function() {
            var despachoId = $(this).val();
            if( despachoId && despachoId!==""){
                $("#detalles").removeClass("d-none");
                $('#envioDe').text( $(this)[0].selectedOptions[0].getAttribute('data-sender') );
                $('#para').text( $(this)[0].selectedOptions[0].getAttribute('data-receiber') );
                $('#observacion').text( $(this)[0].selectedOptions[0].getAttribute('data-observation') );
                $('#kgAprox').text( '0' );
            } else {
                $("#detalles").addClass("d-none");
            }

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
                            let tot_aprox = 0;
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

                                if(detalle.materia_prima.unidad_medida=='kg'){
                                    tot_aprox += Number.parseFloat(detalle.cantidad_unidad);
                                } else if(detalle.materia_prima.unidad_medida=='lb'){
                                    tot_aprox += ( Number.parseFloat(detalle.cantidad_unidad) * U_1LB_A_KG);
                                }
                            });
                            tot_aprox = Number.parseFloat(tot_aprox).toFixed(2);
                            $('#kgAprox').text( tot_aprox );
                            console.log('esperado', tot_aprox, 'kg.');
                            if(tot_aprox > 0){
                                document.querySelector('#despacho_id').classList.remove('is-invalid');
                            } else {
                                document.querySelector('#despacho_id').classList.add('is-invalid');
                            }
                        } else {
                            console.log('No llegan datos.');
                            document.querySelector('#despacho_id').classList.add('is-invalid');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar detalles de despacho:', error);
                    }
                });
            } else {
                // Limpiar la tabla si no se selecciona ningún despacho
                $('#detalleDespachoBody').empty();
                document.querySelector('#despacho_id').classList.add('is-invalid');
                console.log('No se ha seleccionado un despacho.');
            }

            // validar
            /* const kgAprox = Number.parseFloat( $('#kgAprox').text() );
            console.log(kgAprox);

            if(kgAprox > 0){
                document.querySelector('#despacho_id').classList.add('is-invalid');
            } else {
                document.querySelector('#despacho_id').classList.remove('is-invalid');
            } */
        });

        // Trigger para cargar detalles si hay un despacho seleccionado inicialmente
        $('#despacho_id').trigger('change');

        $('form').submit(function(event) {
            // validaciones antes de enviar el formulario
            let errors = false;
            let str_errores = '';
            if($('#despacho_id').val()==""){
                errors = true;
                str_errores += `<li>No se ha seleccionado materia prima.</li>`;
                document.querySelector('#despacho_id').classList.add('is-invalid');
            }
            const totalAprox = Number.parseFloat( $('#kgAprox').text() );
            //console.log('max', totalAprox);
            if(0 >= totalAprox){
                errors = true;
                str_errores += `<li>La materia prima recibida no contiene registros, seleccione otro</li>`;
                document.querySelector('#despacho_id').classList.add('is-invalid');
            }

            const inSalieron = document.querySelector('#baldes');
            const inKg = document.querySelector('#cantidad');
            const outTotal = document.querySelector('#total');

            if(inSalieron.value == ''){
                errors = true;
                str_errores += `<li>Cantidad de tachos no debe estar vacía.</li>`;
                inSalieron.classList.add('is-invalid');
            }
            if(inKg.value == ''){
                errors = true;
                str_errores += `<li>Cantidad de <b>Kg</b> no debe estar vacía.</li>`;
                inKg.classList.add('is-invalid');
            }
            if(outTotal.value > Number.parseFloat( $('#kgAprox').text() ) ){
                errors = true;
                str_errores += `<li>El peso total excede el máximo permitido en Kg.</li>`;
                outTotal.classList.add('is-invalid');
            }


            if(errors==false){
                console.log('LISTO PARA ENVIAR');
                $('form').submit();
            } else {
                event.preventDefault();
                event.stopPropagation();
                Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: str_errores,
                        //text: 'La cantidad ingresada excede los límites disponibles.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
            }
        });

        $('#baldes').change((evt) => {
            //console.log($('#baldes').val(), $('#baldes').val() == '');
            //$('form').validate();
            if($('#baldes').val() == ''){
                document.querySelector('#baldes').classList.add('is-invalid');
            } else {
                document.querySelector('#baldes').classList.remove('is-invalid');
                if(0 >= $('#baldes').val()){
                    $('#baldes').val('1');
                } //else if($('#baldes').val() <= )
            }
        });
        $('#cantidad').change((evt) => {
            //console.log($('#baldes').val(), $('#baldes').val() == '');
            //$('form').validate();
            if($('#cantidad').val() == ''){
                document.querySelector('#cantidad').classList.add('is-invalid');
            } else {
                document.querySelector('#cantidad').classList.remove('is-invalid');
                if(0 >= $('#cantidad').val()){
                    $('#cantidad').val('1');
                }
            }
        });
        $('#cantidad_incompleto').change((evt) => {
            if($('#incompleto').checked){
                document.querySelector('#cantidad_incompleto').classList.remove('is-invalid');
            } else {
                if($('#cantidad_incompleto').val() == ''){
                    document.querySelector('#cantidad_incompleto').classList.add('is-invalid');
                } else {
                    document.querySelector('#cantidad_incompleto').classList.remove('is-invalid');
                    if(0 >= $('#cantidad_incompleto').val()){
                        $('#cantidad_incompleto').val('.1');
                    }
                }
            }
        });

        /* $('#baldes').change((evt) => {
            //console.log( $('#cantidad').val() == '');
            //$('form').validate();
            if( $('#cantidad').val() !== '' ){
                const number = Number($('#cantidad').val());
                if(!isNaN(number)){
                    if(number > 0 && number <= Number.parseFloat( $('#kgAprox').text() )){
                        document.querySelector('#baldes').classList.remove('is-invalid');
                    } else {
                        document.querySelector('#baldes').classList.add('is-invalid');
                    }
                }
            }
        }); */
    });
</script>
