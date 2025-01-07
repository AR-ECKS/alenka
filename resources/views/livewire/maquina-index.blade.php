<div>
    <div class="float-right mt-3">
        <a type="button" class="btn btn-primary text-white" wire:click="open_modal_crear_maquina">
            <i class="fas fa-database"></i> Nueva Máquina
        </a>
    </div>

    <br><br><br>
    <div class="tab-content">
        @if($operation=='create_machine' || $operation=='edit_machine')
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">
                        @if($operation=='create_machine')
                            CREAR NUEVA MÁQUINA
                        @elseif($operation=='create_machine')
                            EDITAR MÁQUINA
                        @endif
                    </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_create_edit_machine"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="nombre">
                                        <i class="fas fa-lock pe-1"></i>
                                        <b>Nombre</b>
                                    </label>
                                </div>
                                <input class="form-control @error('nombre') border-danger @enderror" wire:model="nombre" id="nombre">
                            </div>
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="descripcion">
                                        <i class="fas fa-calendar pe-1"></i>
                                        <b>Descripción</b>
                                    </label>
                                </div>
                                <textarea class="form-control @error('descripcion') border-danger @enderror" id="descripcion" wire:model="descripcion"></textarea>
                                {{-- <input type="date" class="form-control" wire:model="fecha" id="fecha" disabled> --}}
                            </div>
                            @error('descripcion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            @error('id_maquina')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_create_edit_machine">CANCELAR</button>
                    <button type="button" class="btn btn-primary"
                        @if($operation=='create_machine')
                            wire:click="save_maquina"
                        @elseif($operation=='edit_machine')
                            wire:click="update_maquina"
                        @endif
                        >GUARDAR</button>
                </div>
            </div>
        {{-- @elseif($operation == 'admin_proccess_preparation')
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">ADMINISTRACIÓN DE LA PREPARACIÓN</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_admin_prep_proceso"></button>
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
                                <input type="number" class="form-control @error('kg_balde') border-danger @enderror" id="kg_balde" wire:model="kg_balde">
                                @error('kg_balde')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                                    <button type="button" class="btn btn-primary" wire:click="save_detalle_proceso_preparacion">GUARDAR</button>
                                    <button type="button" class="btn btn-danger" wire:click="restore_detalles_baldes">LIMPIAR</button>
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
                            @endif
                        </div>
                    @endif
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_admin_prep_proceso">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="">GUARDAR Y PROCESAR</button>
                </div>
            </div> --}}
        @endif

        @if(count($maquinas) > 0)
            <div class="table-responsive-xl">
                <table class="table table-sm text-sm table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $contador = ($maquinas->perPage() * $maquinas->currentPage()) + 1 - $maquinas->perPage();
                        @endphp
                        @foreach($maquinas as $maquin)
                            <tr>
                                <td>{{$contador++}}</td>
                                <td>{{ $maquin->nombre }}</td>
                                <td>{{ $maquin->descripcion }}</td>
                                <td>
                                    @if ($maquin->estado == 1)
                                        <span class="badge bg-warning">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td class="td-actions text-right">
                                    @if ($maquin->estado == 1)
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
                                                    <a wire:click="open_modal_editar_maquina({{ $maquin->id }})"
                                                        class="dropdown-item" data-placement="top"
                                                        title="Ver detalles">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                    <a wire:click.prevent="$emit('alerta', 'eliminar_maquina', {{ $maquin->id }})"
                                                        class="dropdown-item" data-placement="top"
                                                        title="Eliminar">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </a>
                                                {{-- @endcan --}}
                                            </div>
                                        </div>
                                    @elseif($maquin->estado == 0)
                                        <button class="btn-sm btn-dark" wire:click="restaurar_maquina({{ $maquin->id }})"><i class="fas fa-undo"></i> Restaurar </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $maquinas->links() }}
            </div>
        @else
            <p class="text-danger text-center">No hay registros de máquinas.</p>
        @endif
    </div>
</div>
