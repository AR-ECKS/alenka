@extends('layouts.app')
@section('content')
    @if (session()->has('correcto'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Operación Realizada con éxito",
                    text: '{{ session('correcto') }}',
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
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    //timer: 1500
                });
            });
        </script>
    @endif

    {{-- INIT INSERT CUSTOM --}}
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2 ">
                        {{-- <h3>SALIDAS DE MOLINO</h3> --}}
                    </div>
                    <div class="card-body p-3">
                        <!-- LIVEWIRE -->
                        @livewire('salida-molino-index')
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{--  END INSERT CUSTOM --}}

    @include('livewire.utils-livewire')
@endsection
