@if(isset($data_despacho))
    <div class="row">
        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa-solid fa-lock"></i> <span class="ms-1">Código</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_despacho->codigo}}</span>
            </div>
        </div>

        @php 
            $fec = $data_despacho->fecha;
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
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa-solid fa-flask"></i> <span class="ms-1">Sabor</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_despacho->sabor }}</span>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa-solid fa-user"></i> <span class="ms-1">Entregado a</span>
                    </div>
                </div>
                <span class="form-control @if(is_null($data_despacho->receptor_u)) text-danger text-center @endif"> {{ is_null($data_despacho->receptor_u)? 'Sin Asinar': $data_despacho->receptor_u->username }}</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa-solid fa-weight-scale"></i> <span class="ms-1">Peso total</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_despacho->total }} kg.</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text text-secondary">
                        <i class="fa-solid fa-calendar-check"></i> <span class="ms-1">Ultima modificación</span>
                    </div>
                </div>
                <span class="form-control text-secondary"> {{ Carbon\Carbon::create($data_despacho->updated_at)->locale('es')->isoFormat('dddd, D \d\e MMM \d\e\l YYYY HH:mm') }}</span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa-solid fa-triangle-exclamation"></i> <span class="ms-1">Observación</span>
                    </div>
                </div>
                <span class="form-control "> {{ $data_despacho->observacion }}</span>
            </div>
        </div>

    </div>

    <hr>
    @if(count($data_despacho->detalle_despachos) > 0)
        <div class="table-responsive-xl">
            <table class="table table-sm text-sm table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código producto</th>
                        <th>Producto</th>
                        <th>Presentación</th>
                        <th>U/medida</th>
                        <th>Cantidad presentacion</th>
                        <th>Cantidad unidad</th>
                        <th>Ultima modificación</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $contador = 1;
                    @endphp
                    @foreach($data_despacho->detalle_despachos as $detail)
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td>{{ $detail->materia_prima->codigo }}</td>
                            <td>{{ $detail->materia_prima->nombre }}</td>
                            <td>{{ $detail->materia_prima->presentacion }}</td>
                            <td>{{ $detail->materia_prima->unidad_medida }}</td>
                            <td>{{ $detail->cantidad_presentacion }}</td>
                            <td>{{ $detail->cantidad_unidad }}</td>
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