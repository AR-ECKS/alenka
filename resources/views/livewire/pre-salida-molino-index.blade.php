
<div>
<div class="card">
    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2 ">

    </div>
    <div class="card-body p-3">

    </div>

    @if($operation=='create_salida_molino')
        <div class="card-body p-3">
            <div class="modal-header">
                <h5 class="modal-title mt-0 text-center">AGREGAR SALIDA A MOLINO DE </h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_crear_salida_mol"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="c_codigo">
                                    <i class="fas fa-lock pe-1"></i>
                                    <b>Código</b>
                                </label>
                            </div>
                            <input class="form-control" wire:model="c_codigo" id="c_codigo" value="{{$c_codigo}}" disabled>
                        </div>
                        @error('c_codigo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="c_turno">
                                    <i class="fas fa-clock pe-1"></i>
                                    <b>Turno</b>
                                </label>
                            </div>
                            <select class="form-control" id="c_turno" wire:model="c_turno">
                                <option value="">Seleccione turno</option>
                                @foreach ($LISTA_TURNOS as $tur)
                                    <option value="{{$tur}}">{{ $tur }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('c_turno')
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
                            <select class="form-control" wire:model="c_id_encargado">
                                <option value="">Seleccione usuario</option>
                                @foreach ($usuarios as $us)
                                    <option value="{{$us->id}}">{{ $us->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('c_id_encargado')
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
                            <select class="form-control" wire:model="c_id_encargado">
                                <option value="">Seleccione maquina</option>
                                @foreach ($usuarios as $us)
                                    <option value="{{$us->id}}">{{ $us->maquina }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('c_id_encargado')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="c_baldes">
                                    <i class="fas fa-bucket pe-1"></i>
                                    <b>Baldes</b>
                                </label>
                            </div>
                            <input class="form-control" type="number" wire:model="c_baldes" id="c_baldes" value="{{$c_baldes}}">
                        </div>
                        @error('c_baldes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="c_cantidad">
                                    <i class="fas fa-weight-scale pe-1"></i>
                                    <b>Cantidad (kg)</b>
                                </label>
                            </div>
                            <input class="form-control" type="number" wire:model="c_cantidad" id="c_cantidad" value="{{$c_cantidad}}">
                        </div>
                        @error('c_cantidad')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-8">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="c_observacion">
                                    <i class="fas fa-triangle-exclamation pe-1"></i>
                                    <b>Observación</b>
                                </label>
                            </div>
                            <textarea class="form-control" wire:model="c_observacion" id="c_observacion"></textarea>
                        </div>
                        @error('c_observacion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="c_fecha">
                                    <i class="fas fa-calendar pe-1"></i>
                                    <b>Fecha</b>
                                </label>
                            </div>
                            <input class="form-control" type="date" wire:model="c_fecha" id="c_fecha" disabled>
                        </div>
                        @error('c_fecha')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        @error('c_proceso_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-danger" wire:click="close_modal_crear_salida_mol">CANCELAR</button>
                <button type="button" class="btn btn-primary" wire:click="save_modal_crear_salida_mol">AGREGAR</button>
            </div>
        </div>
        {{--json_encode($PROCESO_ACTUAL)--}}
    @endif
    {{-- <div class="card-body p-3">
        <div class="modal-header">
            <h5 class="modal-title mt-0 text-center">AGREGAR SALIDA A MOLINO DE </h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click="close_modal_crear_salida_mol"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn btn-danger" wire:click="close_modal_crear_salida_mol">CANCELAR</button>
            <button type="button" class="btn btn-primary">AGREGAR</button>
        </div>
    </div> --}}
</div>

<div class="card">
    <h4>Detalles del Despacho</h4>
    <div class="row">
        <div class="col-sm-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-lock pe-1"></i>
                        <b>Código</b>
                    </div>
                </div>
                <span class="form-control">{{ $liv_proceso->despacho->codigo }}</span>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-lock pe-1"></i>
                        <b>Sabor</b>
                    </div>
                </div>
                <span class="form-control">{{ $liv_proceso->despacho->sabor }}</span>
            </div>
        </div>
    </div>
    <hr>
    <h4>Detalles del proceso</h4>
    <div class="col-12 row">
        <div class="col-sm-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-lock pe-1"></i>
                        <b>Código</b>
                    </div>
                </div>
                <span class="form-control">{{ $liv_proceso->codigo }}</span>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar pe-1" ></i>
                        <b>{{ 'Fecha' }}</b>
                    </div>
                </div>
                <span class="form-control">{{ \Carbon\Carbon::parse($liv_proceso->fecha)->isoFormat('DD/MM/YY') }}</span>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="input-group mb-2">
                <span class="form-control">{{ \Carbon\Carbon::parse($liv_proceso->fecha)->isoFormat('dddd, D \d\e MMMM \d\e\l YYYY') }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 row">
        <div class="col-sm-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-user pe-1"></i>
                        <b>{{'Usuario'}}</b>
                    </div>
                </div>
                <span class="form-control">{{ $liv_proceso->user_id }}</span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-lock pe-1"></i>
                        <b>{{'Cantidad'}}</b>
                    </div>
                </div>
                <span class="form-control">{{ $liv_proceso->baldes }} baldes</span>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-lock pe-1"></i>
                        <b>{{'Peso'}}</b>
                    </div>
                </div>
                <span class="form-control">{{ $liv_proceso->total }} kg.</span>
            </div>
        </div>
    </div>

    <hr>
    <div class="col-12">
        <h3 class="text-center text-primary">SALIDAS DE MOLINO</h3>
    </div>
    <div class="col-12 row">
        <div class="col-sm-5">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-lock pe-1"></i>
                        <b>{{'Cantidad Disponible'}}</b>
                    </div>
                </div>
                <span class="form-control">{{ $liv_proceso->total_baldes }} baldes</span>
            </div>
        </div>

        <div class="col-sm-5">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-lock pe-1"></i>
                        <b>{{'Peso Disponible'}}</b>
                    </div>
                </div>
                <span class="form-control">{{ $liv_proceso->total_cantidad }} kg.</span>
            </div>
        </div>
    </div>

    <div class="col-12">
        <p>¿Que cantidad y/o baldes salieron despues de la mezcla (preparación)?</p>
        @if($liv_proceso->total_baldes > 0 && $liv_proceso->total_cantidad > 0)
            <button class="btn btn-primary mb-2" wire:click="open_modal_crear_salida_mol"><i class="fas fa-plus-circle pe-2" ></i> AGREGAR</button>
        @endif
        @if(count($liv_pre_salidas_molino) > 0)
            <div class="tab-content">
                <div class="table-responsive-xl">
                    <table class="table table-sm text-sm table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Nombre y máquina</th>
                                <th>Baldes</th>
                                <th>Cantidad</th>
                                <th>Turno</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($liv_pre_salidas_molino as $prodd)
                                <tr>
                                    <th scope="row">{{ $prodd->id}}</th>
                                    <td>{{ \Carbon\Carbon::parse($prodd->fecha)->isoFormat('DD-MM-YYYY')}}</td>
                                    <td>
                                        {{ $prodd->recepcionista->username}} <br>
                                        máquina {{ $prodd->recepcionista->maquina}}
                                    </td>
                                    <td>{{ $prodd->baldes}}</td>
                                    <td>{{ $prodd->cantidad}} kg.</td>
                                    <td>{{ $prodd->turno}}</td>
                                    <td>{{ $prodd->observacion}}</td>
                                    <td>
                                        @if($operation=='')
                                            <button type="button" class="btn btn-danger me-1" title="Eliminar" wire:click="eliminar_salida_mol({{ $prodd->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            <hr>
        @else
            <p class="text-center text-danger">No hay registros</p>
        @endif
    </div>
</div>
</div>
