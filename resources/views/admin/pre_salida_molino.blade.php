@push('custom_css')
    @livewireStyles
@endpush
@extends('layouts.app')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                @livewire('pre-salida-molino-index', ['id_proceso' => $id_proceso])
            </div>
        </div>
    </div>

@endsection

@push('custom_js')
        @livewireScripts

        <script>
            document.addEventListener('livewire:load', function() {
                console.log('LOAD SUCCESSFULLY');
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
            });
        </script>
    @endpush
