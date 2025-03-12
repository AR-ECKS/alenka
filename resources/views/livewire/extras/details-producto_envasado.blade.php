@if($carac_productos_envasados)

    <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-salida-de-molino-tab" data-toggle="pill" data-target="#pills-salida-de-molino" type="button" role="tab" aria-controls="pills-detalle-salida-molino" aria-selected="false">Lista - Salidas de Molino</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-producto-envasado-tab" data-toggle="pill" data-target="#pills-producto-envasado" type="button" role="tab" aria-controls="pills-producto-envasado" aria-selected="true">Detalles</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-detalles-producto-envasado-tab" data-toggle="pill" data-target="#pills-detalles-producto-envasado" type="button" role="tab" aria-controls="pills-detalles-producto-envasado" aria-selected="false">Detalles prod. envasados</button>
        </li>
    </ul>
    <div class="tab-content">

        <div class="tab-pane fade" id="pills-salida-de-molino" role="tabpanel" aria-labelledby="pills-salida-de-molino-tab">
            <div class="row">
                {{-- init --}}
                @if(count($carac_productos_envasados->salidas_de_molino) > 0)
                    <div class="col-2">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @php $first = true; @endphp
                            @foreach($carac_productos_envasados->salidas_de_molino as $det_sal_molino)
                                @php $det_sal_molino->cod_pill = "v-pills-salida-molino-". $det_sal_molino->id; @endphp
                                <button class="nav-link {{$first? 'active': ''}}" id="{{ $det_sal_molino->cod_pill }}-tab" data-toggle="pill" data-target="#{{ $det_sal_molino->cod_pill }}" type="button" role="tab" aria-controls="{{ $det_sal_molino->cod_pill }}" aria-selected="true">{{ $det_sal_molino->codigo }} </button>
                                @php $first = false; @endphp
                            @endforeach
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="tab-content" id="v-pills-tabContent">
                            @php $first = true; @endphp
                            @foreach($carac_productos_envasados->salidas_de_molino as $det_sal_molino)
                                <div class="tab-pane fade {{$first? 'show active': ''}}" id="{{ $det_sal_molino->cod_pill }}" role="tabpanel" aria-labelledby="{{ $det_sal_molino->cod_pill }}-tab">
                                    @include('livewire.extras.data-salida-de-molino', [
                                        'data_salida_de_molino' => $det_sal_molino,
                                        'data_listar' => true
                                    ])
                                </div>
                                @php $first = false; @endphp
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="text-danger">No se han asignados salidas de molino.</p>
                @endif
                {{-- end --}}
            </div>
        </div>

        <div class="tab-pane fade  show active" id="pills-producto-envasado" role="tabpanel" aria-labelledby="pills-producto-envasado-tab">
            @include('livewire.extras.data-producto-envasado', [
                'data_producto_envasado' => $carac_productos_envasados,
                'data_listar' => true
            ])
        </div>
        
        <div class="tab-pane fade" id="pills-detalles-producto-envasado" role="tabpanel" aria-labelledby="pills-detalles-producto-envasado-tab">
            <div class="row">
                <div class="col-md-2">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-prod-env-saldo-anterior-tab" data-toggle="pill" data-target="#v-pills-prod-env-saldo-anterior" type="button" role="tab" aria-controls="v-pills-prod-env-saldo-anterior" aria-selected="true"> Saldo anterior </button>
                        <button class="nav-link" id="v-pills-prod-env-cambio-maquina-tab" data-toggle="pill" data-target="#v-pills-prod-env-cambio-maquina" type="button" role="tab" aria-controls="v-pills-prod-env-cambio-maquina" aria-selected="false"> Cambio máquina </button>
                        <button class="nav-link" id="v-pills-prod-env-sobro-del-dia-tab" data-toggle="pill" data-target="#v-pills-prod-env-sobro-del-dia" type="button" role="tab" aria-controls="v-pills-prod-env-sobro-del-dia" aria-selected="false"> Sobro del día </button>
                        <button class="nav-link" id="v-pills-prod-env-para-picar-tab" data-toggle="pill" data-target="#v-pills-prod-env-para-picar" type="button" role="tab" aria-controls="v-pills-prod-env-para-picar" aria-selected="false"> Para picar </button>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-prod-env-saldo-anterior" role="tabpanel" aria-labelledby="v-pills-prod-env-saldo-anterior-tab">
                            @if($carac_productos_envasados->producto_saldo_anterior)
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend" title="Código - saldo anterior">
                                                <div class="input-group-text">
                                                    <i class="fa fa-lock"></i> <span class="ms-1">Código</span>
                                                </div>
                                            </div>
                                            <span class="form-control">{{$carac_productos_envasados->producto_saldo_anterior->codigo}} </span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend" title="Baldes - saldo anterior">
                                                <div class="input-group-text">
                                                    <i class="fa fa-bucket"></i> <span class="ms-1">Saldo anterior (u)</span>
                                                </div>
                                            </div>
                                            <span class="form-control">{{$carac_productos_envasados->producto_saldo_anterior->balde_sobro_del_dia}}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend" title="Kilogramos - saldo anterior">
                                                <div class="input-group-text">
                                                    <i class="fa fa-weight-scale"></i> <span class="ms-1">Saldo anterior (kg)</span>
                                                </div>
                                            </div>
                                            <span class="form-control">{{$carac_productos_envasados->producto_saldo_anterior->balde_sobro_del_dia_kg}} </span>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                @include('livewire.extras.data-producto-envasado', [
                                    'data_producto_envasado' => $carac_productos_envasados->producto_saldo_anterior,
                                ])
                            @else
                                <p class="text-danger">Saldo anterior no asignado</p>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="v-pills-prod-env-cambio-maquina" role="tabpanel" aria-labelledby="v-pills-prod-env-cambio-maquina-tab">
                            @if($carac_productos_envasados->producto_cambio_de_maquina)
                                <h5 class="text-center">ENTRADA CAMBIO DE MÁQUINA</h5>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend" title="Baldes - entrada de cambio de máquina">
                                                <div class="input-group-text">
                                                    <i class="fa fa-bucket"></i> <span class="ms-1">Entrada cambio maq. (u)</span>
                                                </div>
                                            </div>
                                            <span class="form-control">{{$carac_productos_envasados->balde_cambio_de_maquina_baldes}}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend" title="Kilogramos - entrada de cambio de máquina">
                                                <div class="input-group-text">
                                                    <i class="fa fa-weight-scale"></i> <span class="ms-1">Entrada cambio maq. (kg)</span>
                                                </div>
                                            </div>
                                            <span class="form-control">{{$carac_productos_envasados->balde_cambio_de_maquina_kg}} </span>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                @include('livewire.extras.data-producto-envasado', [
                                    'data_producto_envasado' => $carac_productos_envasados->producto_cambio_de_maquina,
                                ])
                            @else
                            <p class="text-danger">Entrada cambio de máquina no asignado</p>
                            @endif

                            {{-- PERDIDAS --}}
                            @if($carac_productos_envasados->cambio_maquina_descuento)
                                <hr>
                                <h5 class="text-center">PERDIDAS CAMBIO DE MÁQUINA</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend" title="Código - perdidas en cambio de máquina">
                                                <div class="input-group-text">
                                                    <i class="fa fa-lock"></i> <span class="ms-1">- código</span>
                                                </div>
                                            </div>
                                            <span class="form-control">{{$carac_productos_envasados->cambio_maquina_descuento->codigo}} </span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend" title="Baldes - perdidas de cambio de máquina">
                                                <div class="input-group-text">
                                                    <i class="fa fa-bucket"></i> <span class="ms-1">- cambio maq. (u)</span>
                                                </div>
                                            </div>
                                            <span class="form-control">{{$carac_productos_envasados->cambio_maquina_descuento->balde_cambio_de_maquina_baldes}}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend" title="Kilogramos - perdidas de cambio de máquina">
                                                <div class="input-group-text">
                                                    <i class="fa fa-weight-scale"></i> <span class="ms-1">- cambio maq. (kg)</span>
                                                </div>
                                            </div>
                                            <span class="form-control">{{$carac_productos_envasados->cambio_maquina_descuento->balde_cambio_de_maquina_kg}} </span>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                @include('livewire.extras.data-producto-envasado', [
                                    'data_producto_envasado' => $carac_productos_envasados->cambio_maquina_descuento,
                                ])

                            @endif
                        </div>
                        <div class="tab-pane fade" id="v-pills-prod-env-sobro-del-dia" role="tabpanel" aria-labelledby="v-pills-prod-env-sobro-del-dia-tab">
                            @if($carac_productos_envasados->balde_sobro_del_dia)
                                <div class="row">
                                    <div class="col-md-4">
                                        @if($carac_productos_envasados->sobro_del_dia_descuento)
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend" title="Código - saldo anterior">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-lock"></i> <span class="ms-1">Código</span>
                                                    </div>
                                                </div>
                                                <span class="form-control">{{$carac_productos_envasados->sobro_del_dia_descuento->codigo}} </span>
                                            </div>
                                        @else
                                            <span class="text-danger">No asignado</span>
                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend" title="Baldes - sobro del día">
                                                <div class="input-group-text">
                                                    <i class="fa fa-bucket"></i> <span class="ms-1">Saldo anterior (u)</span>
                                                </div>
                                            </div>
                                            <span class="form-control">{{$carac_productos_envasados->balde_sobro_del_dia}}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend" title="Kilogramos - sobro del día">
                                                <div class="input-group-text">
                                                    <i class="fa fa-weight-scale"></i> <span class="ms-1">Saldo anterior (kg)</span>
                                                </div>
                                            </div>
                                            <span class="form-control">{{$carac_productos_envasados->balde_sobro_del_dia_kg}} </span>
                                        </div>
                                    </div>
                                </div>

                                @if($carac_productos_envasados->sobro_del_dia_descuento)
                                    <hr>
                                    @include('livewire.extras.data-producto-envasado', [
                                        'data_producto_envasado' => $carac_productos_envasados->sobro_del_dia_descuento,
                                    ])
                                @endif
                            @else
                                <p class="text-danger">Sobras del día no asignado</p>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="v-pills-prod-env-para-picar" role="tabpanel" aria-labelledby="v-pills-prod-env-para-picar-tab">
                            @if($carac_productos_envasados->para_picar == 1)
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text text-secondary">
                                                    <i class="fa fa-hamer"></i> <span class="ms-1">Para Picar</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="col-md-5">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-weight-scale"></i> <span class="ms-1">Kilogramos</span>
                                                </div>
                                            </div>
                                            <span class="form-control"> {{ $carac_productos_envasados->para_picar_kg_de_bolsitas }} kg.</span>
                                        </div>
                                    </div>
                        
                                    <div class="col-md-5">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-receipt"></i> <span class="ms-1">nro. bolsitas</span>
                                                </div>
                                            </div>
                                            <span class="form-control"> {{ $carac_productos_envasados->para_picar_nro_de_bolsitas }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if($carac_productos_envasados->detalle_registro_picar)
                                    <hr>
                                    <h5 class="text-center">DETALLE REGISTRO PARA PICAR</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend" title="Código - Registro para picar">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-lock"></i> <span class="ms-1">Código</span>
                                                    </div>
                                                </div>
                                                <span class="form-control">
                                                    {{isset($carac_productos_envasados->detalle_registro_picar->registro_para_picar->codigo)? $carac_productos_envasados->detalle_registro_picar->registro_para_picar->codigo: 'NaN'}} 
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend" title="Código - Registro para picar">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-traingle-excalamation"></i> <span class="ms-1">Observación</span>
                                                    </div>
                                                </div>
                                                <span class="form-control">{{$carac_productos_envasados->detalle_registro_picar->observacion}} </span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text text-secondary">
                                                        <i class="fa fa-calendar-check"></i> <span class="ms-1">Ultima modificación</span>
                                                    </div>
                                                </div>
                                                <span class="form-control text-secondary"> {{ $carac_productos_envasados->detalle_registro_picar->updated_at }}</span>
                                            </div>
                                        </div>
                                
                                        <div class="col-md-6">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text text-secondary">
                                                        <i class="fa fa-user"></i> <span class="ms-1">Por</span>
                                                    </div>
                                                </div>
                                                <span class="form-control text-secondary"> {{ $carac_productos_envasados->detalle_registro_picar->user->username }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    @if($carac_productos_envasados->detalle_registro_picar->registro_para_picar)
                                        <hr>
                                        @include('livewire.extras.data-registro-para-picar', [
                                            'data_registro_para_picar' => $carac_productos_envasados->detalle_registro_picar->registro_para_picar,
                                        ])
                                    @endif
                                @endif
                            @else
                                <p class="text-danger">Aún no se ha asignado registros para picar</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            
        </div>

    </div>
@else 
    <p class="text-center">No hay datos prod env.</p>
@endif