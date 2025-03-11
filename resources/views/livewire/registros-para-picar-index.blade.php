<div>
    <div class="float-right mt-3">
        @if($operation == '')
            <a type="button" class="btn btn-primary text-white" wire:click="open_modal_create_picar">
                <i class="fas fa-database"></i> Nuevo registro para picar
            </a>
        @endif
    </div>

    <br><br><br>
    <div class="tab-content">
        @if($operation=='create_registro_picar')
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">NUEVA REGISTRO PARA PICAR</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_create_picar"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
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

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <label class="input-group-prepend" for="sabor">
                                    <div class="input-group-text">
                                        <i class="fas fa-user pe-1"></i>
                                        <b>Sabor</b>
                                    </div>
                                </label>
                                <select class="form-control @error('sabor') border-danger @enderror" id="sabor" wire:model="sabor">
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

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <label class="input-group-prepend" for="encargado_id">
                                    <div class="input-group-text">
                                        <i class="fas fa-user pe-1"></i>
                                        <b>Encargado</b>
                                    </div>
                                </label>
                                <select class="form-control @error('encargado_id') border-danger @enderror" id="encargado_id" wire:model="encargado_id" disabled>
                                    <option value="">Seleccione usuario</option>
                                    @foreach ($usuarios as $user)
                                        <option value="{{$user->id}}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('encargado_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="fecha_inicio">
                                        <i class="fas fa-calendar pe-1"></i>
                                        <b>Fecha de inicio</b>
                                    </label>
                                </div>
                                <input type="date" class="form-control @error('fecha_inicio') border-danger @enderror" wire:model="fecha_inicio" id="fecha_inicio">
                            </div>
                            @error('fecha_inicio')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="fecha_fin">
                                        <i class="fas fa-calendar pe-1"></i>
                                        <b>Límite de Fecha</b>
                                    </label>
                                </div>
                                <input type="date" class="form-control @error('fecha_fin') border-danger @enderror" wire:model="fecha_fin" id="fecha_fin">
                            </div>
                            @error('fecha_fin')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <b>Desde:</b> 
                            @if(!$errors->has('fecha_inicio'))
                                {{ \Carbon\Carbon::parse($fecha_inicio)->locale('es')->isoFormat('dddd, D \d\e MMMM \d\e\l YYYY') }}
                            @endif
                            <br>
                            <b>Hasta:</b>
                            @if(!$errors->has('fecha_fin'))
                                {{ \Carbon\Carbon::parse($fecha_fin)->locale('es')->isoFormat('dddd, D \d\e MMMM \d\e\l YYYY') }}
                            @endif
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
                    <button type="button" class="btn btn-danger" wire:click="close_modal_create_picar">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="save_modal_create_picar">GUARDAR</button>
                </div>
            </div>
        @elseif($operation=='edit_registro_picar')
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">EDITAR REGISTRO PARA PICAR</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_edit_picar"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="edit_codigo">
                                        <i class="fas fa-lock pe-1"></i>
                                        <b>Código</b>
                                    </label>
                                </div>
                                <input class="form-control" wire:model="edit_codigo" id="edit_codigo" disabled>
                            </div>
                            @error('edit_codigo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <label class="input-group-prepend" for="edit_sabor">
                                    <div class="input-group-text">
                                        <i class="fas fa-user pe-1"></i>
                                        <b>Sabor</b>
                                    </div>
                                </label>
                                <select class="form-control @error('edit_sabor') border-danger @enderror" id="edit_sabor" wire:model="edit_sabor" @if(count($edit_registro_para_picar->detalle_registros_para_picar) > 0) disabled @endif>
                                    <option value="">Seleccione sabor</option>
                                    @foreach ($LISTA_DE_SABORES as $sab)
                                        <option value="{{$sab}}">{{ $sab }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('edit_sabor')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <label class="input-group-prepend" for="edit_encargado_id">
                                    <div class="input-group-text">
                                        <i class="fas fa-user pe-1"></i>
                                        <b>Encargado</b>
                                    </div>
                                </label>
                                <select class="form-control @error('edit_encargado_id') border-danger @enderror" id="edit_encargado_id" wire:model="edit_encargado_id" disabled>
                                    <option value="">Seleccione usuario</option>
                                    @foreach ($usuarios as $user)
                                        <option value="{{$user->id}}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('edit_encargado_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="edit_fecha_inicio">
                                        <i class="fas fa-calendar pe-1"></i>
                                        <b>Fecha de inicio</b>
                                    </label>
                                </div>
                                <input type="date" class="form-control @error('edit_fecha_inicio') border-danger @enderror" wire:model="edit_fecha_inicio" id="edit_fecha_inicio" @if(count($edit_registro_para_picar->detalle_registros_para_picar) > 0) disabled @endif>
                            </div>
                            @error('edit_fecha_inicio')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="edit_fecha_fin">
                                        <i class="fas fa-calendar pe-1"></i>
                                        <b>Límite de Fecha</b>
                                    </label>
                                </div>
                                <input type="date" class="form-control @error('edit_fecha_fin') border-danger @enderror" wire:model="edit_fecha_fin" id="edit_fecha_fin" @if(count($edit_registro_para_picar->detalle_registros_para_picar) > 0) disabled @endif>
                            </div>
                            @error('edit_fecha_fin')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <b>Desde:</b> 
                            @if(!$errors->has('edit_fecha_inicio'))
                                {{ \Carbon\Carbon::parse($edit_fecha_inicio)->locale('es')->isoFormat('dddd, D \d\e MMMM \d\e\l YYYY') }}
                            @endif
                            <br>
                            <b>Hasta:</b>
                            @if(!$errors->has('edit_fecha_fin'))
                                {{ \Carbon\Carbon::parse($edit_fecha_fin)->locale('es')->isoFormat('dddd, D \d\e MMMM \d\e\l YYYY') }}
                            @endif
                        </div>

                        <div class="col-md-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="edit_observacion">
                                        <i class="fas fa-weight pe-1"></i>
                                        <b>Observación</b>
                                    </label>
                                </div>
                                <input type="text" class="form-control @error('edit_observacion') border-danger @enderror" wire:model="edit_observacion" id="edit_observacion">
                            </div>
                            @error('edit_observacion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_edit_picar">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="save_modal_edit_picar">ACTUALIZAR</button>
                </div>
            </div>
        @elseif($operation == 'adm_para_picar')
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">ADMINISTRADOR PARA PICAR</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_para_picar_adm"></button>
                </div>
                <div class="modal-body">
                    @if($para_picar_adm)
                        <div class="mb-1">
                            <button class="btn btn-primary text-white" wire:click="open_modal_create_detalle_para_picar">
                                <i class="fas fa-database"></i> Agregar nuevo registro
                            </button>
                        </div>
                        <div>
                            @if(count($registros_detalles_para_picar) > 0)
                                <div class="table-responsive-xl">
                                    <table class="table table-sm text-sm table-striped">
                                        <thead class="text-center">
                                            <tr>
                                                <th rowspan="2" class="border-right">Nro</th>
                                                <th colspan="5" class="border-right">Detalles de Productos envasados</th>
                                                <th colspan="3" class="border-right">Para Picar</th>
                                                <th rowspan="2" >Acciones</th>
                                            </tr>
                                            <tr>
                                                <th>Codigo de Produccion</th>
                                                <th>Fecha</th>
                                                <th>Maquina</th>
                                                <th>Nombre</th>
                                                <th class="border-right" style="max-width: 100px;">Observación</th>
                                                
                                                <th>Kg.</th>
                                                <th>Nro bolsitas</th>
                                                <th class="border-right" style="max-width: 100px;">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $anter = 1; @endphp
                                            @foreach($registros_detalles_para_picar as $det_pic)
                                                <tr>
                                                    <th class="border-right">{{ $anter++ }}</th>

                                                    <td>{{$det_pic->producto_envasado->codigo}}</td>
                                                    <td>{{$det_pic->producto_envasado->fecha}}</td>
                                                    <td>{{$det_pic->producto_envasado->maquina->nombre}}</td>
                                                    <td>
                                                        @if($det_pic->producto_envasado->encargado)
                                                            {{$det_pic->producto_envasado->encargado->username}}
                                                        @else
                                                            <span class="text-danger">SIN OPERADOR</span>
                                                        @endif
                                                    </td>
                                                    <td class="border-right" style="max-width: 100px;">{{$det_pic->producto_envasado->observacion}}</td>

                                                    <td class="text-center">{{$det_pic->producto_envasado->para_picar_kg_de_bolsitas}} kg.</td>
                                                    <td class="text-center">{{$det_pic->producto_envasado->para_picar_nro_de_bolsitas}}</td>
                                                    <td class="border-right" style="max-width: 100px;">{{$det_pic->observacion}}</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-primary" title="Editar"  wire:click="open_modal_edit_detalle_para_picar({{ $det_pic->id }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger" title="Eliminar" wire:click.prevent="$emit('alerta', 'eliminar_detalle_registr_para_picar', {{ $det_pic->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <span class="text-danger">NO HAY DATOS</span>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_para_picar_adm">VOLVER</button>
                </div>
            </div>
        @elseif($operation == 'adm_para_picar_create')
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">AGREGAR NUEVO PARA PICAR</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_create_detalle_para_picar"></button>
                </div>
                <div class="modal-body">
                    @if($para_picar_adm)
                        <div class="row">
                            <div class="col-md-8 row">
                                <div class="col-md-4">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">
                                                <i class="fas fa-lock pe-1"></i>
                                                <b>Sabor</b>
                                            </label>
                                        </div>
                                        <span class="form-control">{{$para_picar_adm->sabor}}</span>
                                    </div>
                                </div>
    
                                <div class="col-md-8">
                                    <div class="input-group mb-2">
                                        <label class="input-group-prepend" for="detalle_reg_prod_envasado_id">
                                            <div class="input-group-text">
                                                <i class="fas fa-user pe-1"></i>
                                                <b>Producto envasado</b>
                                            </div>
                                        </label>
                                        <select class="form-control @error('detalle_reg_prod_envasado_id') border-danger @enderror" id="detalle_reg_prod_envasado_id" wire:model="detalle_reg_prod_envasado_id">
                                            <option value="">Seleccione ...</option>
                                            @foreach ($lista_disponibles_productos_envasados as $pro_env)
                                                <option value="{{$pro_env->id}}">{{ $pro_env->codigo }} .::. {{ $pro_env->fecha }} .::. {{ $pro_env->maquina->nombre }} .::. {{ $pro_env->encargado? $pro_env->encargado->username: 'SIN OPERADOR' }} .::. {{ $pro_env->para_picar_kg_de_bolsitas }} kg. .::. {{ $pro_env->para_picar_nro_de_bolsitas }} bolsitas</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('detalle_reg_prod_envasado_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
    
                                <div class="col-md-12">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="detalle_reg_observacion">
                                                <i class="fas fa-weight pe-1"></i>
                                                <b>Observación</b>
                                            </label>
                                        </div>
                                        <input type="text" class="form-control @error('detalle_reg_observacion') border-danger @enderror" wire:model="detalle_reg_observacion" id="detalle_reg_observacion">
                                    </div>
                                    @error('detalle_reg_observacion')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5 class="text-center">Detalles de Producto envasado</h5>
                                @if($detalle_reg_show_prod_env && !$errors->has('detalle_reg_prod_envasado_id'))
                                    <div class="row">
                                        <div class="col-md-6"><b>Codigo:</b> {{ $detalle_reg_show_prod_env->codigo }}</div>
                                        <div class="col-md-6"><b>Sabor:</b> {{ $detalle_reg_show_prod_env->sabor }}</div>

                                        <div class="col-md-6"><b>Máquina:</b> {{ $detalle_reg_show_prod_env->maquina->nombre }}</div>
                                        <div class="col-md-6"><b>Fecha:</b> {{ $detalle_reg_show_prod_env->fecha }}</div>

                                        <div class="col-md-6"><b>Nombre:</b> {{ $detalle_reg_show_prod_env->encargado? $detalle_reg_show_prod_env->encargado->username: 'SIN OPERADOR' }}</div>
                                        <div class="col-md-6"><b>Picar:</b> {{ $detalle_reg_show_prod_env->para_picar_kg_de_bolsitas }} kg. ({{ $detalle_reg_show_prod_env->para_picar_nro_de_bolsitas }} bolsitas)</div>

                                        <div class="col-md-12 row">
                                            <div class="col-4 text-center" title="Saldo anterior">{{ $detalle_reg_show_prod_env->producto_saldo_anterior? $detalle_reg_show_prod_env->producto_saldo_anterior->balde_sobro_del_dia: '-' }}</div>
                                            <div class="col-4 text-center" title="Entrada de molino">{{ $detalle_reg_show_prod_env->salidas_de_molino? $detalle_reg_show_prod_env->entrada_cantidad_de_baldes: '-' }}</div>
                                            <div class="col-4 text-center" title="Sobro del día">{{ $detalle_reg_show_prod_env->balde_sobro_del_dia? $detalle_reg_show_prod_env->balde_sobro_del_dia: '-' }}</div>
                                        </div>

                                        <div class="col-md-12"><b>Observacion:</b></div>

                                    </div>
                                @else
                                    <span class="text-danger">No hay datos</span>
                                @endif
                            </div>

                        </div>
                    @endif
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_create_detalle_para_picar">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="save_modal_create_detalle_para_picar">GUARDAR</button>
                </div>
            </div>
        @elseif($operation=="adm_para_picar_edit")
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">EDITAR PARA PICAR</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_edit_detalle_para_picar"></button>
                </div>
                <div class="modal-body">
                    @if($para_picar_adm)
                        <div class="row">
                            <div class="col-md-8 row">
                                <div class="col-md-4">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">
                                                <i class="fas fa-lock pe-1"></i>
                                                <b>Sabor</b>
                                            </label>
                                        </div>
                                        <span class="form-control">{{$para_picar_adm->sabor}}</span>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="input-group mb-2">
                                        <label class="input-group-prepend" for="edit_detalle_reg_prod_envasado_id">
                                            <div class="input-group-text">
                                                <i class="fas fa-user pe-1"></i>
                                                <b>Producto envasado</b>
                                            </div>
                                        </label>
                                        <select class="form-control @error('edit_detalle_reg_prod_envasado_id') border-danger @enderror" id="edit_detalle_reg_prod_envasado_id" wire:model="edit_detalle_reg_prod_envasado_id">
                                            <option value="">Seleccione ...</option>
                                            @foreach ($lista_disponibles_productos_envasados as $pro_env)
                                                <option value="{{$pro_env->id}}">{{ $pro_env->codigo }} .::. {{ $pro_env->fecha }} .::. {{ $pro_env->maquina->nombre }} .::. {{ $pro_env->encargado? $pro_env->encargado->username: 'SIN OPERADOR' }} .::. {{ $pro_env->para_picar_kg_de_bolsitas }} kg. .::. {{ $pro_env->para_picar_nro_de_bolsitas }} bolsitas</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('edit_detalle_reg_prod_envasado_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="edit_detalle_reg_observacion">
                                                <i class="fas fa-weight pe-1"></i>
                                                <b>Observación</b>
                                            </label>
                                        </div>
                                        <input type="text" class="form-control @error('edit_detalle_reg_observacion') border-danger @enderror" wire:model="edit_detalle_reg_observacion" id="edit_detalle_reg_observacion">
                                    </div>
                                    @error('edit_detalle_reg_observacion')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5 class="text-center">Detalles de Producto envasado</h5>
                                @if($edit_detalle_reg_show_prod_env && !$errors->has('edit_detalle_reg_prod_envasado_id'))
                                    <div class="row">
                                        <div class="col-md-6"><b>Codigo:</b> {{ $edit_detalle_reg_show_prod_env->codigo }}</div>
                                        <div class="col-md-6"><b>Sabor:</b> {{ $edit_detalle_reg_show_prod_env->sabor }}</div>

                                        <div class="col-md-6"><b>Máquina:</b> {{ $edit_detalle_reg_show_prod_env->maquina->nombre }}</div>
                                        <div class="col-md-6"><b>Fecha:</b> {{ $edit_detalle_reg_show_prod_env->fecha }}</div>

                                        <div class="col-md-6"><b>Nombre:</b> {{ $edit_detalle_reg_show_prod_env->encargado? $edit_detalle_reg_show_prod_env->encargado->username: 'SIN OPERADOR' }}</div>
                                        <div class="col-md-6"><b>Picar:</b> {{ $edit_detalle_reg_show_prod_env->para_picar_kg_de_bolsitas }} kg. ({{ $edit_detalle_reg_show_prod_env->para_picar_nro_de_bolsitas }} bolsitas)</div>

                                        <div class="col-md-12 row">
                                            <div class="col-4 text-center" title="Saldo anterior">{{ $edit_detalle_reg_show_prod_env->producto_saldo_anterior? $edit_detalle_reg_show_prod_env->producto_saldo_anterior->balde_sobro_del_dia: '-' }}</div>
                                            <div class="col-4 text-center" title="Entrada de molino">{{ $edit_detalle_reg_show_prod_env->salidas_de_molino? $edit_detalle_reg_show_prod_env->entrada_cantidad_de_baldes: '-' }}</div>
                                            <div class="col-4 text-center" title="Sobro del día">{{ $edit_detalle_reg_show_prod_env->balde_sobro_del_dia? $edit_detalle_reg_show_prod_env->balde_sobro_del_dia: '-' }}</div>
                                        </div>

                                        <div class="col-md-12"><b>Observacion:</b></div>

                                    </div>
                                @else
                                    <span class="text-danger">No hay datos</span>
                                @endif
                            </div>

                        </div>
                    @endif
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_edit_detalle_para_picar">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="save_modal_edit_detalle_para_picar++++">ACTUALIZAR</button>
                </div>
            </div>
        @else
            @if(count($registros_para_picar) > 0)
                <div class="table-responsive-xl">
                    <table class="table table-sm text-sm table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Codigo</th>
                                <th>Sabor</th>
                                <th>Encargado</th>
                                <th>Fecha de inicio</th>
                                <th>Fecha límite</th>
                                <th>Bolsitas</th>
                                <th>Observaciones</th>
                                <th>Estado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador = ($registros_para_picar->perPage() * $registros_para_picar->currentPage()) + 1 - $registros_para_picar->perPage();
                            @endphp
                            @foreach($registros_para_picar as $reg_para_picar)
                                <tr>
                                    <td>{{ $contador++ }}</td>
                                    <td>{{ $reg_para_picar->codigo }}</td>
                                    <td>{{ $reg_para_picar->sabor }}</td>
                                    <td>
                                        @if($reg_para_picar->encargado)
                                            {{ $reg_para_picar->encargado->username }}
                                        @else
                                            <span class="text-danger">No asignado</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($reg_para_picar->fecha_inicio)->isoFormat('DD-MM-YYYY')}} <br>
                                        {{ \Carbon\Carbon::parse($reg_para_picar->fecha_inicio)->locale('es')->isoFormat('dddd, D \d\e MMMM \d\e\l YYYY') }}
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($reg_para_picar->fecha_fin)->isoFormat('DD-MM-YYYY')}} <br>
                                        {{ \Carbon\Carbon::parse($reg_para_picar->fecha_fin)->locale('es')->isoFormat('dddd, D \d\e MMMM \d\e\l YYYY') }}
                                    </td>
                                    <td>
                                        {{ $reg_para_picar->cantidad_bolsitas }} <span class="text-primary">({{ $reg_para_picar->cantidad_kg }} kg)</span>
                                    </td>
                                    <td>{{ $reg_para_picar->observacion }}</td>
                                    <td>
                                        @if ($reg_para_picar->estado == 1)
                                            <span class="badge bg-warning">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="td-actions text-right">
                                        @if ($reg_para_picar->estado == 1)
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cog"></i> Accion
                                                </button>
                                                <div class="dropdown-menu">
                                                        <a wire:click="open_modal_show_prep_proceso({{ $reg_para_picar->id }})"
                                                            class="dropdown-item" data-placement="top"
                                                            title="Ver detalles">
                                                            <i class="fas fa-eye"></i> Ver Detalles
                                                        </a>
                                                        <a wire:click="open_modal_edit_picar({{ $reg_para_picar->id }})"
                                                            class="dropdown-item" data-placement="top"
                                                            title="Editar">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </a>
                                                        {{-- @can('crear_entrega_a_produccion') --}}
                                                        <a wire:click="open_modal_para_picar_adm({{ $reg_para_picar->id }})"
                                                            class="dropdown-item" data-placement="top"
                                                            title="Ver detalles">
                                                            <i class="fas fa-bucket"></i> Administrador para picar
                                                        </a>
                                                    {{-- @endcan --}}
                                                    @if(count($reg_para_picar->detalle_registros_para_picar) == 0)
                                                        <a wire:click.prevent="$emit('alerta', 'eliminar_registro_para_picar', {{ $reg_para_picar->id }})"
                                                            class="dropdown-item" data-placement="top"
                                                            title="Eliminar">
                                                            <i class="fas fa-trash"></i> Eliminar
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif($reg_para_picar->estado == 0)
                                            <button class="btn-sm btn-dark" wire:click="restaurar_proceso_preparacion({{ $reg_para_picar->id }})"><i class="fas fa-undo"></i> Restaurar </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $registros_para_picar->links() }}
                </div>
            @else
                <p class="text-danger text-center">No hay registros.</p>
            @endif
        @endif

    </div>
</div>
