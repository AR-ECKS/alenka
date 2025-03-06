@extends('layouts.app')
@section('content')
    {{-- INIT INSERT CUSTOM --}}
    <div class="container-fluid py-4 ">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2 ">
                        <h3 class="text-center">INVENTARIO DE PRODUCTOS ENVASADOS</h3>
                    </div>
                    <div class="card-body p-3">
                        <!-- LIVEWIRE -->
                        @livewire('inventario-index')
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{--  END INSERT CUSTOM --}}
</div>
</div>
@endsection

@include('livewire.utils-livewire')