@if(isset($data_detalle_proceso_preparacion))
    <div class="row">
        <div class="col-md-12">
            <h5 class="text-center">DETALLE PROCESO PREPARACIÓN</h5>
        </div>
        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="código de preparación">
                    <div class="input-group-text">
                        <i class="fa fa-lock"></i> <span class="ms-1">Código</span>
                    </div>
                </div>
                <span class="form-control">@if($data_detalle_proceso_preparacion->proceso_preparacion)  {{ $data_detalle_proceso_preparacion->proceso_preparacion->codigo }} @endif </span>
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
                        $txt = Carbon\Carbon::create($data_detalle_proceso_preparacion->fecha);
                        $dia_ = $txt->locale('es')->isoFormat(', dddd'); # dddd, D \d\e MMMM \d\e\l YYYY
                    } catch (\Exception $e) {
                        # nada
                    }
                @endphp
                <span class="form-control"> {{ $data_detalle_proceso_preparacion->fecha . $dia_ }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="número de balde">
                    <div class="input-group-text">
                        <i class="fa fa-bucket"></i> <span class="ms-1">Número</span>
                    </div>
                </div>
                <span class="form-control"> {{ $data_detalle_proceso_preparacion->nro_balde }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend" title="kg de balde">
                    <div class="input-group-text">
                        <i class="fa fa-weight-scale"></i> <span class="ms-1">Kilogramos</span>
                    </div>
                </div>
                <span class="form-control"> {{ $data_detalle_proceso_preparacion->kg_balde }}</span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-triangle-exclamation"></i> <span class="ms-1">Observaciones</span>
                    </div>
                </div>
                <span class="form-control"> {{ $data_detalle_proceso_preparacion->observacion }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text text-secondary">
                        <i class="fa fa-calendar-check"></i> <span class="ms-1">Ultima modificación</span>
                    </div>
                </div>
                <span class="form-control text-secondary"> {{ $data_detalle_proceso_preparacion->updated_at }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text text-secondary">
                        <i class="fa fa-user"></i> <span class="ms-1">Por</span>
                    </div>
                </div>
                <span class="form-control text-secondary"> {{ $data_detalle_proceso_preparacion->user->username }}</span>
            </div>
        </div>

    </div>
@else
    <div class="text-danger-text-center">No hay detalles de detalles de proceso preparación.</div>
@endif