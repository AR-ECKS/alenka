@extends('layouts.app')
@section('content')
    @if (session()->has('correcto'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Operación Realizada con éxito",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "ocurrio un error",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>
    @endif<!-- right_sidebar.blade.php -->


    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2 ">

                    </div>
                    <div class="card-body p-3">
                        <div class="float-right mt-3">
                            @can('crear_materia_prima')
                                <a type="button" class="btn btn-primary text-white" href="{{ route('materia_prima.create') }}">
                                    <i class="fas fa-database"></i> Nueva Materia prima
                                </a>
                            @endcan
                        </div>
                        <br><br><br>
                        <div class="tab-content">
                            <div class="table-responsive-xl">



                                <table class="table table-sm text-sm table-striped" id="mi-tabla">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            <th>Proveedor</th>
                                            <th>stock</th>
                                            <th>stock </th>
                                            <th>Estado</th>

                                            <th class="text-right">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($materia_prima as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->codigo }}</td>
                                                <td>{{ $item->nombre }}</td>
                                                <td>{{ $item->proveedor->razon_social }}</td>
                                                <td><b>{{ $item->stock_presentacion }} </b>{{ $item->presentacion }}s</td>

                                                <td><b>{{ $item->stock_unidad }} </b>{{ $item->unidad_medida }}</td>
                                                <td>
                                                    @if ($item->estado == 1)
                                                        <span class="badge bg-warning">Activo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactivo</span>
                                                    @endif
                                                <td class="td-actions text-right">
                                                    @if ($item->estado == 1)
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-info btn-sm dropdown-toggle"
                                                                style="background: #007bff" item="button"
                                                                id="dropdownMenuLink" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-cog"></i> Acciones
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                @can('ver_materia_prima')
                                                                    <a href="{{ route('materia_prima.show', $item->id) }}"
                                                                        title="View Materia_prima" class="dropdown-item"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Ver detalles">
                                                                        <i class="far fa-eye"> </i> Ver detalles
                                                                    </a>
                                                                @endcan
                                                                @can('editar_materia_prima')
                                                                    <a href="{{ route('materia_prima.edit', $item->id) }}"
                                                                        title="Edit Materia_prima" class="dropdown-item"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Editar">
                                                                        <i class="fas fa-edit"> </i> Editar
                                                                    </a>
                                                                @endcan


                                                                @can('eliminar_materia_prima')
                                                                    <form
                                                                        action="{{ route('materia_prima.delete', $item->id) }}"
                                                                        method="POST" class="eliminate"
                                                                        style="display: inline-block;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item esd delete-button"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Eliminar">
                                                                            <i class="fas fa-trash"></i> Eliminar
                                                                        </button>
                                                                    </form>
                                                                @endcan

                                                            </div>
                                                        @else
                                                            @can('restaurar_materia_prima')
                                                                <a href="{{ route('materia_prima.reingresar', $item->id) }}"
                                                                    class="btn-sm btn-dark" data-toggle="tooltip"
                                                                    data-placement="top" title="Restaurar">
                                                                    <i class="fas fa-undo"></i>
                                                                </a>
                                                            @endcan
                                                    @endif
                            </div>
                            </td>
                            </tr>
                            @endforeach
                            </tbody>
                            </table>



                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

    <script>
        var nombre1 = "ALENKA S.R.L.";
        var color1 = "#2b686e";
        $(document).on("click", ".delete-button", function(e) {
            e.preventDefault();

            // Obtener el formulario de eliminación
            var form = $(this).closest("form");

            // Mostrar el cuadro de diálogo de confirmación
            Swal.fire({
                title: "¿Está seguro?",
                text: "Anulara esta venta, se actualizaran los datos en inventario. No podra revertir esta accion",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario hace clic en "Sí, eliminar", enviar el formulario de eliminación
                    form.submit();

                    // Mostrar un mensaje de eliminación exitosa después de que se elimine el registro
                    form.on("submit", function() {

                        Swal.fire("Operacion realizada correctamente!", "", "success");
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {

                    // Si el usuario hace clic en "Cancelar" o hace clic fuera del cuadro de diálogo, mostrar un mensaje de cancelación
                    Swal.fire("Se cancelo la operacion", "", "error");
                }
            });
        });

        $(document).ready(function() {

            var searchValue = ""; // variable donde se guardará el valor de búsqueda

            var today = new Date();
            var nowf = today.toLocaleDateString("en-GB");
            // obtener la fecha de hoy en formato `MM/DD/YYYY`
            var now = today.toLocaleDateString("en-GB");

            var table = $("#mi-tabla").DataTable({
                lengthMenu: [10, 25, 50],
                rowCallback: function(row, data, index) {
                    // Agrega la columna numerada al principio de la fila
                    $('td:eq(0)', row).html(index + 1);
                },

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
                        first: "Primero",
                        last: "Ultimo",
                        next: "Próximo",
                        previous: "Anterior",
                    },
                    aria: {
                        sortAscending: ": Activar orden de columna ascendente",
                        sortDescending: ": Activar orden de columna desendente",
                    },
                },
                dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center align-middle'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12 text-center'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                initComplete: function() {
                    $(".col-sm-4.text-center").css({
                        display: "flex",
                        justifyContent: "center",
                        alignItems: "center",
                    });
                },

                buttons: {
                    dom: {
                        button: {
                            className: "btn  mx-auto ",
                        },
                    },
                    buttons: [{
                            text: '<button class="btn btn-danger mx-auto " style="margin-left:800px"><i class="far fa-file-pdf"></i></button>',

                            extend: "pdfHtml5",

                            // className: 'btn-success',
                            download: "open",
                            filename: "REPORTE-INVENTARIO_pdf",
                            orientation: 'portrait', //portrait
                            pageSize: "A4", //A3 , A5 , A6 , legal , letter
                            exportOptions: {
                                columns: ':not(:last-child):not(:nth-last-child(2))' // Excluir las dos últimas columnas
                            },
                            customize: function(doc) {
                                doc.styles.tableHeader.fillColor =
                                color1; // set background color to blue
                                doc.styles.tableHeader.color = "#fff"; // set text color to white
                                doc.content[1].table.widths = [
                                    "4%",
                                    "15%",
                                    "40%",
                                    "35%",
                                    "17%",
                                    "17%",
                                    "12%",



                                ];
                                doc.content[1].margin = [0, 0, 100, 0]; //left, top, right, bottom
                                doc.content.splice(0, 1);

                                var now = new Date();
                                var jsDate =
                                    now.getDate() +
                                    "-" +
                                    (now.getMonth() + 1) +
                                    "-" +
                                    now.getFullYear();

                                var ahora = new Date();
                                var opcionesFecha = {
                                    weekday: "long",
                                    year: "numeric",
                                    month: "long",
                                    day: "numeric",
                                };
                                var opcionesHora = {
                                    hour: "numeric",
                                    minute: "numeric",
                                    second: "numeric",
                                };
                                var fecha = ahora.toLocaleDateString(
                                    "es-ES",
                                    opcionesFecha
                                );
                                var hora = ahora.toLocaleTimeString(
                                    "es-ES",
                                    opcionesHora
                                );
                                var texto =
                                    "Fecha de reporte: " +
                                    fecha +
                                    ". Hora de reporte: " +
                                    hora;

                                doc.pageMargins = [20, 60, 20, 30];

                                doc.defaultStyle.fontSize = 8;

                                doc.styles.tableHeader.fontSize = 8;

                                doc["header"] = function() {
                                    return {
                                        margin: [20, 20, 20, 20],
                                        fontSize: 14,
                                        columns: [{
                                                width: "auto",
                                                text: [{
                                                        text: "INVENTARIO MATERIA PRIMA " +
                                                            nombre1 + "\n",
                                                        bold: true,
                                                    },
                                                    {
                                                        text: texto,
                                                        fontSize: 10,
                                                        color: "#555555",
                                                    },
                                                    searchValue // comprueba si searchValue existe y no es nulo ni vacío
                                                    ?
                                                    {
                                                        text: "\nFiltro: " +
                                                            searchValue,
                                                        fontSize: 8,
                                                        color: "#000000",
                                                    } :
                                                    null, // si searchValue es nulo o vacío, no se muestra el texto de filtro
                                                ].filter(
                                                Boolean), // eliminamos los elementos nulos del arreglo resultante
                                            },

                                        ],
                                    };
                                };

                                doc["footer"] = function(currentPage, pageCount) {
                                    return {
                                        text: [{
                                            text: "Página " +
                                                currentPage.toString() +
                                                " de " +
                                                pageCount,
                                            alignment: "center",
                                            margin: [0, 0, 20, 5],
                                            fontSize: 9,
                                        }, ],
                                    };
                                };

                                var objLayout = {};
                                objLayout["hLineWidth"] = function(i) {
                                    return 0.5;
                                };
                                objLayout["vLineWidth"] = function(i) {
                                    return 0.5;
                                };
                                objLayout["hLineColor"] = function(i) {
                                    return "#aaa";
                                };
                                objLayout["vLineColor"] = function(i) {
                                    return "#aaa";
                                };
                                objLayout["paddingLeft"] = function(i) {
                                    return 4;
                                };
                                objLayout["paddingRight"] = function(i) {
                                    return 4;
                                };
                                if (doc.content[0]) {
                                    doc.content[0].layout = objLayout;
                                }


                            },
                        },
                        {
    extend: "excel",
    title: "INVENTARIO MATERIA PRIMA ALENKA S.R.L. en fecha: " + nowf,
    text: '<button class="btn btn-success mx-auto my-excel-btn" style="margin-left:800px"><i class="fas fa-file-excel"></i></button>',
    filename: "INVENTARIO_MATERIA_PRIMA" + nowf,
    excelStyles: [
        {
            template: "blue_medium", // Apply the 'blue_medium' template
        },
        {
            cells: "sh", // Use Smart References (s) to target the header row (h)
            style: {
                font: {
                    size: 10, // Size 10
                    b: false, // Turn off the default bolding of the header row
                },
                fill: {
                    pattern: {
                        color: "000000", // Define the fill color
                    },
                },
            },
        },
    ],
    exportOptions: {
        columns: ':not(:last-child):not(:nth-last-child(2))' // Excluir las dos últimas columnas
    },
},

                    ],
                },
            });
            var totalElement = $("#total");

            function calcularSumaTotal() {
                var totales = table
                    .column(1, {
                        search: "applied",
                    })
                    .data();

                var suma = totales.reduce(function(a, b) {
                    return a + parseFloat(b.toString().replace(",", ""));
                }, 0);

                return suma.toLocaleString("es-ES", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });
            }

            // Actualiza el total después de dibujar la tabla
            table.on("draw.dt", function() {
                var sumaTotal = calcularSumaTotal();
                totalElement.text(sumaTotal);
                console.log(sumaTotal);
            });

            // Calcula y muestra el total inicial
            var sumaTotalInicial = calcularSumaTotal();
            totalElement.text(sumaTotalInicial);
            console.log(sumaTotalInicial);
            $("#mi-tabla_filter input").on("input", function() {
                searchValue = this.value
            .trim(); // actualizar la variable con el valor actual del campo de búsqueda
                console.log("Valor de búsqueda actual:",
                searchValue); // mostrar el valor actual en la consola
            });
        });
    </script>
@endsection
