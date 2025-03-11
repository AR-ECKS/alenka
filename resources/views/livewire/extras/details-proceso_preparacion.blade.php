@if($carac_proceso_preparacion)
    <div class="col-md-12">

        <ul class="nav nav-pills mb-3" {{-- id="pills-tab" --}} role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-despacho-tab" data-toggle="pill" data-target="#pills-despacho" type="button" role="tab" aria-controls="pills-despacho" aria-selected="false">Despacho</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-registro-picar-tab" data-toggle="pill" data-target="#pills-registro-picar" type="button" role="tab" aria-controls="pills-registro-picar" aria-selected="false">Para picar</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-preparacion-tab" data-toggle="pill" data-target="#pills-preparacion" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Detalles</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-detalle-salida-molino-tab" data-toggle="pill" data-target="#pills-detalle-salida-molino" type="button" role="tab" aria-controls="pills-detalle-salida-molino" aria-selected="false">Salida de molino</button>
            </li>
        </ul>
        <div class="tab-content" {{-- id="pills-tabContent" --}}>
            <div class="tab-pane fade" id="pills-despacho" role="tabpanel" aria-labelledby="pills-despacho-tab">
                @include('livewire.extras.data-despacho', [
                    'data_despacho' => $carac_proceso_preparacion->despacho
                ])
                {{-- <p>{{ json_encode( $carac_proceso_preparacion->despacho )}}</p> --}}
            </div>
            <div class="tab-pane fade" id="pills-registro-picar" role="tabpanel" aria-labelledby="pills-registro-picar-tab">
                @include('livewire.extras.data-registro-para-picar', [
                    'data_registro_para_picar' => $carac_proceso_preparacion->registro_para_picar
                ])
            </div>
            <div class="tab-pane fade show active" id="pills-preparacion" role="tabpanel" aria-labelledby="pills-preparacion-tab">
                @include('livewire.extras.data-proceso-preparacion', [
                    'data_proceso_preparacion' => $carac_proceso_preparacion
                ])
            </div>
            <div class="tab-pane fade" id="pills-detalle-salida-molino" role="tabpanel" aria-labelledby="pills-detalle-salida-molino-tab">
                <div class="row">
                    {{-- init --}}
                    @if(count($carac_proceso_preparacion->detalle_proceso_preparacion) > 0)
                        <div class="col-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                @php $first = true; @endphp
                                @foreach($carac_proceso_preparacion->detalle_proceso_preparacion as $det_proceso)
                                    @php $det_proceso->cod_pill = "v-pills-det-preparacion-". $det_proceso->id; @endphp
                                    <button class="nav-link {{$first? 'active': ''}}" id="{{ $det_proceso->cod_pill }}-tab" data-toggle="pill" data-target="#{{ $det_proceso->cod_pill }}" type="button" role="tab" aria-controls="{{ $det_proceso->cod_pill }}" aria-selected="true">Balde {{ $det_proceso->nro_balde }}</button>
                                    @php $first = false; @endphp
                                @endforeach
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                @php $first = true; @endphp
                                @foreach($carac_proceso_preparacion->detalle_proceso_preparacion as $det_proceso)
                                    <div class="tab-pane fade {{$first? 'show active': ''}}" id="{{ $det_proceso->cod_pill }}" role="tabpanel" aria-labelledby="{{ $det_proceso->cod_pill }}-tab">
                                        @if($det_proceso->detalle_salida_de_molino)
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
                                                        <span class="form-control text-secondary"> {{ $det_proceso->detalle_salida_de_molino->updated_at }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-secondary">
                                                                <i class="fa fa-user"></i> <span class="ms-1">Por</span>
                                                            </div>
                                                        </div>
                                                        <span class="form-control text-secondary"> {{ $det_proceso->detalle_salida_de_molino->user->username }}</span>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="col-md-6">
                                                    @if($det_proceso->detalle_salida_de_molino->salida_molino)
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h5 class="text-center">SALIDA DE MOLINO</h5>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-lock"></i> <span class="ms-1">Código</span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="form-control"> {{ $det_proceso->detalle_salida_de_molino->salida_molino->codigo }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-calendar"></i> <span class="ms-1">Fecha</span>
                                                                        </div>
                                                                    </div>
                                                                    @php 
                                                                        $dia_ = '';
                                                                        try {
                                                                            $txt = Carbon\Carbon::create($det_proceso->detalle_salida_de_molino->salida_molino->fecha);
                                                                            $dia_ = $txt->locale('es')->isoFormat(', dddd'); # dddd, D \d\e MMMM \d\e\l YYYY
                                                                        } catch (\Exception $e) {
                                                                            # nada
                                                                        }
                                                                    @endphp
                                                                    <span class="form-control"> {{ $det_proceso->detalle_salida_de_molino->salida_molino->fecha . $dia_ }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-lock"></i> <span class="ms-1">Turno</span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="form-control"> {{ $det_proceso->detalle_salida_de_molino->salida_molino->turno }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-lock"></i> <span class="ms-1">Sabor</span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="form-control"> {{ $det_proceso->detalle_salida_de_molino->salida_molino->sabor }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-user"></i> <span class="ms-1">Nombre</span>
                                                                        </div>
                                                                    </div>
                                                                    @if($det_proceso->detalle_salida_de_molino->salida_molino->recepcionista)
                                                                        <span class="form-control"> {{ $det_proceso->detalle_salida_de_molino->salida_molino->recepcionista->username }}</span>
                                                                    @else
                                                                        <span class="form-control-text-danger">SIN OPERADOR</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-lock"></i> <span class="ms-1">Máquina</span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="form-control"> {{ $det_proceso->detalle_salida_de_molino->salida_molino->maquina->nombre }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-triangle-exclamation"></i> <span class="ms-1">Observaciones</span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="form-control"> {{ $det_proceso->detalle_salida_de_molino->salida_molino->observacion }}</span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @else
                                                        <p class="text-danger text-center">No asignado a molino.</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    @if(/* $det_proceso->detalle_salida_de_molino && $det_proceso->detalle_salida_de_molino->salida_molino &&  */ isset($det_proceso->detalle_salida_de_molino->salida_molino->producto_envasado))
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h5 class="text-center">PRODUCTOS ENVASADOS</h5>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-lock"></i> <span class="ms-1">Código</span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="form-control"> {{ $det_proceso->detalle_salida_de_molino->salida_molino->producto_envasado->codigo }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-calendar"></i> <span class="ms-1">Fecha</span>
                                                                        </div>
                                                                    </div>
                                                                    @php 
                                                                        $fech_ = $det_proceso->detalle_salida_de_molino->salida_molino->producto_envasado->fecha;
                                                                        try {
                                                                            $txt = Carbon\Carbon::create($fech_);
                                                                            $dia_ = $txt->locale('es')->isoFormat('YYYY-MM-DD, dddd'); # dddd, D \d\e MMMM \d\e\l YYYY
                                                                        } catch (\Exception $e) {
                                                                            # nada
                                                                        }
                                                                    @endphp
                                                                    <span class="form-control"> {{ $fech_ }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6"></div>

                                                            <div class="col-md-6">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-lock"></i> <span class="ms-1">Sabor</span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="form-control"> {{ $det_proceso->detalle_salida_de_molino->salida_molino->producto_envasado->sabor }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-user"></i> <span class="ms-1">Nombre</span>
                                                                        </div>
                                                                    </div>
                                                                    @if($det_proceso->detalle_salida_de_molino->salida_molino->producto_envasado->encargado)
                                                                        <span class="form-control"> {{ $det_proceso->detalle_salida_de_molino->salida_molino->producto_envasado->encargado->username }}</span>
                                                                    @else
                                                                        <span class="form-control-text-danger">SIN OPERADOR</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-lock"></i> <span class="ms-1">Máquina</span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="form-control"> {{ $det_proceso->detalle_salida_de_molino->salida_molino->producto_envasado->maquina->nombre }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fa fa-triangle-exclamation"></i> <span class="ms-1">Observaciones</span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="form-control"> {{ $det_proceso->detalle_salida_de_molino->salida_molino->producto_envasado->observacion }}</span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @else
                                                    <p class="text-danger text-center">Aun no esta asignado a productos envasados</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-danger">Aun no está asignado</p>
                                        @endif
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
        </div>
        <hr>

    </div>
@endif