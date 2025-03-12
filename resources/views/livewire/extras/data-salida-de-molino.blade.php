@if(isset($data_salida_de_molino))
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
                <span class="form-control"> {{ $data_salida_de_molino->codigo }}</span>
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
                        $txt = Carbon\Carbon::create($data_salida_de_molino->fecha);
                        $dia_ = $txt->locale('es')->isoFormat(', dddd'); # dddd, D \d\e MMMM \d\e\l YYYY
                    } catch (\Exception $e) {
                        # nada
                    }
                @endphp
                <span class="form-control"> {{ $data_salida_de_molino->fecha . $dia_ }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-lock"></i> <span class="ms-1">Turno</span>
                    </div>
                </div>
                <span class="form-control"> {{ $data_salida_de_molino->turno }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-lock"></i> <span class="ms-1">Sabor</span>
                    </div>
                </div>
                <span class="form-control"> {{ $data_salida_de_molino->sabor }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-user"></i> <span class="ms-1">Nombre</span>
                    </div>
                </div>
                @if($data_salida_de_molino->recepcionista)
                    <span class="form-control"> {{ $data_salida_de_molino->recepcionista->username }}</span>
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
                <span class="form-control"> {{ $data_salida_de_molino->maquina->nombre }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-bucket"></i> <span class="ms-1">Baldes</span>
                    </div>
                </div>
                <span class="form-control"> {{ $data_salida_de_molino->cantidad_baldes }} <span class="text-primary">({{ $data_salida_de_molino->cantidad_kg }} kg)</span></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-lock"></i> <span class="ms-1">Productos Envasados</span>
                    </div>
                </div>
                <span class="form-control">
                    @if($data_salida_de_molino->producto_envasado)
                        {{ $data_salida_de_molino->producto_envasado->codigo }}
                    @else 
                        <span class="text-danger">No asignado</span>
                    @endif
                </span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-triangle-exclamation"></i> <span class="ms-1">Observaciones</span>
                    </div>
                </div>
                <span class="form-control"> {{ $data_salida_de_molino->observacion }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text text-secondary">
                        <i class="fa fa-calendar-check"></i> <span class="ms-1">Ultima modificación</span>
                    </div>
                </div>
                <span class="form-control text-secondary"> {{ $data_salida_de_molino->updated_at }}</span>
            </div>
        </div>

    </div>

    <hr>
    @if(count($data_salida_de_molino->detalle_salida_molinos) > 0 && isset($data_listar))
        <div class="table-responsive-xl">
            <table class="table table-sm text-sm table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Nro. de balde</th>
                        <th>Kilogramos</th>
                        <th>Código preparación</th>
                        <th>Ultima modificación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_salida_de_molino->detalle_salida_molinos as $detail)
                        <tr>
                            <td>{{ $detail->detalle_proceso_preparacion->fecha }}</td>
                            <td>{{ $detail->detalle_proceso_preparacion->nro_balde }}</td>
                            <td>{{ $detail->detalle_proceso_preparacion->kg_balde }} kg. </td>
                            <td>{{ $detail->detalle_proceso_preparacion->proceso_preparacion->codigo }}</td>
                            <td>{{ $detail->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@else
    <div class="text-danger-text-center">No hay Salida de molino.</div>
@endif