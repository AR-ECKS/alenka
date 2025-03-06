<div>
    <div class="float-right mt-3">
        @if($operation == '')
            <a type="button" class="btn btn-primary text-white" wire:click="open_modal_crear_salida_mol">
                <i class="fas fa-database"></i> Nueva Salida de Molino / Entrega a producción
            </a>
        @endif
    </div>

    <br><br><br>
    <div class="tab-content">
        @if($operation=='create_salida_molino')
            <div class="card-body ">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">
                        ENTREGA A PRODUCCIÓN
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
                                <input class="form-control @error('fecha') border-danger @enderror" type="date" wire:model="fecha" id="fecha" wire:change="on_change_sabor" {{-- disabled --}}>
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
                                        <option value="{{$prep_balde['id_det_preparacion']}}">{{ $prep_balde['nro_balde'] }} .:: {{ $prep_balde['kg_balde'] }} kg. .:: {{ $prep_balde['observacion_det_preparacion'] }} .:: {{ $prep_balde['estado'] }}</option>
                                    @endforeach
                            </select>
                            @error('id_balde_detalle_proceso_preparacion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success" wire:click="agregar_balde">AGREGAR</button>
                            <br>
                            {{-- <button type="button" class="btn btn-danger" wire:click="limpiar_balde">LIMPIAR</button> --}}
                        </div>
                        {{-- <div class="col-md-12">
                            <p>{{json_encode($LISTA_DETALLE_PREPARACION)}}</p>
                        </div> --}}
                        <div class="col-md-12">
                            @if(count($lista_de_baldes) > 0)
                                <div class="table-responsive-xl">
                                    <table class="table table-sm text-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Nro de balde</th>
                                                <th>Kg.</th>
                                                <th>Código de preparación</th>
                                                <th></th>
                                                {{-- <th>Turno</th>
                                                <th>Sabor</th>
                                                <th>Cantidad de Baldes</th>
                                                <th>Nombre</th>
                                                <th>Máquina</th>
                                                <th>Observaciones</th>
                                                <th>Estado</th>
                                                <th class="text-right">Acciones</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total_baldes = 0;
                                                $total_kg = 0;
                                            @endphp
                                            @foreach($lista_de_baldes as $bal)
                                                {{-- <li>{{json_encode($bal)}}</li> --}}
                                                @php
                                                    $total_baldes++;
                                                    $total_kg += $bal['kg_balde'];
                                                @endphp
                                                <tr>
                                                    <td>{{$bal['fecha']}}</td>
                                                    <td>{{$bal['nro_balde']}}</td>
                                                    <td>{{$bal['kg_balde']}} kg.</td>
                                                    <td>{{$bal['proceso_preparacion']['codigo']}}</td>
                                                    <td>
                                                        <button wire:click="quitar_balde({{$bal['id']}})" title="Quitar balde">
                                                            <i class="fas fa-trash text-danger"></i>
                                                        </button>
                                                    </td>
                                                    {{-- <td>{{json_encode($bal)}}</td> --}}
                                                </tr>
                                            @endforeach
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2">Cantidad de baldes: <b>{{$total_baldes}}</b></td>
                                                    <td colspan="2">Total Kilogramos: <b>{{$total_kg}}</b></td>
                                                </tr>
                                            </tfoot>
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-danger">Aun no se añadieron baldes.</p>
                            @endif
                            @error('cantidad_baldes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_crear_salida_mol">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="save_modal_crear_salida_mol">GUARDAR</button>
                </div>
            </div>
        @elseif($operation=='edit_salida_molino')
            <div class="card-body p-3">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 text-center">
                        EDITAR SALIDA DE MOLINO
                    </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_editar_salida_mol"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="ed_codigo">
                                        <i class="fas fa-lock pe-1"></i>
                                        <b>Código</b>
                                    </label>
                                </div>
                                <input class="form-control @error('ed_codigo') border-danger @enderror" wire:model="ed_codigo" id="ed_codigo" >
                            </div>
                            @error('ed_codigo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="ed_turno">
                                        <i class="fas fa-clock pe-1"></i>
                                        <b>Turno</b>
                                    </label>
                                </div>
                                <select class="form-control @error('ed_turno') border-danger @enderror" id="ed_turno" wire:model="ed_turno">
                                    <option value="">Seleccione turno</option>
                                    @foreach ($LISTA_TURNOS as $tur)
                                        <option value="{{$tur}}">{{ $tur }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('ed_turno')
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
                                <select class="form-control @error('ed_encargado_id') border-danger @enderror" wire:model="ed_encargado_id">
                                    <option value="">Seleccione usuario</option>
                                    @foreach ($usuarios as $us)
                                        <option value="{{$us->id}}">{{ $us->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('ed_encargado_id')
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
                                <select class="form-control @error('ed_maquina_id') border-danger @enderror" wire:model="ed_maquina_id">
                                    <option value="">Seleccione maquina</option>
                                    @foreach ($maquinas as $maq)
                                        <option value="{{$maq->id}}">{{ $maq->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('ed_maquina_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="ed_sabor">
                                        <i class="fas fa-bucket pe-1"></i>
                                        <b>Sabor</b>
                                    </label>
                                </div>
                                <select class="form-control @error('ed_sabor') border-danger @enderror" id="ed_sabor" wire:model="ed_sabor" wire:change="on_update_preparation" disabled>
                                    <option value="">Seleccione sabor</option>
                                    @foreach ($LISTA_DE_SABORES as $sab)
                                        <option value="{{$sab}}">{{ $sab }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('ed_sabor')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="ed_total_aprox">
                                        <i class="fas fa-weight-scale pe-1"></i>
                                        <b>Total (kg)</b>
                                    </label>
                                </div>
                                <input class="form-control @error('ed_total_aprox') border-danger @enderror" type="number" wire:model="ed_total_aprox" id="ed_total_aprox" disabled>
                            </div>
                            @error('ed_total_aprox')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="ed_cantidad_baldes">
                                        <i class="fas fa-weight-scale pe-1"></i>
                                        <b>Total baldes</b>
                                    </label>
                                </div>
                                <input class="form-control @error('ed_cantidad_baldes') border-danger @enderror" type="number" wire:model="ed_cantidad_baldes" id="ed_cantidad_baldes" disabled>
                            </div>
                            @error('ed_cantidad_baldes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="ed_observacion">
                                        <i class="fas fa-triangle-exclamation pe-1"></i>
                                        <b>Observación</b>
                                    </label>
                                </div>
                                <textarea class="form-control @error('ed_observacion') border-danger @enderror" wire:model="ed_observacion" id="ed_observacion"></textarea>
                            </div>
                            @error('ed_observacion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="ed_fecha">
                                        <i class="fas fa-calendar pe-1"></i>
                                        <b>Fecha</b>
                                    </label>
                                </div>
                                <input class="form-control @error('ed_fecha') border-danger @enderror" type="date" wire:model="ed_fecha" id="ed_fecha">
                            </div>
                            @error('ed_fecha')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="input-group-text" for="edit_despacho_id" title="código preparación .:: fecha preparación .:: observación de preparación">
                                <b>Preparación</b>
                            </label>
                            <select class="form-control " id="edit_despacho_id" wire:model="edit_despacho_id" wire:change="on_change_edit_despacho_id"> {{-- on_change_det_despacho_id --}}
                                <option value="">Seleccione preparación</option>
                                    @foreach ($ed_LISTA_PREPARACION as $prepar)
                                        <option value="{{$prepar['id_proceso_preparacion']}}">{{ $prepar['codigo'] }} .:: {{ $prepar['fecha'] }} .:: {{ $prepar['observacion'] }}</option>
                                    @endforeach
                            </select>
                            @error('edit_despacho_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="input-group-text" for="edit_detalle_balde_id" title="nro. de balde .:: kg. de balde .:: observación de balde">
                                <b>Balde</b>
                            </label>
                            <select class="form-control " id="edit_detalle_balde_id" wire:model="edit_detalle_balde_id">
                                <option value="">Seleccione Balde</option>
                                    @foreach ($ed_LISTA_DETALLE_BALDES_DE_PREPARACION as $prep_balde)
                                        <option value="{{$prep_balde['id_det_preparacion']}}">{{ $prep_balde['nro_balde'] }} .:: {{ $prep_balde['kg_balde'] }} kg. .:: {{ $prep_balde['observacion_det_preparacion'] }} .:: {{ $prep_balde['estado'] }} .:: {{$prep_balde['codigo']}}</option>
                                    @endforeach
                            </select>
                            @error('edit_detalle_balde_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary" wire:click="agregar_balde_editar">AGREGAR</button>
                            <br>
                            <button type="button" class="btn btn-danger" wire:click="editar_limpiar_balde">LIMPIAR</button>
                        </div>

                        <div class="col-md-12">
                            @if(count($list_editar_det_sal_mol) > 0)
                                <div class="table-responsive-xl">
                                    <table class="table table-sm text-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Nro de balde</th>
                                                <th>Kg.</th>
                                                <th>Código de preparación</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total_baldes = 0;
                                                $total_kg = 0;
                                            @endphp
                                            @foreach($list_editar_det_sal_mol as $bald)
                                                <li>{{json_encode($bald)}}</li>
                                                @php
                                                    #$total_kg += $bal['kg_balde'];
                                                @endphp
                                                <tr>
                                                    <td>{{$bald->detalle_proceso_preparacion->fecha}}</td>
                                                    <td>{{$bald->detalle_proceso_preparacion->nro_balde}}</td>
                                                    <td>{{$bald->detalle_proceso_preparacion->kg_balde}} kg.</td>
                                                    <td>{{$bald->detalle_proceso_preparacion->proceso_preparacion->codigo}}</td>
                                                    <td>
                                                        <a class="btn" wire:click.prevent="$emit('alerta', 'eliminar_balde_editar', {{ $bald->id }})"  title="Quitar balde">
                                                            <i class="fas fa-trash text-danger"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2">Cantidad de baldes: <b>{{$total_baldes}}</b></td>
                                                    <td colspan="2">Total Kilogramos: <b>{{$total_kg}}</b></td>
                                                </tr>
                                            </tfoot>
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-danger">Sin baldes asignados.</p>
                            @endif
                            @error('ed_cantidad_baldes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        @error('ed_id')
                                <span class="text-danger">{{ $message }}</span> <br>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" wire:click="close_modal_editar_salida_mol">CANCELAR</button>
                    <button type="button" class="btn btn-primary" wire:click="save_modal_editar_salida_mol">ACTUALIZAR</button>
                </div>
            </div>
        @else
            {{-- -------------- MAIN ------------------------}}
            <div class="row">
                <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2 py-2">
                    <br>
                    <h5 class="text-center text-white bg-gradient-to-r from-indigo-500 to-blue-500 py-3 rounded shadow-lg uppercase tracking-wide">
                     ENTREGA A PRODUCCIÓN
                    </h3>
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
                                    <option value="{{ $me}}">{{ $me}} - {{ \Carbon\Carbon::create(null, $me)->locale('es')->isoFormat('MMMM')}}</option>
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
                    @if($statusMes && $statusDia && $dia !== "" && count($salidas_molino) > 0)
                        <div class="input-group mb-2 ms-5">
                            {{-- <div class="input-group-prepend">
                                <label class="input-group-text" for="mes">
                                    <i class="fas fa-calendar pe-1"></i>
                                    <b></b>
                                </label>
                            </div> --}}
                            <a type="button" class="btn btn-success text-white"
                                target="_blank" href="{{ route('salida_de_molino.pdf', ['fecha' => $anio .'-'. $mes .'-'. $dia])}}">GENERAR PDF</a>
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
                                <th>En producción</th>
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
                                    <td class="text-center">
                                        {{ $salda_molino->cantidad_baldes }}
                                        <span class="text-primary">({{$salda_molino->total_aprox}} kg)</span>
                                    </td>
                                    <td>{{ $salda_molino->recepcionista->username }}</td>
                                    <td>{{ $salda_molino->maquina->nombre }}</td>
                                    <td>
                                        @if($salda_molino->producto_envasado)
                                            {{ $salda_molino->producto_envasado->codigo }}
                                        @endif
                                    </td>
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
                                                        @php
                                                            $editar = true;
                                                            $prod_env = $salda_molino->producto_envasado;
                                                            if($prod_env){
                                                                if($prod_env->estado == 2){
                                                                    $editar = false;
                                                                }
                                                            }
                                                        @endphp
                                                       {{--  @if($editar) --}}
                                                            <a wire:click="open_modal_editar_salida_mol({{ $salda_molino->id }})"
                                                                class="dropdown-item" data-placement="top"
                                                                title="Editar {{ $salda_molino->codigo }}">
                                                                <i class="fas fa-edit"></i> Editar
                                                            </a>
                                                            @if(is_null($salda_molino->producto_envasado))
                                                                <a wire:click.prevent="$emit('alerta', 'eliminar_maquina', {{ $salda_molino->id }})"
                                                                    class="dropdown-item" data-placement="top"
                                                                    title="Eliminar">
                                                                    <i class="fas fa-trash"></i> Eliminar
                                                                </a>
                                                            @endif
                                                        {{-- @endif --}}
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
        @endif

    </div>
</div>
