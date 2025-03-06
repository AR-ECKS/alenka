<div>

    <div class="tab-content">
        @if($operation=='create_producto')
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">
                        CREAR NUEVO PRODUCTO ENVASADO
                    </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_crear_producto"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_crear_producto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="save_modal_crear_producto">GUARDAR</button>
                </div>
            </div>
        
        @else
            {{-- MAIN --}}
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="anio">
                                <i class="fas fa-calendar pe-1"></i>
                                <b>Año</b>
                            </label>
                        </div>
                        <select class="form-control" id="anio" wire:model="anio" wire:change="on_change_anio">
                            <option value="">Todas las gestiones</option>
                            @foreach($list_anio as $ges)
                                <option value="{{ $ges->anio}}">{{ $ges->anio}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div class="col-md-3">
                    @if($statusMes)
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="mes">
                                    <i class="fas fa-calendar pe-1"></i>
                                    <b>Mes</b>
                                </label>
                            </div>
                            <select class="form-control" id="mes" wire:model="mes" wire:change="on_change_mes">
                                <option value="">Todos los meses</option>
                                @foreach($list_mes as $me)
                                    <option value="{{ $me->mes}}">{{ $me->mes}} - {{ \Carbon\Carbon::create(null, $me->mes)->locale('es')->isoFormat('MMMM') }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
    
                <div class="col-md-3">
                    @if($statusDia)
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="dia">
                                    <i class="fas fa-calendar pe-1"></i>
                                    <b>Día</b>
                                </label>
                            </div>
                            <select class="form-control" id="dia" wire:model="dia">
                                <option value="">Todas los días</option>
                                @foreach($list_dias as $di)
                                    <option value="{{ $di['dia']}}">{{ $di['dia'] . ' - '. $di['nombre']}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <div class="col-md-3">
                    <div class="input-group mb-2 ms-5">
                        @php 
                            $arra = [];
                            $texto = "";
                            if(!is_null($anio) && $anio !== "") {
                                $arra['anio'] = $anio;
                                $texto = " DEL ". $anio;
                                if(!is_null($mes) && $mes !== ""){
                                    $arra['mes'] = $mes;
                                    $texto = " DEL ". $anio ."-". $mes;
                                    if(!is_null($dia) && $dia !== ""){
                                        $arra['dia'] = $dia;
                                        $texto = " DEL ". $anio ."-". $mes . "-".$dia;
                                    }
                                }
                            }
                        @endphp
                        <a type="button" class="btn btn-success text-white" 
                            target="_blank" href="{{ route('inventario_productos_envasados.pdf', $arra)}}">GENERAR PDF {{$texto}}</a>
                    </div>
                </div>

            </div>
    
            @if(count($inventario_prod_envasados) > 0)
                <div class="table-responsive-xl">
                    <table class="table table-sm text-sm table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Código de Sabor</th>
                                <th>Sabor</th>
                                <th>Cantidad de cajas</th>
                                <th>Cantidad de bolsitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador = 1;
                            @endphp
                            @foreach($inventario_prod_envasados as $inv_prod_env)
                                <tr>
                                    <th class="text-center border-right">{{$contador++}}</th>
                                    <td class="border-right">{{$inv_prod_env->codigo_producto}}</td>
                                    <td class="border-right">{{$inv_prod_env->sabor}}</td>
                                    <td class="text-center border-right">{{$inv_prod_env->total_cajas}} </td>
                                    <td class="text-center border-right">{{$inv_prod_env->total_bolsas}}</td>
                                </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right">TOTALES</td>
                                    <th class="text-center border-right border-left border-bottom">{{ $inventario_prod_envasados[0]->final_total_cajas }}</th>
                                    <th class="text-center border-right border-left border-bottom">{{ $inventario_prod_envasados[0]->final_total_bolsas}}</th>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-danger text-center">No hay registros de salidas.</p>
            @endif
        @endif
        
    </div>
</div>
