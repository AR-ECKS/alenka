$(document).ready(function () {
    $("#bt_add").click(function () {
        agregar();
        evaluar2();
    });
});

$(document).ready(function () {
    $(".floatNumberField").change(function () {
        $(this).val(parseFloat($(this).val()).toFixed(2));
    });
    $(".select2").select2({
        width: "100%",

        language: {
            noResults: function () {
                return '<button id="mostrar" class="btn btn-success  btn-sm" onclick="noResultsButtonClicked()">No existe porfavor cree el proveedor</a>';
            },
        },
        escapeMarkup: function (markup) {
            return markup;
        },
    });

    $("#cliente_id").on("change", onselectCliente);
});


window.onload = function () {
    var fecha = new Date(); //Fecha actual
    var mes = fecha.getMonth() + 1; //obteniendo mes
    var dia = fecha.getDate(); //obteniendo dia
    var ano = fecha.getFullYear(); //obteniendo año
    if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
    if (mes < 10) mes = "0" + mes; //agrega cero si el menor de 10
    document.getElementById("fechaActual").value = ano + "-" + mes + "-" + dia;
};