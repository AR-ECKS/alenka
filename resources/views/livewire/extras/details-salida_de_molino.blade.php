@if($carac_salida_de_molino)
    <div class="col-md-12">

        <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-detalle-salida-molino-tab" data-toggle="pill" data-target="#pills-detalle-salida-molino" type="button" role="tab" aria-controls="pills-detalle-salida-molino" aria-selected="false">Detalle Salida de molino - Preparación</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-salida-de-molino-tab" data-toggle="pill" data-target="#pills-salida-de-molino" type="button" role="tab" aria-controls="pills-salida-de-molino" aria-selected="true">Detalles</button>
            </li>
            @if($carac_salida_de_molino->producto_envasado)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-producto-envasado-tab" data-toggle="pill" data-target="#pills-producto-envasado" type="button" role="tab" aria-controls="pills-producto-envasado" aria-selected="false">Producto envasado</button>
                </li>
            @endif
        </ul>
        <div class="tab-content">

            <div class="tab-pane fade" id="pills-detalle-salida-molino" role="tabpanel" aria-labelledby="pills-detalle-salida-molino-tab">
                <div class="row">
                    {{-- init --}}
                    @if(count($carac_salida_de_molino->detalle_salida_molinos) > 0)
                        <div class="col-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                @php $first = true; @endphp
                                @foreach($carac_salida_de_molino->detalle_salida_molinos as $det_sal_molino)
                                    @php $det_sal_molino->cod_pill = "v-pills-sal-molino-". $det_sal_molino->id; @endphp
                                    <button class="nav-link {{$first? 'active': ''}}" id="{{ $det_sal_molino->cod_pill }}-tab" data-toggle="pill" data-target="#{{ $det_sal_molino->cod_pill }}" type="button" role="tab" aria-controls="{{ $det_sal_molino->cod_pill }}" aria-selected="true">Balde @if($det_sal_molino->detalle_proceso_preparacion) {{ $det_sal_molino->detalle_proceso_preparacion->nro_balde }} @endif </button>
                                    @php $first = false; @endphp
                                @endforeach
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                @php $first = true; @endphp
                                @foreach($carac_salida_de_molino->detalle_salida_molinos as $det_sal_molino)
                                    <div class="tab-pane fade {{$first? 'show active': ''}}" id="{{ $det_sal_molino->cod_pill }}" role="tabpanel" aria-labelledby="{{ $det_sal_molino->cod_pill }}-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="text-center">Detalles de Salida de Molino</h5>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text text-secondary">
                                                            <i class="fa fa-calendar-check"></i> <span class="ms-1">Modificado</span>
                                                        </div>
                                                    </div>
                                                    <span class="form-control text-secondary"> {{ $det_sal_molino->updated_at }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text text-secondary">
                                                            <i class="fa fa-user"></i> <span class="ms-1">Por</span>
                                                        </div>
                                                    </div>
                                                    <span class="form-control text-secondary"> {{ $det_sal_molino->user->username }}</span>
                                                </div>
                                            </div>
                                            <hr>
                                            @if($det_sal_molino->detalle_proceso_preparacion)
                                                <div class="col-md-12 row">
                                                    @include('livewire.extras.data-detalle-proceso-preparacion', [
                                                        'data_detalle_proceso_preparacion' => $det_sal_molino->detalle_proceso_preparacion,
                                                    ])
                                                </div>
                                                
                                                <hr>

                                                @if($det_sal_molino->detalle_proceso_preparacion->proceso_preparacion)
                                                    @include('livewire.extras.data-proceso-preparacion', [
                                                        'data_proceso_preparacion' => $det_sal_molino->detalle_proceso_preparacion->proceso_preparacion,
                                                    ])

                                                    <hr>
                                                    @if($det_sal_molino->detalle_proceso_preparacion->proceso_preparacion->despacho)
                                                        @include('livewire.extras.data-despacho', [
                                                            'data_despacho' => $det_sal_molino->detalle_proceso_preparacion->proceso_preparacion->despacho,
                                                        ])
                                                    @endif

                                                    <hr>

                                                    @if($det_sal_molino->detalle_proceso_preparacion->proceso_preparacion->registro_para_picar)
                                                        @include('livewire.extras.data-registro-para-picar', [
                                                            'data_registro_para_picar' => $det_sal_molino->detalle_proceso_preparacion->proceso_preparacion->registro_para_picar,
                                                        ])
                                                    @endif
                                                @endif
                                            @else
                                                <div class="col-md-12 text-danger">Aun no está asignado</div>
                                            @endif
                                        </div>
                                    </div>
                                    @php $first = false; @endphp
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p>No hay datos</p>
                    @endif
                    {{-- end --}}
                </div>
            </div>
            
            <div class="tab-pane fade show active" id="pills-salida-de-molino" role="tabpanel" aria-labelledby="pills-salida-de-molino-tab">
                @include('livewire.extras.data-salida-de-molino', [
                    'data_salida_de_molino' => $carac_salida_de_molino,
                    'data_listar' => true
                ])
            </div>

            @if($carac_salida_de_molino->producto_envasado)
                <div class="tab-pane fade" id="pills-producto-envasado" role="tabpanel" aria-labelledby="pills-producto-envasado-tab">
                    @include('livewire.extras.data-producto-envasado', [
                        'data_producto_envasado' => $carac_salida_de_molino->producto_envasado,
                        'data_listar' => true
                    ])
                </div>
            @endif
        </div>
        <hr>

    </div>
@endif