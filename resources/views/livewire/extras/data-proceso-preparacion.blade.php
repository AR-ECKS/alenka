@if(isset($data_proceso_preparacion))
    <div class="row">
        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa-solid fa-lock"></i> <span class="ms-1">Código</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_proceso_preparacion->codigo}}</span>
            </div>
        </div>

        @php 
            $fec = $data_proceso_preparacion->fecha;
            try {
                $txt = Carbon\Carbon::create($fec);
                $fec = $txt->locale('es')->isoFormat('dddd, D \d\e MMMM \d\e\l YYYY');
            } catch (\Exception $e) {
                # nada
            }
        @endphp
        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa-solid fa-calendar-days"></i> <span class="ms-1">Fecha</span>
                    </div>
                </div>
                <span class="form-control "> {{ $fec }}</span>
            </div>
        </div>

        <div class="col-md-4">
            {{-- <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa-solid fa-flask"></i> <span class="ms-1">Sabor</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_proceso_preparacion->sabor }}</span>
            </div> --}}
        </div>
        
        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa-solid fa-user"></i> <span class="ms-1">Total</span>
                    </div>
                </div>
                <span class="form-control"> {{ $data_proceso_preparacion->total_kg }} kg.</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa-solid fa-weight-scale"></i> <span class="ms-1">Disponible.</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_proceso_preparacion->disponible_kg }} kg.</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text text-secondary">
                        <i class="fa-solid fa-calendar-check"></i> <span class="ms-1">Ultima modificación</span>
                    </div>
                </div>
                <span class="form-control text-secondary"> {{ $data_proceso_preparacion->updated_at }}</span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa-solid fa-triangle-exclamation"></i> <span class="ms-1">Observación</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_proceso_preparacion->observacion }}</span>
            </div>
        </div>

    </div>

    <hr>
    @if(count($data_proceso_preparacion->detalle_proceso_preparacion) > 0)
        <div class="table-responsive-xl">
            <table class="table table-sm text-sm table-striped">
                <thead>
                    <tr>
                        <th>Nro. de balde</th>
                        <th>Kilogramos</th>
                        <th>Fecha</th>
                        <th>Observación</th>
                        <th>Ultima modificación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_proceso_preparacion->detalle_proceso_preparacion as $detail)
                        <tr>
                            <td>{{ $detail->nro_balde }}</td>
                            <td>{{ $detail->kg_balde }} kg. </td>
                            <td>{{ $detail->fecha }}</td>
                            <td>{{ $detail->observacion }}</td>
                            <td>{{ $detail->updated_at }}</td>
                        </tr>
                        {{-- <li>{{json_encode($detail)}}</li> --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@else
    <div class="text-danger-text-center">No hay preparación.</div>
@endif