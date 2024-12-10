$(document).ready(function () {
    $("#id-s").DataTable({
        // AQUI VA EL SELECT DE MOSTRAR REGISTROS
        lengthMenu: [10, 25, 50],
        order: [
            [0, "desc"],
            [1, "desc"],
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
    });

    // crea un nuevo objeto `Date`
    var today = new Date();

    // obtener la fecha de hoy en formato `MM/DD/YYYY`
    var now = today.toLocaleDateString("en-GB");

    var oTable = $("#id-t").dataTable({
        dom: "Bfrtip",
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
        },
        buttons: [
            {
                title: "",
                extend: "excel",
                text: "IMPRIMIR PDF",
                messageTop: "REPORTE DE VENTAS DIARIO, FECHA:  " + now,
                extend: "print",

                customize: function (win) {
                    $(win.document.body)
                        .css("font-size", "20pt")
                        .prepend(
                            '<img src="https://images2.imgbox.com/d0/1f/Xldeuj0n_o.jpg" style="width:330px;height:100px;margin-left:350px" />'
                        );

                    $(win.document.body)
                        .find("table")
                        .addClass("compact")
                        .css("font-size", "inherit");
                },
            },
        ],
    });

    $("select#user").change(function () {
        oTable.fnFilter(this.value, 5);
    });
    $("select#sucursal").change(function () {
        oTable.fnFilter(this.value, 0);
    });

    // crea un nuevo objeto `Date`
    var today = new Date(str);

    var moment = require("moment");

    // obtener el nombre del mes, día del mes, año, hora
    var now2 = moment().format("DD/MM/YYYY HH:mm:ss A");

    // obtener la fecha de hoy en formato `MM/DD/YYYY`
    var now = today.toLocaleString();

    $("#id-a").DataTable({
        // AQUI VA EL SELECT DE MOSTRAR REGISTROS
        lengthMenu: [10, 25, 50],
        order: [[1, "desc"]],
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
    });
});

$(document).ready(function () {
    $(".select3").select2({
        // dropdownParent: $('#modal), // if select in modal
    });
    $(".select2").select2({
        tags: true,

        // dropdownParent: $('#modal), // if select in modal
    });
});

$(document).ready(function () {
    $("#reportes").DataTable({
        lengthMenu: [10, 25, 50],
        order: [
            [0, "desc"],
            [1, "desc"],
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
        dom: "Bfrtip",
        buttons: {
            dom: {
                button: {
                    className: "btn",
                },
            },
            buttons: [
                {
                    title: "Reporte de ventas diario",
                    messageTop: " FECHA:  " + now,
                    extend: "print",
                    text: "Exportar a PDF",
                    className: "btn btn-outline-warning mr-2",
                    customize: function (win) {
                        $(win.document.body)
                            .css("font-size", "20pt")
                            .prepend(
                                '<img src="https://images2.imgbox.com/d0/1f/Xldeuj0n_o.jpg" style="width:300px;height:150px;margin-left:380px" />'
                            );

                        $(win.document.body)
                            .find("table")
                            .addClass("compact")
                            .css("font-size", "inherit");
                    },
                },

                {
                    //definimos estilos del boton de excel

                    extend: "excel",
                    title: "CERMAD_PHARMA-reporte_diario_" + now,
                    text: "Exportar a Excel",
                    className: "btn btn-outline-success",

                    excelStyles: {
                        template: "header_blue", // Apply the 'header_blue' template part (white font on a blue background in the header/footer)
                        template: "green_medium",
                    },

                    // 2 - estilos a una fila

                    excelStyles: {
                        // Add an excelStyles definition
                        cells: "2", // adonde se aplicaran los estilos (fila 2)
                        style: {
                            // The style block
                            font: {
                                // Style the font
                                name: "Arial", // Font name
                                size: "14", // Font size
                                color: "FFFFFF", // Font Color
                                b: true, // negrita SI
                            },
                            fill: {
                                // Estilo de relleno (background)
                                pattern: {
                                    // tipo de rellero (pattern or gradient)
                                    color: "ff7961", // color de fondo de la fila
                                },
                            },
                        },
                    },

                    // 3 - uso de condiciones
                    /*
                 excelStyles: {
                    cells: 'sD', //(s) de Smart - Referencia de celda inteligente, todas las filas de datos en la columna D (en este caso Edad)
                    condition: {                    // Add the style conditionally
                        type: 'cellIs',             // Using the cellIs type
                        operator: 'between',        // Operator a usar "Entre"
                        formula: [35,50],    // arreglo de valores requeridos para el operador 'entre' (edades entre 35 y 50 años son pintadas)
                    },
                    style: {
                        font: {
                            b: true,                // Make the font bold
                        },
                        fill: {                     // Style the cell fill (background)
                            pattern: {              // Type of fill (pattern or gradient)
                                bgColor: 'e8f401',  // Fill color (be aware of the Excel gotcha that conditonal fills
                            }
                        }
                    }
                }
                */

                    // 4 - Reemplazar o insertar celdas, columnas y filas

                    // 4.1 - Añadir columnas
                    /*
                insertCells: [                  // Agregar una opción de configuración insertCells
                    {
                        cells: 'sCh',               // la "s" de Smart, "C" es la columna y "h" se refiere al header,
                        content: 'Nueva columna C',    // nombre del encabezado de la columna que insertamos
                        pushCol: true,              // pushCol hace que se inserte la columna
                    },
                    {
                        cells: 'sC1:C-0',           // Target the data
                        content: 'C',                // Add empty content
                        pushCol: true               // empuja las columnas a la derecha para insertar el nuevo contenido
                    }
               ],
                excelStyles: {
                    template: 'cyan_medium',    // Add a template to the result
                }
                */

                    // 4.2 - Insertar filas
                    /*
                insertCells: [                  // Agregar una opción de configuración insertCells
                    {
                        cells: 's5:6',              // Inserta los datos en las filas 5 y 6 contando desde el encabezado
                        content: 'Celdas nuevas',   // contenido a insertar
                        pushRow: true               // empuja las filas hacia abajo para insertar el contenido
                    },
                    {
                        cells: 'B3',                // Celda B3
                        content: 'Esta es la celda B3', // Simplemente sobreescribimos su contenido
                    }
               ],
                excelStyles: {
                    template: 'cyan_medium',    // Add a template to the result
                }
                */

                    // ejemplo para IMPRIMIR

                    pageStyle: {
                        sheetPr: {
                            pageSetUpPr: {
                                fitToPage: 1, // Fit the printing to the page
                            },
                        },
                        printOptions: {
                            horizontalCentered: true,
                            verticalCentered: true,
                        },
                        pageSetup: {
                            orientation: "landscape", // Orientacion
                            paperSize: "9", // Tamaño del papel (1 = Legal, 9 = A4)
                            fitToWidth: "1", // Ajustar al ancho de la página
                            fitToHeight: "0", // Ajustar al alto de la página
                        },
                        pageMargins: {
                            left: "0.2",
                            right: "0.2",
                            top: "0.4",
                            bottom: "0.4",
                            header: "0",
                            footer: "0",
                        },
                        repeatHeading: true, // Repeat the heading row at the top of each page
                        repeatCol: "A:A", // Repeat column A (for pages wider than a single printed page)
                    },
                    excelStyles: {
                        template: "blue_gray_medium", // Add a template style as well if you like
                    },
                },
            ],
        },
    });
});
