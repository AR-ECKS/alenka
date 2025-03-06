<div>
    <div class="float-right">
        @if($operation == '')
            <a type="button" class="btn btn-primary text-white" wire:click="open_modal_crear_prep_proceso">
                <i class="fas fa-database"></i> Nueva preparación
            </a>
        @endif
    </div>

    {{-- <br><br><br> --}}
    <div class="tab-content">
        @if($operation=='create_proccess_preparation')
        <div class="modal fade show" style="display: block;" id="modalCrearPreparacion" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">NUEVA PREPARACIÓN</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_crear_prep_proceso"></button>
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
                                <input class="form-control" wire:model="codigo" id="codigo" disabled>
                            </div>
                            @error('codigo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="fecha">
                                        <i class="fas fa-calendar pe-1"></i>
                                        <b>Fecha</b>
                                    </label>
                                </div>
                                <input type="date" class="form-control" wire:model="fecha" id="fecha" disabled>
                            </div>
                            @error('fecha')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="despacho_id">
                                        <i class="fas fa-calendar pe-1"></i>
                                        <b>Materia Prima recibida</b>
                                    </label>
                                </div>
                                <select class="form-control @error('despacho_id') border-danger @enderror" wire:model="despacho_id" id="despacho_id">
                                    <option value="">Seleccione Despacho</option>
                                    @foreach($despachos as $des)
                                        <option value="{{ $des->id }}">{{ $des->codigo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('despacho_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 row">
                            @if(!is_null($despacho_id) && $despacho_id!=='' && $despacho_actual)
                                <div class="col-md-6">
                                    <b>sabor:</b> {{ $despacho_actual->sabor}}
                                </div>
                                <div class="col-md-6">
                                    <b>envio de:</b> {{ $despacho_actual->user->username}}
                                </div>
                                <div class="col-md-6">
                                    <b>para:</b> {{ $despacho_actual->receptor_u->username}}
                                </div>
                                <div class="col-md-6">
                                    <b>Observación:</b> {{ $despacho_actual->observacion}}
                                </div>
                                {{-- <span>{{ json_encode($despacho_actual) }}</span> <br>
                                <span>{{ json_encode($despacho_actual->detalle_despachos) }}</span> --}}
                            @endif
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="total_kg">
                                        <i class="fas fa-weight pe-1"></i>
                                        <b>Kg Aprox.</b>
                                    </label>
                                </div>
                                <input type="number" class="form-control @error('total_kg') border-danger @enderror" wire:model="total_kg" id="total_kg" disabled>
                            </div>
                            @error('total_kg')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="disponible_kg">
                                        <i class="fas fa-weight pe-1"></i>
                                        <b>Kg Disponibles.</b>
                                    </label>
                                </div>
                                <input type="number" class="form-control @error('disponible_kg') border-danger @enderror" wire:model="disponible_kg" id="disponible_kg" disabled>
                            </div>
                            @error('disponible_kg')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="observacion">
                                        <i class="fas fa-weight pe-1"></i>
                                        <b>Observación</b>
                                    </label>
                                </div>
                                <input type="text" class="form-control @error('observacion') border-danger @enderror" wire:model="observacion" id="observacion">
                            </div>
                            @error('observacion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_crear_prep_proceso">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="store_modal_crear_prep_proceso">GUARDAR</button>
<<<<<<< HEAD
                    <button type="button" class="btn btn-primary" wire:click="store_modal_crear_prep_proceso({{true}})">GUARDAR Y PROCESAR</button>
=======
>>>>>>> 3eb850f1ab25d2dbc5d70204d179b029c0643dd6
                </div>
            </div>
        @elseif($operation == 'admin_proccess_preparation')
            <div class="card-body">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">ADMINISTRACIÓN DE LA PREPARACIÓN</h5>
                </div>
                <div class="modal-body">
                    @if($adm_proceso_preparacion)
                        <div class="row">
                            <div class="col-md-12">Detalles de la preparación</div>
                            <div class="col-md-4"><b>Código:</b> {{$adm_proceso_preparacion->codigo}}</div>
                            <div class="col-md-4"><b>Fecha:</b> {{$adm_proceso_preparacion->fecha}}</div>
                            <div class="col-md-4"><b>Materia prima:</b> {{$adm_proceso_preparacion->despacho->codigo}}</div>
                            <div class="col-md-4"><b>Kg. Totales:</b> {{$adm_proceso_preparacion->total_kg}}</div>
                            <div class="col-md-4"><b>Kg. Disponibles</b> {{$adm_proceso_preparacion->disponible_kg}}</div>
                            <div class="col-md-4"><b>Observación:</b> {{$adm_proceso_preparacion->observacion}}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="input-group-text" for="nro_balde">
                                    <b>Nro. de Tacho</b>
                                </label>
                                <select class="form-control @error('nro_balde') border-danger @enderror" id="nro_balde" wire:model="nro_balde">
                                    <option value="">Seleccione</option>
                                    @foreach($lista_de_nro_baldes as $balde)
                                        <option value="{{ $balde }}">{{ $balde }}</option>
                                    @endforeach
                                </select>
                                @error('nro_balde')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="input-group-text" for="kg_balde">
                                    <i class="fas fa-weight-scale"></i>
                                    <b>Kg.</b>
                                </label>
                                <input type="number" class="form-control" id="kg_balde" wire:model="kg_balde">
                                {{-- <input type="number" class="form-control @error('kg_balde') border-danger @enderror" id="kg_balde" wire:model="kg_balde"> --}}

                                {{-- @error('kg_balde')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror --}}
                            </div>
                            <div class="col-md-2">
                                <label class="input-group-text" for="d_fecha">
                                    <i class="fas fa-dae"></i>
                                    <b>Fecha</b>
                                </label>
                                <input type="date" class="form-control @error('d_fecha') border-danger @enderror" id="d_fecha" wire:model="d_fecha" disabled>
                                @error('d_fecha')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="input-group-text" for="d_observacion">
                                    <i class="fas fa-triangle-exclamation"></i>
                                    <b>Observación</b>
                                </label>
                                <input type="text" class="form-control @error('d_observacion') border-danger @enderror" id="d_observacion" wire:model="d_observacion">
                                @error('d_observacion')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                @if($adm_proceso_preparacion->disponible_kg > 0)
                                    <button type="button" class="btn btn-success" wire:click="save_detalle_proceso_preparacion">AGREGAR</button>
                                    {{-- <button type="button" class="btn btn-danger" wire:click="restore_detalles_baldes">LIMPIAR</button> --}}
                                @endif
                            </div>
                        </div>
                        <div>
                            @if(count($detalles_procesos) > 0)
                                <div class="table-responsive-xl">
                                    <table class="table table-sm text-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nro. balde</th>
                                                <th>Kilogramos</th>
                                                <th>Fecha</th>
                                                <th>Observación</th>
                                                <th class="text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($detalles_procesos as $det)
                                                <tr>
                                                    <th>{{$det->nro_balde}}</th>
                                                    <td>{{$det->kg_balde}}</td>
                                                    <td>{{$det->fecha}}</td>
                                                    <td>{{$det->observacion}}</td>
                                                    <td>
                                                        @if(is_null($det->detalle_salida_de_molino))
                                                            <button type="button" class="btn btn-danger" title="eliminar" wire:click="delete_detalle_proceso_preparacion({{ $det->id }})">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                NO HAY DATOS
                            @endif
                        </div>
                    @endif
                </div>
                <div class="modal-footer d-flex justify-content-center">
<<<<<<< HEAD
                    <button type="button" class="btn btn-danger" wire:click="close_modal_admin_prep_proceso">VOLVER</button>
=======
                    <button type="button" class="btn btn-primary" wire:click="close_modal_admin_prep_proceso">GUARDAR</button>
>>>>>>> 3eb850f1ab25d2dbc5d70204d179b029c0643dd6
                    {{-- <button type="button" class="btn btn-primary" wire:click="">GUARDAR Y PROCESAR</button> --}}
                </div>
            </div>
        @elseif($operation == 'view_proccess_preparation')
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">DETALLES DE LA PREPARACIÓN</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_show_prep_proceso"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @include('livewire.extras.details-proceso_preparacion', [
                            'carac_proceso_preparacion' => $det_proceso_preparacion
                        ])
                        {{-- <div class="col-md-12">Detalles de la preparación</div>
                        <div class="col-md-4"><b>Código:</b> {{$adm_proceso_preparacion->codigo}}</div>
                        <div class="col-md-4"><b>Fecha:</b> {{$adm_proceso_preparacion->fecha}}</div>
                        <div class="col-md-4"><b>Materia prima:</b> {{$adm_proceso_preparacion->despacho->codigo}}</div>
                        <div class="col-md-4"><b>Kg. Totales:</b> {{$adm_proceso_preparacion->total_kg}}</div>
                        <div class="col-md-4"><b>Kg. Disponibles</b> {{$adm_proceso_preparacion->disponible_kg}}</div>
                        <div class="col-md-4"><b>Observación:</b> {{$adm_proceso_preparacion->observacion}}</div> --}}
                    </div>
                    <div>
                        {{-- @if(count($detalles_procesos) > 0)
                            <div class="table-responsive-xl">
                                <table class="table table-sm text-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nro. balde</th>
                                            <th>Kilogramos</th>
                                            <th>Fecha</th>
                                            <th>Observación</th>
                                            <th class="text-right">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($detalles_procesos as $det)
                                            <tr>
                                                <th>{{$det->nro_balde}}</th>
                                                <td>{{$det->kg_balde}}</td>
                                                <td>{{$det->fecha}}</td>
                                                <td>{{$det->observacion}}</td>
                                                <td>
                                                    @if($det->estado == 1)
                                                        <button type="button" class="btn btn-danger" title="eliminar" wire:click="delete_detalle_proceso_preparacion({{ $det->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            NO HAY DATOS
                        @endif --}}
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_show_prep_proceso">VOLVER</button>
                </div>
            </div>
        @else
            @if(count($procesos_preparacion) > 0)
                <div class="table-responsive-xl">
                    <table class="table table-sm text-sm table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Codigo</th>
                                <th>Observacion</th>
                                <th>Fecha</th>
                                <th>Sabor</th>
                                <th>Kg. Totales</th>
                                <th>Kg. Disponibles</th>
                                <th>Baldes</th>
                                <th>Estado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador = ($procesos_preparacion->perPage() * $procesos_preparacion->currentPage()) + 1 - $procesos_preparacion->perPage();
                            @endphp
                            @foreach($procesos_preparacion as $processs)
                                <tr>
                                    <td>{{ $contador++ }}</td>
                                    <td>{{ $processs->codigo }}</td>
                                    <td>{{ $processs->observacion }}</td>
                                    <td>{{ \Carbon\Carbon::parse($processs->fecha)->isoFormat('DD-MM-YYYY')}}</td>
                                    <td>{{ $processs->despacho->sabor }}</td>
                                    <td>{{ $processs->total_kg }}</td>
                                    <td>{{ $processs->disponible_kg }}</td>
                                    <td class="text-center text-bold" @if(!count($processs->detalle_proceso_preparacion) > 0)style="background: #f75959;color: #fff;" @endif>{{ count($processs->detalle_proceso_preparacion)}}</td>
                                    <td>
                                        @if ($processs->estado == 1)
                                            <span class="badge bg-warning">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="td-actions text-right">
                                        @if ($processs->estado == 1)
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cog"></i> Accion
                                                </button>
                                                <div class="dropdown-menu">
                                                        <a wire:click="open_modal_show_prep_proceso({{ $processs->id }})"
                                                            class="dropdown-item" data-placement="top"
                                                            title="Ver detalles">
                                                            <i class="fas fa-eye"></i> Ver Detalles
                                                        </a>
                                                        {{-- @can('crear_entrega_a_produccion') --}}
                                                        <a wire:click="open_modal_admin_prep_proceso({{ $processs->id }})"
                                                            class="dropdown-item" data-placement="top"
                                                            title="Ver detalles">
                                                            <i class="fas fa-bucket"></i> Adm. Baldes
                                                        </a>
                                                    {{-- @endcan --}}
                                                    <a wire:click.prevent="$emit('alerta', 'eliminar_proceso_preparacion', {{ $processs->id }})"
                                                        class="dropdown-item" data-placement="top"
                                                        title="Eliminar">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </a>
                                                </div>
                                            </div>
                                        @elseif($processs->estado == 0)
                                            <button class="btn-sm btn-dark" wire:click="restaurar_proceso_preparacion({{ $processs->id }})"><i class="fas fa-undo"></i> Restaurar </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $procesos_preparacion->links() }}
                </div>
            @else
                <p class="text-danger text-center">No hay registros.</p>
            @endif
        @endif

    </div>
</div>
