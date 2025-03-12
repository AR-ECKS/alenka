@if(isset($data_producto_envasado))
    <div class="row">
        <div class="col-md-12">
            <h5 class="text-center">PRODUCTO ENVASADO</h5>
        </div>
        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-lock"></i> <span class="ms-1">Código</span>
                    </div>
                </div>
                <span class="form-control"> {{ $data_producto_envasado->codigo }}</span>
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
                        $txt = Carbon\Carbon::create($data_producto_envasado->fecha);
                        $dia_ = $txt->locale('es')->isoFormat(', dddd'); # dddd, D \d\e MMMM \d\e\l YYYY
                    } catch (\Exception $e) {
                        # nada
                    }
                @endphp
                <span class="form-control"> {{ $data_producto_envasado->fecha . $dia_ }}</span>
            </div>
        </div>

        <div class="col-md-6">
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-lock"></i> <span class="ms-1">Sabor</span>
                    </div>
                </div>
                <span class="form-control"> {{ $data_producto_envasado->sabor }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-user"></i> <span class="ms-1">Nombre</span>
                    </div>
                </div>
                @if($data_producto_envasado->encargado)
                    <span class="form-control"> {{ $data_producto_envasado->encargado->username }}</span>
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
                <span class="form-control"> {{ $data_producto_envasado->maquina->nombre }}</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="Balde - saldo anterior">
                    <div class="input-group-text">
                        <i class="fa fa-bucket"></i> <span class="ms-1">Saldo ant.</span>
                    </div>
                </div>
                <span class="form-control">
                    @if($data_producto_envasado->producto_saldo_anterior)
                        {{$data_producto_envasado->producto_saldo_anterior->balde_sobro_del_dia}} <span class="text-primary">({{$data_producto_envasado->producto_saldo_anterior->balde_sobro_del_dia_kg}} kg)</span>
                    </span>
                    @else 
                        -
                    @endif
            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="Balde - cambio de máquina">
                    <div class="input-group-text">
                        <i class="fa fa-bucket"></i> <span class="ms-1">cambio</span>
                    </div>
                </div>
                <span class="form-control">
                    @if($data_producto_envasado->producto_cambio_de_maquina)
                        {{$data_producto_envasado->balde_cambio_de_maquina_baldes}} <span class="text-primary">({{$data_producto_envasado->balde_cambio_de_maquina_kg}} kg)</span>
                    </span>
                    @else 
                        -
                    @endif

                    {{-- perdidas --}}
                    @if($data_producto_envasado->cambio_maquina_descuento)
                        <span class="text-danger" title="Descuento de entrada de máquina">({{$data_producto_envasado->cambio_maquina_descuento->balde_cambio_de_maquina_kg}} kg.)</span>
                    @endif
            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="Balde - entrada de molinos">
                    <div class="input-group-text">
                        <i class="fa fa-bucket"></i> <span class="ms-1">Entrada</span>
                    </div>
                </div>
                <span class="form-control">
                    @if($data_producto_envasado->entrada_cantidad_de_baldes > 0)
                        {{ $data_producto_envasado->entrada_cantidad_de_baldes }} <span class="text-primary">({{ $data_producto_envasado->entrada_cantidad_kg }} kg)</span>
                    </span>
                    @else 
                        -
                    @endif
            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="Balde - sobro del día">
                    <div class="input-group-text">
                        <i class="fa fa-bucket"></i> <span class="ms-1">Sobras</span>
                    </div>
                </div>
                <span class="form-control">
                    @if($data_producto_envasado->balde_sobro_del_dia)
                        {{ $data_producto_envasado->balde_sobro_del_dia }} <span class="text-primary">({{ $data_producto_envasado->balde_sobro_del_dia_kg }} kg)</span>
                    </span>
                    @else 
                        -
                    @endif
            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="cajas - salidas de cajas">
                    <div class="input-group-text">
                        <i class="fa fa-box"></i> <span class="ms-1">Cajas</span>
                    </div>
                </div>
                <span class="form-control">
                    @if($data_producto_envasado->caja_cajas)
                        {{ $data_producto_envasado->caja_cajas }} </span>
                    </span>
                    @else 
                        -
                    @endif
            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="cajas - salidas de bolsitas">
                    <div class="input-group-text">
                        <i class="fa fa-rug"></i> <span class="ms-1">Bolsas</span>
                    </div>
                </div>
                <span class="form-control">
                    @if($data_producto_envasado->caja_bolsas)
                        {{ $data_producto_envasado->caja_bolsas }} </span>
                    </span>
                    @else 
                        -
                    @endif
            </div>
        </div>

        <div class="col-md-6"></div>
    
        <div class="col-md-3">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="Total baldes">
                    <div class="input-group-text">
                        <i class="fa fa-bucket"></i> <span class="ms-1">Total</span>
                    </div>
                </div>
                <span class="form-control">
                    {{ $data_producto_envasado->alk_total_baldes }} </span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="Baldes disponibles">
                    <div class="input-group-text">
                        <i class="fa fa-bucket"></i> <span class="ms-1">Disponible</span>
                    </div>
                </div>
                <span class="form-control">
                    {{ $data_producto_envasado->alk_disponible_baldes }} </span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="Total kilogramos">
                    <div class="input-group-text">
                        <i class="fa fa-weight-scale"></i> <span class="ms-1">Total</span>
                    </div>
                </div>
                <span class="form-control">
                    {{ $data_producto_envasado->alk_total_kg }} </span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="Kilogramos disponibles">
                    <div class="input-group-text">
                        <i class="fa fa-weight-scale"></i> <span class="ms-1">Disponible</span>
                    </div>
                </div>
                <span class="form-control">
                    {{ $data_producto_envasado->alk_disponible_kg }} </span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-triangle-exclamation"></i> <span class="ms-1">Observaciones</span>
                    </div>
                </div>
                <span class="form-control"> {{ $data_producto_envasado->observacion }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text text-secondary">
                        <i class="fa fa-calendar-check"></i> <span class="ms-1">Ultima modificación</span>
                    </div>
                </div>
                <span class="form-control text-secondary"> {{ $data_producto_envasado->updated_at }}</span>
            </div>
        </div>

        <div class="col-md-6">
            {{-- <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text text-secondary">
                        <i class="fa fa-user"></i> <span class="ms-1">Por</span>
                    </div>
                </div>
                <span class="form-control text-secondary"> {{ $data_producto_envasado->user->username }}</span>
            </div> --}}
        </div>

        @if($data_producto_envasado->para_picar == 1)
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
                    <span class="form-control"> {{ $data_producto_envasado->para_picar_kg_de_bolsitas }} kg.</span>
                </div>
            </div>

            <div class="col-md-5">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-receipt"></i> <span class="ms-1">nro. bolsitas</span>
                        </div>
                    </div>
                    <span class="form-control"> {{ $data_producto_envasado->para_picar_nro_de_bolsitas }}</span>
                </div>
            </div>
        @endif

    </div>

    @if(count($data_producto_envasado->salidas_de_molino) > 0 && isset($data_listar))
        <hr>
        <h5 class="text-center">SALIDAS DE MOLINO</h5>
        <div class="table-responsive-xl">
            <table class="table table-sm text-sm table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Código</th>
                        <th>Turno</th>
                        <th>Nro. de baldes</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_producto_envasado->salidas_de_molino as $detail)
                        <tr>
                            <td>{{ $detail->fecha }}</td>
                            <td>{{ $detail->codigo }}</td>
                            <td>{{ $detail->turno }}  </td>
                            <td>{{ $detail->cantidad_baldes }} <span class="text-primary">({{ $detail->cantidad_kg }} kg)</span></td>
                            <td>{{ $detail->observacion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@else
    <div class="text-danger-text-center">No hay producto envasado.</div>
@endif