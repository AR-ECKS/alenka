<div>
    <div class="float-right mt-3">
        <a type="button" class="btn btn-primary text-white" wire:click="open_modal_crear_salida_mol">
            <i class="fas fa-database"></i> Nueva Salida de Molino 
        </a>
    </div>

    <br><br><br>
    <div class="tab-content">
        @if($operation=='create_salida_molino')
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">
                        CREAR NUEVA SALIDA DE MOLINO
                    </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_crear_salida_mol"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="codigo">
                                        <i class="fas fa-lock pe-1"></i>
                                        <b>Código</b>
                                    </label>
                                </div>
                                <input class="form-control @error('codigo') border-danger @enderror" wire:model="codigo" id="codigo"  disabled>
                            </div>
                            @error('codigo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="turno">
                                        <i class="fas fa-clock pe-1"></i>
                                        <b>Turno</b>
                                    </label>
                                </div>
                                <select class="form-control @error('turno') border-danger @enderror" id="turno" wire:model="turno">
                                    <option value="">Seleccione turno</option>
                                    @foreach ($LISTA_TURNOS as $tur)
                                        <option value="{{$tur}}">{{ $tur }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('turno')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-user pe-1"></i>
                                        <b>Entregar a</b>
                                    </div>
                                </div>
                                <select class="form-control @error('encargado_id') border-danger @enderror" wire:model="encargado_id">
                                    <option value="">Seleccione usuario</option>
                                    @foreach ($usuarios as $us)
                                        <option value="{{$us->id}}">{{ $us->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('encargado_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-fax pe-1"></i>
                                        <b>Máquina</b>
                                    </div>
                                </div>
                                <select class="form-control @error('maquina_id') border-danger @enderror" wire:model="maquina_id">
                                    <option value="">Seleccione maquina</option>
                                    @foreach ($maquinas as $maq)
                                        <option value="{{$maq->id}}">{{ $maq->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('maquina_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="sabor">
                                        <i class="fas fa-bucket pe-1"></i>
                                        <b>Sabor</b>
                                    </label>
                                </div>
                                <select class="form-control @error('sabor') border-danger @enderror" id="sabor" wire:model="sabor" wire:change="on_change_sabor">
                                    <option value="">Seleccione sabor</option>
                                    @foreach ($LISTA_DE_SABORES as $sab)
                                        <option value="{{$sab}}">{{ $sab }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('sabor')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="total_aprox">
                                        <i class="fas fa-weight-scale pe-1"></i>
                                        <b>Total Aprox. (kg)</b>
                                    </label>
                                </div>
                                <input class="form-control @error('total_aprox') border-danger @enderror" type="number" wire:model="total_aprox" id="total_aprox" disabled>
                            </div>
                            @error('total_aprox')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="col-md-8">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="observacion">
                                        <i class="fas fa-triangle-exclamation pe-1"></i>
                                        <b>Observación</b>
                                    </label>
                                </div>
                                <textarea class="form-control @error('observacion') border-danger @enderror" wire:model="observacion" id="observacion"></textarea>
                            </div>
                            @error('observacion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="fecha">
                                        <i class="fas fa-calendar pe-1"></i>
                                        <b>Fecha</b>
                                    </label>
                                </div>
                                <input class="form-control @error('fecha') border-danger @enderror" type="date" wire:model="fecha" id="fecha" disabled>
                            </div>
                            @error('fecha')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="input-group-text" for="det_despacho_id" title="código preparación .:: fecha preparación .:: observación de preparación">
                                <b>Preparación</b>
                            </label>
                            <select class="form-control " id="det_despacho_id" wire:model="det_despacho_id" wire:change="on_change_det_despacho_id">
                                <option value="">Seleccione preparación</option>
                                    @foreach ($LISTA_DETALLE_PREPARACION as $prepar)
                                        <option value="{{$prepar['id_proceso_preparacion']}}">{{ $prepar['codigo'] }} .:: {{ $prepar['fecha'] }} .:: {{ $prepar['observacion'] }}</option>
                                    @endforeach
                            </select>
                            @error('det_despacho_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="input-group-text" for="id_balde_detalle_proceso_preparacion" title="nro. de balde .:: kg. de balde .:: observación de balde">
                                <b>Balde</b>
                            </label>
                            <select class="form-control " id="id_balde_detalle_proceso_preparacion" wire:model="id_balde_detalle_proceso_preparacion">
                                <option value="">Seleccione Balde</option>
                                    @foreach ($LISTA_DETALLE_BALDES_DE_PREPARACION as $prep_balde)
                                        <option value="{{$prep_balde['id_det_preparacion']}}">{{ $prep_balde['nro_balde'] }} .:: {{ $prep_balde['kg_balde'] }} kg. .:: {{ $prep_balde['observacion_det_preparacion'] }}</option>
                                    @endforeach
                            </select>
                            @error('id_balde_detalle_proceso_preparacion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <p>{{json_encode($LISTA_DETALLE_PREPARACION)}}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_crear_salida_mol">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="save_modal_crear_salida_mol">GUARDAR</button>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">SALIDAS DE MOLINO</h3>
            </div>

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
                            <option value="{{ $ges}}">{{ $ges}}</option>
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
                                <option value="{{ $me}}">{{ $me}}</option>
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
        </div>


        @if(count($salidas_molino) > 0)
            <div class="table-responsive-xl">
                <table class="table table-sm text-sm table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Fecha</th>
                            <th>Turno</th>
                            <th>Sabor</th>
                            <th>Cantidad de Baldes</th>
                            <th>Nombre</th>
                            <th>Máquina</th>
                            <th>Observaciones</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $contador = ($salidas_molino->perPage() * $salidas_molino->currentPage()) + 1 - $salidas_molino->perPage();
                        @endphp
                        @foreach($salidas_molino as $salda_molino)
                            <tr>
                                <th>{{$contador++}}</th>
                                <td>{{ $salda_molino->codigo }}</td>
                                <td>{{ $salda_molino->fecha }}</td>
                                <td>{{ $salda_molino->turno }}</td>
                                <td>{{ $salda_molino->sabor }}</td>
                                <td>5 </td>
                                <td>{{ $salda_molino->total_aprox }}</td>
                                <td>{{ $salda_molino->receptor->username }}</td>
                                <td>{{ $salda_molino->maquina->nombre }}</td>
                                <td>{{ $salda_molino->observacion }}</td>
                                <td>
                                    @if ($salda_molino->estado == 1)
                                        <span class="badge bg-warning">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>


                                <td class="td-actions text-right">
                                    @if ($salda_molino->estado == 1)
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-cog"></i> Accion
                                            </button>
                                            <div class="dropdown-menu">
                                                   {{--  <a wire:click="show_proceso"
                                                        class="dropdown-item" data-placement="top"
                                                        title="Ver detalles">
                                                        <i class="fas fa-eye"></i> Ver Detalles
                                                    </a> --}}
                                                    {{-- @can('crear_entrega_a_produccion') --}}
                                                    <a wire:click="open_modal_editar_maquina({{ $salda_molino->id }})"
                                                        class="dropdown-item" data-placement="top"
                                                        title="Ver detalles">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                    <a wire:click.prevent="$emit('alerta', 'eliminar_maquina', {{ $salda_molino->id }})"
                                                        class="dropdown-item" data-placement="top"
                                                        title="Eliminar">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </a>
                                                {{-- @endcan --}}
                                            </div>
                                        </div>
                                    @elseif($salda_molino->estado == 0)
                                        <button class="btn-sm btn-dark" wire:click="restaurar_maquina({{ $salda_molino->id }})"><i class="fas fa-undo"></i> Restaurar </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $salidas_molino->links() }}
            </div>
        @else
            <p class="text-danger text-center">No hay registros de salidas.</p>
        @endif
    </div>
</div>
