@if($carac_registro_para_picar)
    <div class="col-md-12">

        
        <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-detalle-para-picar-tab" data-toggle="pill" data-target="#pills-detalle-para-picar" type="button" role="tab" aria-controls="pills-detalle-para-picar" aria-selected="false">Detalles para picar</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-registros-para-picar-tab" data-toggle="pill" data-target="#pills-registros-para-picar" type="button" role="tab" aria-controls="pills-registros-para-picar" aria-selected="true">Detalles</button>
            </li>

            @if($carac_registro_para_picar->preparacion)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-proceso_preparacion-tab" data-toggle="pill" data-target="#pills-proceso_preparacion" type="button" role="tab" aria-controls="pills-proceso_preparacion" aria-selected="false">Proceso preparación</button>
                </li>
            @endif

        </ul>
        <div class="tab-content">

            <div class="tab-pane fade" id="pills-detalle-para-picar" role="tabpanel" aria-labelledby="pills-detalle-para-picar-tab">
                <div class="row">
                    {{-- init --}}
                    @if(count($carac_registro_para_picar->detalle_registros_para_picar) > 0)
                        <div class="col-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                @php $first = true; @endphp
                                @foreach($carac_registro_para_picar->detalle_registros_para_picar as $det_reg_p_picar)
                                    @php $det_reg_p_picar->cod_pill = "v-pills-det-reg-picar-". $det_reg_p_picar->id; @endphp
                                    <button class="nav-link {{$first? 'active': ''}}" id="{{ $det_reg_p_picar->cod_pill }}-tab" data-toggle="pill" data-target="#{{ $det_reg_p_picar->cod_pill }}" type="button" role="tab" aria-controls="{{ $det_reg_p_picar->cod_pill }}" aria-selected="true">@if($det_reg_p_picar->producto_envasado) {{ $det_reg_p_picar->producto_envasado->codigo }} @else NaN @endif </button>
                                    @php $first = false; @endphp
                                @endforeach
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                @php $first = true; @endphp
                                @foreach($carac_registro_para_picar->detalle_registros_para_picar as $det_reg_p_picar)
                                    <div class="tab-pane fade {{$first? 'show active': ''}}" id="{{ $det_reg_p_picar->cod_pill }}" role="tabpanel" aria-labelledby="{{ $det_reg_p_picar->cod_pill }}-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="text-center">Detalles registro para picar</h5>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text text-secondary">
                                                            <i class="fa fa-calendar-check"></i> <span class="ms-1">Modificado</span>
                                                        </div>
                                                    </div>
                                                    <span class="form-control text-secondary"> {{ $det_reg_p_picar->updated_at }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text text-secondary">
                                                            <i class="fa fa-user"></i> <span class="ms-1">Por</span>
                                                        </div>
                                                    </div>
                                                    <span class="form-control text-secondary"> {{ $det_reg_p_picar->user->username }}</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-triangle-exclamation"></i> <span class="ms-1">Observación</span>
                                                        </div>
                                                    </div>
                                                    <span class="form-control"> {{ $det_reg_p_picar->observacion }}</span>
                                                </div>
                                            </div>

                                            @if($det_reg_p_picar->producto_envasado)
                                                <hr>
                                                <div class="col-md-12">
                                                    @include('livewire.extras.data-producto-envasado', [
                                                        'data_producto_envasado' => $det_reg_p_picar->producto_envasado,
                                                        'data_listar' => true
                                                    ])
                                                </div>
                                                
                                                {{-- @if($det_reg_p_picar->detalle_proceso_preparacion->proceso_preparacion)
                                                    <hr>
                                                    @include('livewire.extras.data-proceso-preparacion', [
                                                        'data_proceso_preparacion' => $det_reg_p_picar->detalle_proceso_preparacion->proceso_preparacion,
                                                    ])

                                                    @if($det_reg_p_picar->detalle_proceso_preparacion->proceso_preparacion->despacho)
                                                        <hr>
                                                        @include('livewire.extras.data-despacho', [
                                                            'data_despacho' => $det_reg_p_picar->detalle_proceso_preparacion->proceso_preparacion->despacho,
                                                        ])
                                                    @endif

                                                    @if($det_reg_p_picar->detalle_proceso_preparacion->proceso_preparacion->registro_para_picar)
                                                        <hr>
                                                        @include('livewire.extras.data-registro-para-picar', [
                                                            'data_registro_para_picar' => $det_reg_p_picar->detalle_proceso_preparacion->proceso_preparacion->registro_para_picar,
                                                        ])
                                                    @endif
                                                @endif --}}
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
                        <p>No se han asignado datos, para picar</p>
                    @endif
                    {{-- end --}}
                </div>
            </div>
            
            <div class="tab-pane fade show active" id="pills-registros-para-picar" role="tabpanel" aria-labelledby="pills-registros-para-picar-tab">
                @include('livewire.extras.data-registro-para-picar', [
                    'data_registro_para_picar' => $carac_registro_para_picar,
                    'data_listar' => true
                ])
            </div>

            @if($carac_registro_para_picar->preparacion)
                <div class="tab-pane fade" id="pills-proceso_preparacion" role="tabpanel" aria-labelledby="pills-proceso_preparacion-tab">
                    @include('livewire.extras.data-proceso-preparacion', [
                        'data_proceso_preparacion' => $carac_registro_para_picar->preparacion,
                        'data_listar' => true
                    ])
                </div>
            @endif
        </div>
        <hr>

    </div>
@endif