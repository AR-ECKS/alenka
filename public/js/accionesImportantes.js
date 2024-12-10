$('.sweetx').submit(function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Está seguro? No podra revertir esta accion',
        text: "Esta opcion es solo para productos que caducaron o tengan algun detalle que conlleva a esta eliminacion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancelar!'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
            Swal.fire('Lote Eliminado correctamente!', '', 'success')
        } else {
            Swal.fire('Se cancelo la eliminacion', '', 'error')
        }
    })
})
   // Agregar el evento click al botón de eliminar
   $(document).on('click', '.delete-button', function(e) {
    e.preventDefault();

    // Obtener el formulario de eliminación
    var form = $(this).closest('form');

    // Mostrar el cuadro de diálogo de confirmación
    Swal.fire({
        title: '¿Está seguro?',
        text: 'Al eliminar este registro, no podrás volver a utilizarlo. Sin embargo, la información previa relacionada con este registro permanecerá visible.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario hace clic en "Sí, eliminar", enviar el formulario de eliminación
            form.submit();

            // Mostrar un mensaje de eliminación exitosa después de que se elimine el registro
            form.on('submit', function() {
                Swal.fire('Operacion realizada correctamente!', '', 'success')
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Si el usuario hace clic en "Cancelar" o hace clic fuera del cuadro de diálogo, mostrar un mensaje de cancelación
            Swal.fire('Se cancelo la operacion', '', 'error')
        }
    })
});
  // Agregar el evento click al enlace de restauración
  $(document).on('click', '.restart', function(e) {
    e.preventDefault();

    // Obtener el enlace de restauración
    var link = $(this).attr('href');

    // Mostrar el cuadro de diálogo de confirmación
    Swal.fire({
        title: '¿Está seguro?',
        // text: '¡No podrás revertir esto!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, restaurar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario hace clic en "Sí, restaurar", navegar a la página de restauración
            window.location.href = link;

            // Mostrar un mensaje de restauración exitosa después de que se restaure el registro
            // Swal.fire('Operacion realizada correctamente!', '', 'success')
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Si el usuario hace clic en "Cancelar" o hace clic fuera del cuadro de diálogo, mostrar un mensaje de cancelación
            Swal.fire('Se cancelo la operacion', '', 'error')
        }
    })
});
var s = document.getElementById("myAudio");
var g = document.getElementById("good");
var p = document.getElementById("pregunta");
$(document).ready(function() {

    $.noConflict();
    var table = $('#table').DataTable({

        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    });
});
$(document).ready(function() {


    var table2 = $('#table2').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    });
});
