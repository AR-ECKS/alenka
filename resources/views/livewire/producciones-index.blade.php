<div class="row">
    see monkey
    <div class="border border-width-1"></div>
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Veniam nulla dolor reprehenderit neque, error id beatae molestias fuga laborum non odio velit laudantium sit aspernatur at amet aut. Dolor, ullam.</p>
    <p>Is {{$ID_PROCESO}}</p>
    <p class="text-white bg-secondary">{{json_encode($liv_proceso)}}</p>
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
        <button class="btn btn-primary mb-2" wire:click="abrir_modal_salida_molino"><i class="fas fa-plus-circle pe-2" ></i> AGREGAR</button>
        @if(count($liv_producciones) > 0)
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th class="col">#</th>
                        <th class="col">Sabor</th>
                        <th class="col">Baldes</th>
                        <th class="col">Cantidad</th>
                        <th class="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($liv_producciones as $prodd)
                        <tr>
                            <th scope="row">{{ $prodd->id}}</th>
                            <td>{{ $prodd->sabor}}</td>
                            <td>{{ $prodd->sabor}}</td>
                            <td>{{ $prodd->sabor}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            @foreach ($liv_sabores_dispononibles as $sabores)
                <li>{{ $sabores}}</li>
            @endforeach
        @else
            <p class="text-center text-danger">No hay registros</p>
        @endif
    </div>
</div>

{{-- INIT MODALS --}}
<div wire:ignore.self id="modalAgregarAMolino" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="myModallabelTitle" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-header">
            <h5 class="modal-title mt-0">AGREGAR A MOLINO</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close" wire:click=""></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn btn-danger">CANCELAR</button>
            <button type="button" class="btn btn-primary">AGREGAR</button>
        </div>
    </div>
</div>

@push('custom_js')
    <script>
        document.addEventListener('livewire:load', function(){

            Livewire.on('showModalAddMolino', () => {

                $('#modalAgregarAMolino').modal('show');
                console.log($('#modalAgregarAMolino'));

            });
        });
    </script>
@endpush
