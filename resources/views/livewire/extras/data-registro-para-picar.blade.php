@if(isset($data_registro_para_picar))
    <div class="row">
        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-lock"></i> <span class="ms-1">Código</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_registro_para_picar->codigo}}</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-flask"></i> <span class="ms-1">Sabor</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_registro_para_picar->sabor }}</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text text-secondary">
                        <i class="fas fa-calendar-check"></i> <span class="ms-1">Ultima modificación</span>
                    </div>
                </div>
                <span class="form-control text-secondary"> {{ $data_registro_para_picar->updated_at }}</span>
            </div>
        </div>

        @php 
            $fec_ini = $data_registro_para_picar->fecha_inicio;
            try {
                $txt = Carbon\Carbon::create($fec_ini);
                $fec_ini = $txt->locale('es')->isoFormat('dddd, D \d\e MMMM \d\e\l YYYY');
            } catch (\Exception $e) {
                # nada
            }

            $fec_fin = $data_registro_para_picar->fecha_fin;
            try {
                $txt = Carbon\Carbon::create($fec_fin);
                $fec_fin = $txt->locale('es')->isoFormat('dddd, D \d\e MMMM \d\e\l YYYY');
            } catch (\Exception $e) {
                # nada
            }
        @endphp
        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-days"></i> <span class="ms-1">Fecha inicio</span>
                    </div>
                </div>
                <span class="form-control "> {{ $fec_ini }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-days"></i> <span class="ms-1">Límite fecha</span>
                    </div>
                </div>
                <span class="form-control "> {{ $fec_fin }}</span>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-user"></i> <span class="ms-1">Encargado </span>
                    </div>
                </div>
                <span class="form-control @if(is_null($data_registro_para_picar->encargado)) text-danger text-center @endif"> {{ is_null($data_registro_para_picar->encargado)? 'Sin Asignar': $data_registro_para_picar->encargado->username }}</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-weight-scale"></i> <span class="ms-1">Peso total</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_registro_para_picar->cantidad_kg }} kg.</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-weight-scale"></i> <span class="ms-1">Cantidad</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_registro_para_picar->cantidad_bolsitas }} bolsitas</span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-triangle-exclamation"></i> <span class="ms-1">Observación</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_registro_para_picar->observacion }}</span>
            </div>
        </div>

    </div>

    <hr>
    @if(count($data_registro_para_picar->detalle_registros_para_picar) > 0)
        <div class="table-responsive-xl">
            <table class="table table-sm text-sm table-striped">
                <thead class="text-center">
                    <tr>
                        <th rowspan="2" class="border-right">Nro</th>
                        <th colspan="5" class="border-right">Detalles de Productos envasados</th>
                        <th colspan="3" >Para Picar</th>
                    </tr>
                    <tr>
                        <th>Codigo de Produccion</th>
                        <th>Fecha</th>
                        <th>Maquina</th>
                        <th>Nombre</th>
                        <th class="border-right" style="max-width: 100px;">Observación</th>
                        
                        <th>Kg.</th>
                        <th>Nro bolsitas</th>
                        <th style="max-width: 100px;">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $anter = 1; @endphp
                    @foreach($data_registro_para_picar->detalle_registros_para_picar as $det_pica)
                        <tr>
                            <th class="border-right">{{ $anter++ }}</th>

                            <td>{{$det_pica->producto_envasado->codigo}}</td>
                            <td>{{$det_pica->producto_envasado->fecha}}</td>
                            <td>{{$det_pica->producto_envasado->maquina->nombre}}</td>
                            <td>
                                @if($det_pica->producto_envasado->encargado)
                                    {{$det_pica->producto_envasado->encargado->username}}
                                @else
                                    <span class="text-danger">SIN OPERADOR</span>
                                @endif
                            </td>
                            <td class="border-right" style="max-width: 100px;">{{$det_pica->producto_envasado->observacion}}</td>

                            <td class="text-center">{{$det_pica->producto_envasado->para_picar_kg_de_bolsitas}} kg.</td>
                            <td class="text-center">{{$det_pica->producto_envasado->para_picar_nro_de_bolsitas}}</td>
                            <td style="max-width: 100px;">{{$det_pica->observacion}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@else
    <div class="text-danger-text-center">No hay registro para picar.</div>
@endif