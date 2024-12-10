$(document).ready(function () {
    $("#bt_add").click(function () {
        agregar();
    });
});



$(document).ready(function () {
    $(".floatNumberField").change(function() {
        $(this).val(parseFloat($(this).val()).toFixed(2));
    });
    $(".select2").select2({
        width: "100%",

        language: {
            noResults: function () {
                return '<button id="mostrar" class="btn btn-success  btn-sm" onclick="noResultsButtonClicked()">No existe, Cree el cliente</a>';
            },
        },
        escapeMarkup: function (markup) {
            return markup;
        },
    });

    $("#cliente_id").on("change", onselectCliente);
});


$("#form").hide();
// $(".pj").hide();

$("select#cliente_id").change(function () {
    $("#form").show();
    $("#mensaje").hide();
});

var cont = 0;
total = 0;
subtotal = [];
$("#guardar").hide();
$("#pproducto_id").change(mostrarValores);

function mostrarValores() {
    datosProducto = document.getElementById("pproducto_id").value.split("_");
    $("#precioventa").val(datosProducto[5].toString());
    $("#pdescuento").val(datosProducto[6].toString());
}

function agregar() {

    datosProducto=document.getElementById('pproducto_id').value.split('_');

   var idproducto = datosProducto[0].toString();
    var producto = $("#pproducto_id option:selected").text();
    var cantidad = $("#pcantidad").val();
    var precioventa = $("#precioventa").val();
  var  descuento = $("#pdescuento").val();
    if (
        idproducto != "" &&
        cantidad != "" &&
        cantidad > 0 &&
        precioventa != ""
    ) {

        subtotal[cont] = (precioventa * cantidad) - descuento;
        total = (total + subtotal[cont]);

            var fila ='<tr class="selected" id="fila' +cont +'">';
            fila=fila+'<td><input type="hidden" name="producto_id[]" value="' +idproducto+'">' +producto+'</input></td>';
            fila=fila+'<td><input  type="text" name="cantidad[]"  style="width:80px;height:30px; border: 0;outline: none;"  value="' +cantidad +'"></td>';
            fila=fila+'<td><input type="text" name="precioventa[]"  style="width:80px;height:30px; border: 0;outline: none;"  value="' +precioventa+'"></td>';
            fila =
            fila +
            '<td><input  type="text" name="descuento[]" style="width:80px;height:30px; border: 0;outline: none;" value="' +
            descuento +
            '"></td>';

             fila =
            fila +
            "<td> Bs." +
            subtotal[cont].toFixed(2) +
            "</td>";
            fila =
            fila +
            '<td><button type="button" class="btn btn-danger btn-eliminar btn-sm float-right" title="Eliminar" id="' +
            cont +
            '" onclick="eliminar(' +
            cont +
            ');"><i class="material-icons">delete</i></td>';
        fila = fila + "</tr>";
        cont++;
        console.log(fila)
            limpiar();
            $("#total").html("Bs. " + total);
            $("#totalc").val(total);
            evaluar();
            $("#detalles").append(fila);



    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Error al ingresar detalle en la cotizacion, verifique que ingreso correctamente los datos!",
        });
    }
}

function limpiar() {
    $("#pcantidad").val("");
    $("#pcategoria").val("");
    $("#precioventa").val("");
    $("#pproducto_id").val("");
}



 function evaluar() {
    if (total > 0) {
        $("#guardar").show();
    } else {
        $("#guardar").hide();
    }
}

function eliminar(index) {
    total = total - subtotal[index];
    $("#total").html("Bs/. " + total);
    $("#total").val(total);
    $("#fila" + index).remove();
    evaluar();
}



window.onload = function() {
    var fecha = new Date(); //Fecha actual
    var mes = fecha.getMonth() + 1; //obteniendo mes
    var dia = fecha.getDate(); //obteniendo dia
    var ano = fecha.getFullYear(); //obteniendo año
    if (dia < 10)
        dia = '0' + dia; //agrega cero si el menor de 10
    if (mes < 10)
        mes = '0' + mes //agrega cero si el menor de 10
    document.getElementById('fechaActual').value = ano + "-" + mes + "-" + dia;
}


