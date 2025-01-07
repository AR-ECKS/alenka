@push('custom_css')
    @livewireStyles
@endpush

@push('custom_js')
    @livewireScripts

    <script>
        document.addEventListener('livewire:load', function() {
            //console.log('LOAD SUCCESSFULLY');
            Livewire.on('mensaje',(sms) =>{
                console.log(sms);
            });

            Livewire.on('success',(sms) =>{
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Operación Realizada con éxito",
                    text: sms,
                    showConfirmButton: true,
                });
                //console.log(sms);
            });

            Livewire.on('error',(sms) =>{
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "ocurrio un error",
                    text: sms,
                    showConfirmButton: true,
                });
                //console.log(sms);
            })

            Livewire.on('alerta', (name_func, id) => {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: 'Al eliminar este registro, no podrás volver a utilizarlo. Sin embargo, la información previa relacionada con este registro permanecerá visible.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if(result.isConfirmed){
                        Livewire.emit(name_func, id);
                    }
                });
            });
        });
    </script>
@endpush