<div class="row">
    <div class="col-md-2">
        <div class="form-group {{ $errors->has('fecha_compra') ? 'has-error' : '' }}">
            <label for="fecha_compra" class="control-label">{{ 'Fecha Compra' }}</label>
            <input class="form-control" name="fecha_compra" type="date" id="fecha_compra"
                value="{{ isset($compra->fecha_compra) ? $compra->fecha_compra : date('Y-m-d') }}" readonly>
            {!! $errors->first('fecha_compra', '<p class="help-block">:message</p>') !!}
        </div>
    </div>


    <div class="col-md-2">
        <div class="form-group {{ $errors->has('codigo') ? 'has-error' : '' }}">
            <label for="codigo" class="control-label">{{ 'Codigo' }}</label>
            <input class="form-control" name="codigo" type="text" id="codigo" value="{{ $codigoCompra }}"
                readonly>
            {!! $errors->first('codigo', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group {{ $errors->has('numero_compra') ? 'has-error' : '' }}">
            <label for="numero_compra" class="control-label">{{ 'N° Factura/Recibo' }}</label>
            <input class="form-control" name="factura" type="text" id="numero_compra" required
                value="{{ isset($compra->factura) ? $compra->factura : '' }}">
            {!! $errors->first('numero_compra', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('proveedor_id') ? 'has-error' : '' }}">
            <label for="proveedor_id" class="control-label">{{ 'Proveedor' }}</label>
            <select class="form-control" name="proveedor_id" id="proveedor_id" required>
                <option value="">Selecciona un proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}"
                        {{ isset($compra->proveedor_id) && $compra->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->razon_social }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('proveedor_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group {{ $errors->has('forma_pago') ? 'has-error' : '' }}">
            <label for="forma_pago" class="control-label">{{ 'Forma Pago' }}</label>
            <select class="form-control" name="forma_pago" id="forma_pago" required>
                <option selected="true" disabled="disabled">Seleccione forma de pago</option>
                <option value="Crédito">Crédito</option>
                <option value="Contado">Contado</option>
                <option value="Cheque">Cheque</option>
                <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                <option value="Transferencia Anticipada">Transferencia Anticipada</option>
            </select>
            {!! $errors->first('forma_pago', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

</div>
<br>
<div class="d-flex justify-content-center w-100 my-2">
    <!-- Botón para abrir el modal -->
    <button id="btnMostrarProductos" type="button" class="btn btn-primary" data-toggle="modal"
        data-target="#modalProductos">
        Agregar Productos <i class="fas fa-shopping-cart"></i>
    </button>
</div>

<div class="">
    <table id="tablaDetalle" style="font-size:14px"class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Codigo</th>
                <th>Producto</th>

                {{-- <th>Precio Venta</th> --}}
                {{-- <th style="width:150px"> Lote</th> --}}

                {{-- <th style="width:1%">Fecha <br> Vencimiento</th> --}}
                <th>Precio Compra Bs</th>
                <th>Cantidad</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Opc.</th>
            </tr>
        </thead>
        <tfoot class="" style="width: 100%;">
            <tr>
                <th>TOTAL</th>
                <td colspan="11" style="text-align: right;">
                    <h4 style="display: inline-block;" id="total">Bs. 0.00</h4>
                    <input type="hidden" name="totalc" id="totalc">
                </td>
            </tr>
        </tfoot>
        <tbody>

        </tbody>
    </table>
</div>

<br>
<div class="form-group" style="float: right; margin-top:1em;">
    <input class="btn btn-info" style="float: right;" type="submit" value="GUARDAR COMPRA">
</div>
<script>
    // Obtener la fecha actual en formato ISO
    var fechaActual = new Date().toISOString().split('T')[0];

    // Obtener el input de fecha
    var inputFechaCompra = document.getElementById('fecha_compra');

    // Establecer el valor máximo como la fecha actual
    inputFechaCompra.setAttribute('max', fechaActual);
</script>

<!-- Modal para mostrar los productos -->
<!-- Modal Crear-->
<div class="modal fade modal-xl" id="modalProductos" tabindex="-1" role="dialog" aria-labelledby="modalProductosLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document" style="max-width: 95%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProductosLabel">Productos de <b>
                        <p style="display: inline;font-bold:50" class="proveedor-seleccionado"></p>
                    </b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tablaProductos" style="font-size: 14px"
                    class="table table-sm table-responsive table-striped table-bordered  pt">

                    <thead class="text-sm" class="inventario">
                        <tr>
                            <th>Codigo</th>
                            <th>Producto</th>

                            {{-- <th>Precio Venta</th> --}}
                            <th>Presentacion</th>

                            <th>U/Medida</th>
                            <th>Costo</th>
                            <th>Cantidad</th>

                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/crearcompra.js?v=125675dfhjrtywty676') }}" defer></script>
<script src="{{ asset('js/decimales.js?v=125675dfhj676') }}" defer></script>

<script src="{{ asset('js/crearcompra.js?v=125675df435hj676') }}" defer></script>

<script>
    // Obtener el botón "Guardar"
    const guardarBtn = document.querySelector('#guardar');

    // Agregar un evento "click" al botón "Guardar"
    guardarBtn.addEventListener('click', function(event) {
        // Obtener el valor seleccionado en el campo "Oferta Valida"




        // Obtener el valor seleccionado en el campo "Forma de pago"
        const formaPagoSeleccionada = document.querySelector('[name="formapago"]').value;
        // Si no se ha seleccionado una forma de pago, mostrar un SweetAlert y evitar que se envíe el formulario
        if (formaPagoSeleccionada === 'seleccione forma de pago') {
            event.preventDefault(); // Evita que se envíe el formulario

            Swal.fire({
                title: 'Error',
                text: 'Debes seleccionar una forma de pago',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        var tablaProductos;

        $('#btnMostrarProductos').click(function() {
            if (!$('#proveedor_id').val()) {
                Swal.fire({
                    title: 'Debe seleccionar un proveedor',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                });
                return;
            }
            $('#modalProductos').modal('show');
        });

        $('#proveedor_id').on('change', function() {
            var id = this.value;

            if (tablaProductos) {
                tablaProductos.destroy();
            }

            $('#tablaProductos tbody').empty();
            $('#producto_id').html('');
            tablaProductos = null;

            $.ajax({
                url: '{{ route('getStates') }}?proveedor_id=' + id,
                type: 'get',
                success: function(res) {
                    var nombreProveedor = $('#proveedor_id option:selected').text();
                    var tbody = $("#tablaProductos tbody");
                    $('.proveedor-seleccionado').text(nombreProveedor);

                    $.each(res, function(key, value) {
                        var newRow = $("<tr>").append(
                            $("<input>").attr({
                                type: "hidden",
                                name: "pproducto_id",
                                value: value.id,
                            }),
                            $("<td>").text(value.codigo),
                            $("<td>").text(value.nombre),
                            $("<td>").text(value.presentacion),
                            $("<td>").text(value.unidad_medida),
                            $("<td>").append(
                                $("<input>").attr({
                                    name: "precio_compra",
                                    id: "precio_compra_" + key,
                                    class: "form-control",
                                    maxlength: "10",
                                    step: "0.01"
                                }).on("input", function() {
                                    this.value = this.value.replace(
                                        /[^0-9.]/g, '');
                                    if (!/^\d+(\.\d{0,2})?$/.test(this
                                            .value)) {
                                        this.value = this.value.slice(0, -
                                        1);
                                    }
                                    cal(key);
                                }).val(value.precio_compra)
                            ),
                            $("<td>").text('Cantidad en: ' + value.presentacion)
                            .append(
                                $("<input>").attr({
                                    type: "number",
                                    class: "form-control",
                                    name: "pcantidad_presentacion",
                                    id: "pcantidad_presentacion_" + key,
                                    min: "1",
                                    value: "0",
                                }).on("input", function() {
                                    var cantidadPresentacion = parseFloat($(
                                        this).val());
                                    var cantidadUnidadMedida =
                                        cantidadPresentacion * value
                                        .cantidad;
                                    $("#pcantidad_unidad_" + key).val(
                                        cantidadUnidadMedida);
                                    cal(key);
                                })
                            ),
                            $("<td>").text('Cantidad en: ' + value
                                .unidad_medida).append(
                                $("<input>").attr({
                                    type: "number",
                                    class: "form-control",
                                    name: "pcantidad_unidad",
                                    id: "pcantidad_unidad_" + key,
                                    min: "1",
                                    value: "0",
                                }).on("input", function() {
                                    var cantidadUnidadMedida = parseFloat($(
                                        this).val());
                                    var cantidadPresentacion =
                                        cantidadUnidadMedida / value
                                        .cantidad;
                                    $("#pcantidad_presentacion_" + key).val(
                                        cantidadPresentacion);
                                    cal(key);
                                })
                            ),
                            $("<input>").attr({
                                type: "hidden", // Cambiamos el tipo a hidden para que no sea visible
                                name: "paux", // Nombre del campo que se enviará al servidor
                                value: value.cantidad // Valor que quieres enviar (value.cantidad)
                            }),

                            $("<td>").append(
                                $("<input>").attr({
                                    required: true,
                                    type: "text",
                                    disabled: "disabled",
                                    class: "form-control",
                                    name: "psubtotal",
                                    id: "psubtotal_" + key,
                                    value: "",
                                })
                            ),
                            $("<td>").append(
                                $("<button>").attr({
                                    type: "button",
                                    id: "bt_add",
                                    class: "btn btn-success float-right",
                                }).append(
                                    $("<i>").addClass("fas fa-shopping-cart")
                                )
                            )
                        );

                        tbody.append(newRow);
                        limpiar(); // Limpia todos los inputs de la tabla
                    });

                    tablaProductos = $('#tablaProductos').DataTable({
                        lengthMenu: [10, 25, 50],
                        paging: true
                    });
                }
            });
        });

        $("body").on("input",
            "input[name='precio_compra'], input[name='pcantidad_presentacion'], input[name='pcantidad_unidad']",
            function() {
                var fila = $(this).attr('id').split('_').pop();
                cal(fila);
            });

        function cal(fila) {
            try {
                var row = $("#tablaProductos tbody tr").eq(fila);
                var precio_compra = parseFloat(row.find("input[name='precio_compra']").val()) || 0;
                var cantidad_presentacion = parseFloat(row.find("input[name='pcantidad_presentacion']")
                .val()) || 0;
                var subtotal = (precio_compra * cantidad_presentacion).toFixed(2);
                $("#psubtotal_" + fila).val(subtotal);
            } catch (e) {
                console.log(e);
            }
        }
    });


    var cont = 0;
    var total = 0;
    var subtotal = [];

    $('#tablaProductos').on('click', '#bt_add', function() {
        var row = $(this).closest('tr');
        var id = row.find('input[name="pproducto_id"]').val();
        var codigo = row.find('td:eq(0)').text();
        var nombre = row.find('td:eq(1)').text();
        var unidad_medida = row.find('td:eq(3)').text();
        var presentacion = row.find('td:eq(2)').text();
        var precioReal = parseFloat(row.find('input[name="precio_compra"]').val()) || 0;
        var cantidad_presentacion = parseInt(row.find('input[name="pcantidad_presentacion"]').val()) || 0;
        var cantidad_unidad = parseInt(row.find('input[name="pcantidad_unidad"]').val()) || 0;
        var cantidad = row.find('input[name="paux"]').val();

        if (cantidad_presentacion <= 0) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "La cantidad de presentación debe ser mayor a 0",
            });
            return;
        }

        subtotal[cont] = precioReal * cantidad_presentacion;
        total += subtotal[cont];

        var fila = '<tr class="selected" id="fila' + cont + '">';
        fila +=
            '<input type="hidden" autocomplete="off" class="input" name="producto_id[]" value="' +
            id + '" >';

        fila += '<td>' + codigo + '</td>';
        fila += '<td>' + nombre + '</td>';
        fila += '<td>' + 'Costo por ' + presentacion +
            '<input type="number" name="precios_compra[]" class="form-control" value="' +
            precioReal + '">' +
            '</td>';
        fila += '<td> Cantidad por ' + presentacion +
            '<input type="number" name="cantidad_presentacion[]"  class="form-control cantidad-presentacion"  value="' +
            cantidad_presentacion +
            '" data-index="' + cont + '"></td>';
        fila += '<td> Cantidad por ' + unidad_medida +
            '<input type="number" name="cantidad_unidad[]"  class="form-control cantidad-unidad"  value="' +
            cantidad_unidad +
            '" data-index="' + cont + '"></td>';
        fila += '<td style="width:100px"> Bs.' + subtotal[cont].toFixed(0) + '</td>';
        fila += '<input type="hidden" class="form-control cantidad-presentacion" name="cantidad[]" value="' + cantidad + '">';

        fila +=
            '<td> <button type="button" class="btn btn-danger btn-sm" style="width:40px;height:30px;" title="Eliminar" onclick="eliminar(' +
            cont + ');"><i class="fas fa-trash"></i></td>';
        fila += '</tr>';

        $("#tablaDetalle").append(fila);

        limpiar();
        actualizarTotales();

        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Producto Agregado',
            showConfirmButton: false,
            timer: 700,
        });

        cont++;
    });

    $("body").on("input", "input[name^='precios_compra']", function() {
        var index = $(this).closest("tr").index();
        var precioReal = parseFloat($(this).val()) || 0;
        var cantidad_presentacion = parseInt($('input[name="cantidad_presentacion[]"]').eq(index).val()) || 0;

        subtotal[index] = precioReal * cantidad_presentacion;

        $('td:eq(5)', '#fila' + index).text('Bs. ' + subtotal[index].toFixed(0));

        actualizarTotales();
    });

    $("body").on("input", ".cantidad-presentacion", function() {
    var index = $(this).data('index');
    var cantidad_presentacion = parseInt($(this).val()) || 0;
    var precioReal = parseFloat($('input[name="precios_compra[]"]').eq(index).val()) || 0;
    var cantidad = parseFloat($('input[name="cantidad[]"]').eq(index).val()) || 0; // Obtener el valor dinámico de cantidad

    var cantidad_unidad = cantidad_presentacion * cantidad;

    // Actualizar el valor en el campo correspondiente
    $('input[name="cantidad_unidad[]"]').eq(index).val(cantidad_unidad);

    // Calcular subtotal
    subtotal[index] = precioReal * cantidad_presentacion;

    // Actualizar visualización del subtotal
    $('td:eq(5)', '#fila' + index).text('Bs. ' + subtotal[index].toFixed(0));

    // Actualizar totales
    actualizarTotales();
});

$("body").on("input", ".cantidad-unidad", function() {
    var index = $(this).data('index');
    var cantidad_unidad = parseInt($(this).val()) || 0;
    var precioReal = parseFloat($('input[name="precios_compra[]"]').eq(index).val()) || 0;
    var cantidad = parseFloat($('input[name="cantidad[]"]').eq(index).val()) || 0; // Obtener el valor dinámico de cantidad

    var cantidad_presentacion = cantidad_unidad / cantidad;

    // Actualizar el valor en el campo correspondiente
    $('input[name="cantidad_presentacion[]"]').eq(index).val(cantidad_presentacion);

    // Calcular subtotal
    subtotal[index] = precioReal * cantidad_presentacion;

    // Actualizar visualización del subtotal
    $('td:eq(5)', '#fila' + index).text('Bs. ' + subtotal[index].toFixed(0));

    // Actualizar totales
    actualizarTotales();
});

    function eliminar(index) {
        total -= subtotal[index];
        subtotal[index] = 0;

        $("#fila" + index).remove();

        actualizarTotales();
    }

    function actualizarTotales() {
        total = subtotal.reduce(function(a, b) {
            return a + b;
        }, 0);

        $("#total").html("Bs. " + total.toFixed(0));
        $("#totalc").val(total);

        if (total > 0) {
            $("#guardar").show();
        } else {
            $("#guardar").hide();
        }
    }

    function limpiar() {
        var inputs = document.querySelectorAll(
            '#tablaProductos input[type="text"], #tablaProductos input[type="number"], #tablaProductos input[type="date"]'
        );

        // Iterar sobre cada elemento y restablecer su valor a cadena vacía
        inputs.forEach(function(input) {
            if (input.id !== "pprecio_real") { // Ignorar el campo "Precio Real"
                input.value = '';
            }
        });
    }
</script>
