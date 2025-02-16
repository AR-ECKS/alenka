<div>
    @if($operation == '')
        <div class="float-right mt-3">
            <a type="button" class="btn btn-primary text-white" wire:click="open_modal_crear_producto">
                <i class="fas fa-database"></i> Nuevo Producto Envasado 
            </a>
        </div>
    @endif

    <br>
    <br>
    <br>

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

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="codigo">
                                        <i class="fas fa-weight-scale pe-1"></i>
                                        <b>Código </b>
                                    </label>
                                </div>
                                <input class="form-control @error('codigo') border-danger @enderror" type="text" wire:model="codigo" id="codigo" disabled>
                            </div>
                            @error('codigo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="fecha">
                                        <i class="fas fa-weight-scale pe-1"></i>
                                        <b>Fecha </b>
                                    </label>
                                </div>
                                <input class="form-control @error('fecha') border-danger @enderror" type="date" wire:model="fecha" id="fecha">
                            </div>
                            @error('fecha')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend" for="maquina_id">
                                    <label class="input-group-text">
                                        <i class="fas fa-user pe-1"></i>
                                        <b>Máquina</b>
                                    </label>
                                    <button class="btn btn-success" wire:click="rellenar_sugerido">
                                        <i class="fas fa-square"></i>
                                    </button>
                                </div>
                                <select class="form-control @error('maquina_id') border-danger @enderror" id="maquina_id" wire:model="maquina_id">
                                    <option value="">Seleccione maquina</option>
                                    @foreach ($maquinas as $maq)
                                        <option value="{{$maq->id}}">{{ $maq->nombre }} .:: {{$maq->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('maquina_id')
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
                                <label class="input-group-prepend" for="nombre">
                                    <div class="input-group-text">
                                        <i class="fas fa-user pe-1"></i>
                                        <b>Nombre</b>
                                    </div>
                                </label>
                                <select class="form-control @error('nombre') border-danger @enderror" id="nombre" wire:model="nombre">
                                    <option value="">Sin operador</option>
                                    @foreach ($usuarios as $us)
                                        <option value="{{$us->id}}">{{ $us->username }} .:: {{$us->email}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="observaciones">
                                        <i class="fas fa-triangle-exclamation pe-1"></i>
                                        <b>Observación</b>
                                    </label>
                                </div>
                                <textarea class="form-control @error('observaciones') border-danger @enderror" wire:model="observaciones" id="observaciones"></textarea>
                            </div>
                            @error('observaciones')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_crear_producto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="save_modal_crear_producto">GUARDAR</button>
                </div>
            </div>
        @elseif($operation=='edit_baldes')
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">
                        EDITAR BALDES
                    </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_editar_balde"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        @include('livewire.extras.details-producto_envasado', ['detalle_producto_envasado' => $producto_envasado_balde])

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="balde_saldo_anterior">
                                        <i class="fas fa-clock pe-1"></i>
                                        <b>Balde anterior</b>
                                    </label>
                                </div>
                                <select class="form-control @error('balde_saldo_anterior') border-danger @enderror" id="balde_saldo_anterior" wire:model="balde_saldo_anterior">
                                    <option value="">Seleccione balde anterior</option>
                                    @foreach ($baldes_anteriores as $bal_ant)
                                        <option value="{{$bal_ant->id}}">{{ $bal_ant->fecha }}.:: {{ $bal_ant->nombre/* maquina->nombre */ }} .:: {{ $bal_ant->balde_sobro_del_dia }} kg</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('balde_saldo_anterior')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <label class="input-group-prepend" for="balde_cambio_de_maquina">
                                    <div class="input-group-text">
                                        <i class="fas fa-user pe-1"></i>
                                        <b>Cambio de máquina</b>
                                    </div>
                                </label>
                                <select class="form-control @error('balde_cambio_de_maquina') border-danger @enderror" id="balde_cambio_de_maquina" wire:model="balde_cambio_de_maquina">
                                    <option value="">Seleccione maquina</option>
                                    {{-- @foreach ($usuarios as $us)
                                        <option value="{{$us->id}}">{{ $us->username }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            @error('balde_cambio_de_maquina')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="balde_entrada_de_molino">
                                        <i class="fas fa-weight-scale pe-1"></i>
                                        <b>Entrada de molino (cantidad)</b>
                                    </label>
                                </div>
                                <input class="form-control @error('balde_entrada_de_molino') border-danger @enderror" type="number" wire:model="balde_entrada_de_molino" id="balde_entrada_de_molino" disabled>
                            </div>
                            @error('balde_entrada_de_molino')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="balde_sobro_del_dia">
                                        <i class="fas fa-weight-scale pe-1"></i>
                                        <b>Sobro del día (cantidad)</b>
                                    </label>
                                </div>
                                <input class="form-control @error('balde_sobro_del_dia') border-danger @enderror" type="number" wire:model="balde_sobro_del_dia" id="balde_sobro_del_dia">
                            </div>
                            @error('balde_sobro_del_dia')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="balde_observacion">
                                        <i class="fas fa-triangle-exclamation pe-1"></i>
                                        <b>Observación</b>
                                    </label>
                                </div>
                                <textarea class="form-control @error('balde_observacion') border-danger @enderror" wire:model="balde_observacion" id="balde_observacion"></textarea>
                            </div>
                            @error('balde_observacion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="balde_salida_molino_id">
                                        <i class="fas fa-clock pe-1"></i>
                                        <b>Salida de molino</b>
                                    </label>
                                </div>
                                <select class="form-control @error('balde_salida_molino_id') border-danger @enderror" id="balde_salida_molino_id" wire:model="balde_salida_molino_id" title="codigo .:: fecha .:: turno .:: cantidad de baldes .:: kg. totales .:: observacion">
                                    <option value="">seleccionar</option>
                                    @foreach ($salidas_molinos as $sal_mol)
                                        <option value="{{$sal_mol->id}}">{{ $sal_mol->codigo }} .:: {{ $sal_mol->fecha }} .:: {{ $sal_mol->turno }} .:: {{ $sal_mol->cantidad }} baldes .:: {{ round($sal_mol->kgs, 2)}} kg. .:: {{ $sal_mol->observacion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('balde_salida_molino_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary" wire:click="agregar_salida_molino" title="Agregar salida de molino">
                                AGREGAR
                            </button>
                        </div>

                        <div class="col-md-6">
                            @if(count($current_salidas_molinos) > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm text-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Código</th>
                                                <th>Turno</th>
                                                <th>Baldes</th>
                                                <th>Kg totales</th>
                                                <th>Observaciones</th>
                                                <th class="text-right">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($current_salidas_molinos as $salda_mol)
                                                <tr>
                                                    <td>{{ $salda_mol->fecha }}</td>
                                                    <td>{{ $salda_mol->codigo }}</td>
                                                    <td>{{ $salda_mol->turno }}</td>
                                                    <td>{{ count($salda_mol->detalle_salida_molinos) }}</td>
                                                    <td>{{ $salda_mol->total_aprox }}</td>
                                                    {{-- <td>{{ $salda_mol->recepcionista->username }}</td> --}}
                                                    <td>{{ $salda_mol->observacion }}</td>
                                                    <td>
                                                        <button wire:click.prevent="$emit('alerta', 'quitar_salida_molino', {{ $salda_mol->id }})"
                                                            class="btn btn-danger" title="Quitar salida de molino" >
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-danger text-center">No hay registros</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_editar_balde">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="save_modal_editar_balde">GUARDAR</button>
                </div>
            </div>
        @elseif($operation=='edit_cajas')
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">
                        EDITAR CAJAS
                    </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_editar_caja"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        @include('livewire.extras.details-producto_envasado', ['detalle_producto_envasado' => $producto_envasado_caja])

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="caja_cajas">
                                        <i class="fas fa-clock pe-1"></i>
                                        <b>Salida de Cajas</b>
                                    </label>
                                </div>
                                <input class="form-control @error('caja_cajas') border-danger @enderror" type="number" wire:model="caja_cajas" id="caja_cajas">
                            </div>
                            @error('caja_cajas')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="caja_bolsas">
                                        <i class="fas fa-clock pe-1"></i>
                                        <b>Salida de bolsas</b>
                                    </label>
                                </div>
                                <input class="form-control @error('caja_bolsas') border-danger @enderror" type="number" wire:model="caja_bolsas" id="caja_bolsas">
                            </div>
                            @error('caja_bolsas')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="caja_observacion">
                                        <i class="fas fa-triangle-exclamation pe-1"></i>
                                        <b>Observación</b>
                                    </label>
                                </div>
                                <textarea class="form-control @error('caja_observacion') border-danger @enderror" wire:model="caja_observacion" id="caja_observacion"></textarea>
                            </div>
                            @error('caja_observacion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_editar_caja">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="save_modal_editar_caja">GUARDAR</button>
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
            </div>
    
            @if(count($productos_envasados) > 0)
                <div class="table-responsive-xl">
                    <table class="table table-sm text-sm table-striped">
                        <thead>
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2" class="text-center border-right">Fecha</th>
                                <th rowspan="2">Máquina</th>
                                <th rowspan="2">Nombre</th>
                                <th rowspan="2">Sabor</th>
                                <th colspan="4" class="text-center border-left border-right">Baldes</th>
                                <th colspan="2" class="text-center border-left border-right">Cajas</th>
                                <th colspan="3" class="text-center border-left border-right">Salidas o cambio</th>
                                <th colspan="3" class="text-center border-left border-right">Bobinas</th>
                                <th>Observaciones</th>
                                <th>Estado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                            <tr>
                                <th class="border-left">Saldo Anterior</th>
                                <th>Cambio de Máquina</th>
                                <th>Entrada de molino</th>
                                <th class="border-right">Sobro del día</th>
                                
                                <th class="border-left">Cajas</th>
                                <th class="border-right">Bolsas</th>
    
                                <th class="border-left">Cajas</th>
                                <th>Bolsas</th>
                                <th  class="border-right">Firma</th>
    
                                <th class="border-left">Ingreso</th>
                                <th>Mal estado</th>
                                <th class="border-right">Sobrantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador = ($productos_envasados->perPage() * $productos_envasados->currentPage()) + 1 - $productos_envasados->perPage();
                            @endphp
                            @foreach($productos_envasados as $prod_env)
                                <tr @if($prod_env->estado == 1) style="background: #fff988" @endif>
                                    <th>{{$contador++}}</th>
                                    <td class="border-right">{{$prod_env->fecha}}</td>
                                    <td>{{$prod_env->maquina->nombre}}</td>
                                    <td>{{is_null($prod_env->encargado)? 'SIN OPERADOR': $prod_env->encargado->username}}</td>
                                    <td>{{$prod_env->sabor}}</td>
    
                                    <td class="border-left">{{is_null($prod_env->balde_saldo_anterior)? '-': $prod_env->producto_saldo_anterior->balde_sobro_del_dia}}</td>
                                    <td></td>
                                    <td>
                                        @php 
                                            $total_baldes = 0;
                                            foreach ($prod_env->salidas_de_molino as $sal_mol ) {
                                                $total_baldes += count($sal_mol->detalle_salida_molinos);
                                            }
                                        @endphp
                                        @if(count($prod_env->salidas_de_molino) > 0)
                                            {{ $total_baldes }}
                                        @else 
                                            <span class="text-danger" style="font-size: 9px">Sin asignar</span>
                                        @endif
                                        {{--$prod_env->balde_entrada_de_molino--}}
                                    </td>
                                    <td class="border-right">{{is_null($prod_env->balde_sobro_del_dia)? '-': $prod_env->balde_sobro_del_dia}}</td>
    
                                    <td class="border-left">{{$prod_env->caja_cajas}}</td>
                                    <td class="border-right">{{$prod_env->caja_bolsas}}</td>
    
                                    <td class="border-left">{{-- {{$prod_env->sabor}} --}}</td>
                                    <td></td>
                                    <td class="border-right">{{-- {{$prod_env->sabor}} --}}</td>
    
                                    <td class="border-left">{{-- {{$prod_env->sabor}} --}}</td>
                                    <td></td>
                                    <td class="border-right">{{-- {{$prod_env->sabor}} --}}</td>
    
                                    <td>{{$prod_env->observacion}}</td>
                                    <td>
                                        @if($prod_env->estado == 1)
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($prod_env->estado == 2)
                                            <span class="badge bg-success">Activo</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($prod_env->estado == 1 || $prod_env->estado==2)
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cog"></i> Acción
                                                </button>
                                                <div class="dropdown-menu">
                                                       {{--  <a wire:click="show_proceso"
                                                            class="dropdown-item" data-placement="top"
                                                            title="Ver detalles">
                                                            <i class="fas fa-eye"></i> Ver Detalles
                                                        </a> --}}
                                                        {{-- @can('crear_entrega_a_produccion') --}}
                                                        @if($prod_env->estado == 1)
                                                            <a wire:click="open_modal_editar_baldes({{ $prod_env->id }})"
                                                                class="dropdown-item" data-placement="top"
                                                                title="Editar {{ $prod_env->codigo }}">
                                                                <i class="fas fa-edit"></i> Editar Baldes
                                                            </a>
                                                            <a wire:click="open_modal_editar_caja({{ $prod_env->id }})"
                                                                class="dropdown-item" data-placement="top"
                                                                title="Editar {{ $prod_env->codigo }}">
                                                                <i class="fas fa-edit"></i> Editar Cajas
                                                            </a>
                                                            {{-- <a wire:click="open_modal_editar_salida_mol({{ $prod_env->id }})"
                                                                class="dropdown-item" data-placement="top"
                                                                title="Editar {{ $prod_env->codigo }}">
                                                                <i class="fas fa-edit"></i> Editar Salidas o cambios
                                                            </a>
                                                            <a wire:click="open_modal_editar_salida_mol({{ $prod_env->id }})"
                                                                class="dropdown-item" data-placement="top"
                                                                title="Editar {{ $prod_env->codigo }}">
                                                                <i class="fas fa-edit"></i> Editar Bobinas
                                                            </a> --}}
    
                                                            @php
                                                                # validar
                                                                # color verde = que la validacion ha sido existosa
                                                                # color rojo  = que no puede pasar al siguiente estado
                                                                $saldo_anterior = 0;
                                                                $total_baldes = 0;
                                                                $prod_saldo_anterior = $prod_env->producto_saldo_anterior;
                                                                if($prod_saldo_anterior){
                                                                    $saldo_anterior = $prod_saldo_anterior->balde_sobro_del_dia;
                                                                }
                                                                $total_baldes = round($saldo_anterior + $prod_env->balde_entrada_de_molino, 2);
                                                                $error_baldes = true;
                                                                $error_cajas = true;
                                                                if(round($prod_env->balde_sobro_del_dia, 2) == $total_baldes && is_null($prod_env->caja_cajas) && is_null($prod_env->caja_bolsas) ){
                                                                    $error_baldes = false;
                                                                    $error_cajas = false;
                                                                }
                                                                if($error_baldes && (!is_null($prod_env->caja_cajas) || !is_null($prod_env->caja_bolsas))){
                                                                    $error_cajas = false;
                                                                    $error_baldes = false;
                                                                }
                                                            @endphp
                                                            <a @if(!$error_baldes && !$error_cajas)wire:click="confirmar_producto_envasado({{ $prod_env->id }})" @endif
                                                                class="dropdown-item @if($error_baldes || $error_cajas) bg-danger @else bg-success @endif" data-placement="top"
                                                                title="@if($error_baldes) ERROR: En caso de que este vacio cajas y bolsas, debe coincidir (saldo_anterior + entrada_molino) con sobro_del_dia @endif \n
                                                                        @if($error_cajas) ERROR: Debe llenar  @endif">
                                                                <i class="fas fa-edit"></i> Confirmar Registro
                                                            </a>
                                                        @else 
                                                            <a wire:click="cambiar_estado({{ $prod_env->id }})"
                                                                class="dropdown-item " data-placement="top"
                                                                title="cambiar estado">
                                                                <i class="fas fa-edit"></i> Cambiar estado
                                                            </a>
                                                        @endif
    
                                                        {{-- <a wire:click.prevent="$emit('alerta', 'eliminar_maquina', {{ $prod_env->id }})"
                                                            class="dropdown-item" data-placement="top"
                                                            title="Eliminar">
                                                            <i class="fas fa-trash"></i> Eliminar
                                                        </a> --}}
                                                    {{-- @endcan --}}
                                                </div>
                                            </div>
                                        @elseif($prod_env->estado == 0)
                                            <button class="btn-sm btn-dark" wire:click="restaurar_maquina({{ $prod_env->id }})"><i class="fas fa-undo"></i> Restaurar </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $productos_envasados->links() }}
                </div>
            @else
                <p class="text-danger text-center">No hay registros de salidas.</p>
            @endif
        @endif
        

        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Launch demo modal
          </button>
          
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  ...
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div> --}}
    </div>
</div>
