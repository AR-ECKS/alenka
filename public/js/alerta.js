alert("asdgssdfsgG");
$('.delete').submit(function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Está seguro?',
        text: "Se eliminará el registro!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    })
})
