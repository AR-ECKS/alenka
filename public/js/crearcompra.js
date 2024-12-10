$(document).ready(function () {
    $("#bt_add").click(function () {
        agregar();
        evaluar2();
    });

    //Declarar variables reutilizables
});

var cont = 0;
total = 0;
subtotal = [];

function mostrarValores() {
    datosProducto = document.getElementById("pproducto_id").value.split("_");
    $("#pmarca").val(datosProducto[1].toString());
    $("#pcategoria").val(datosProducto[2].toString());
    $("#pprecioreal").val(datosProducto[3].toString());
    $("#pprecioventa").val(datosProducto[4].toString());
}

function agregar() {
    // Obtener valores de los campos de entrada
    var idproducto = $("#producto_id").val().split("_")[0].toString();
    var producto = $("#producto_id option:selected").text();
    var cantidad = $("#pcantidad").val();
    var descuento = $("#pdescuento").val();
    var precioreal = $("#pprecio_real").val();
    var precioventa = $("#pprecio_venta").val();
    var lote = $("#pnrolote").val();
    var fechav = $("#pfechav").val();

    // Validar que todos los campos obligatorios estén completos
    if (
        idproducto !== "" &&
        fechav !== "" &&
        cantidad !== "" &&
        cantidad > 0 &&
        precioreal !== "" &&
        lote !== ""
    ) {
        // Verificar que el descuento no sea mayor al subtotal
        if (descuento > precioreal * cantidad) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "El descuento no puede ser mayor al subtotal!",
            });
            return;
        }

        // Calcular subtotal
        // Calcular subtotal
        subtotal[cont] = precioreal * cantidad - descuento;
        total += subtotal[cont];

        // Construir la fila de la tabla con los datos ingresados
        var fila = '<tr class="selected" id="fila' + cont + '">';

        fila +=
            '<td><input type="hidden" name="producto_id[]" value="' +
            idproducto +
            '">' +
            producto +
            "</input></td>";

        fila +=
            '<td><input type="text" name="nrolote[]" class="input" style="width:150px;height:30px; " value="' +
            lote +
            '"></td>';

        fila +=
            '<td><input type="date" name="fechav[]" class="input" style="width:120px;height:30px;" value="' +
            fechav +
            '"></td>';

        fila +=
            '<td><input type="text" name="cantidad[]"  class="input" style="width:60px;height:30px;" value="' +
            cantidad +
            '" onblur="actualizarSubtotal(' +
            cont +
            ')" oninput="actualizarSubtotal(' +
            cont +
            ')"></td>';

        fila +=
            '<td><input type="text" name="precioreal[]" class="input" style="width:90px;height:30px;" value="' +
            precioreal +
            '" onblur="actualizarSubtotal(' +
            cont +
            ')" oninput="actualizarSubtotal(' +
            cont +
            ')"></td>';

        fila +=
            '<td><input type="text"  name="precioventa[]" class="input" style="width:90px;height:30px;" value="' +
            precioventa +
            '"></td>';

        fila +=
            '<td><input type="text" name="descuento[]" class="input" style="width:60px;height:30px;" value="' +
            descuento +
            '" onblur="actualizarSubtotal(' +
            cont +
            ')" oninput="actualizarSubtotal(' +
            cont +
            ')"></td>';

        fila += "<td> Bs." + subtotal[cont].toFixed(2) + "</td>";

        fila +=
            ' <td> <button type="button" class="btn btn-danger btn-sm" style="width:60px;height:30px;" title="Eliminar" id="' +
            cont +
            '" onclick="eliminar(' +
            cont +
            ');"><i class="fa-solid fa-trash"></i></td>';

        fila += "</tr>";

        cont++;
        limpiar();
        $("#total").html("Bs. " + total);
        $("#totalc").val(total);
        $("#subtotal").html("Bs. " + subtotal[cont - 1].toFixed(2));
        evaluar();
        $("#detalles").append(fila);
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Error al ingresar detalle de la compra, verifique que ingresó correctamente los datos!",
        });
    }
}

window.onload = function () {
    var fecha = new Date(); //Fecha actual
    var mes = fecha.getMonth() + 1; //obteniendo mes
    var dia = fecha.getDate(); //obteniendo dia
    var ano = fecha.getFullYear(); //obteniendo año
    if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
    if (mes < 10) mes = "0" + mes; //agrega cero si el menor de 10
    document.getElementById("fechaActual").value = ano + "-" + mes + "-" + dia;
};

var myDate = $(".fechaInspeccion");
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1;
var yyyy = today.getFullYear();
if (dd < 10) dd = "0" + dd;

if (mm < 10) mm = "0" + mm;

today = yyyy + "-" + mm + "-" + dd;
myDate.attr("min", today);

function myFunction() {
    var date = myDate.val();
    if (Date.parse(date)) {
        if (date > today) {
            alert("La fecha no puede ser menor a la actual");
            myDate.val("");
        }
    }
}
