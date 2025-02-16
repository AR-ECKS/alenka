@if($detalle_producto_envasado)
    <div class="col-md-12">

        <ul class="nav nav-pills mb-3" {{-- id="pills-tab" --}} role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-producto-envasado-tab" data-toggle="pill" data-target="#pills-producto-envasado" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Detalles</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Salida de molino</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</button>
            </li>
        </ul>
        <div class="tab-content" {{-- id="pills-tabContent" --}}>
            <div class="tab-pane fade show active" id="pills-producto-envasado" role="tabpanel" aria-labelledby="pills-producto-envasado-tab">
                <div class="row">
                    <div class="col-md-3"> <b>Fecha:</b> {{$detalle_producto_envasado->fecha}} </div>
                    <div class="col-md-3"> <b>Máquina: </b> {{$detalle_producto_envasado->maquina->nombre}}</div>
                    <div class="col-md-3"> <b>Encargado: </b> 
                        @if(is_null($detalle_producto_envasado->encargado))
                            <span class="text-danger">Sin operador</span>
                        @else
                            {{$detalle_producto_envasado->encargado->username}}
                        @endif
                    </div>
                    <div class="col-md-3"> <b>Sabor: </b> {{$detalle_producto_envasado->sabor}}</div>

                    <div class="col-md-3"> <b>Saldo anterior: </b> {{$detalle_producto_envasado->caja_cajas}}</div>
                    <div class="col-md-3"> <b>Cambio de Máquina: </b> {{--$detalle_producto_envasado->caja_cajas--}}</div>
                    <div class="col-md-3"> <b>Entrada de molino: </b> {{$detalle_producto_envasado->caja_cajas}}</div>
                    <div class="col-md-3"> <b>Sobro del día: </b> {{$detalle_producto_envasado->caja_cajas}}</div>

                    <div class="col-md-3"> <b>Cajas: </b> {{$detalle_producto_envasado->caja_cajas}}</div>
                    <div class="col-md-3"> <b>Bolsas: </b> {{$detalle_producto_envasado->caja_bolsas}}</div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row">
                    @if($detalle_producto_envasado->salida_de_molino)
                        <div class="col-md-3">Fecha: {{$detalle_producto_envasado->salida_de_molino->fecha}} </div>
                        <div class="col-md-3"><b>Máquina:</b> {{$detalle_producto_envasado->salida_de_molino->maquina->nombre}} </div>
                        <div class="col-md-3"> <b>recepcionista: </b> {{$detalle_producto_envasado->salida_de_molino->recepcionista->username}}</div>
                        <div class="col-md-3"> <b>Sabor: </b> {{$detalle_producto_envasado->salida_de_molino->sabor}}</div>

                        <div class="col-md-3"> <b>Cantidad de baldes: </b> {{count($detalle_producto_envasado->salida_de_molino->detalle_salida_molinos)}}</div>
                        <div class="col-md-3"> <b>Kilogramos: </b> {{$detalle_producto_envasado->salida_de_molino->total_aprox}}</div>
                        <div class="col-md-6"> <b>Observaciones: </b> {{$detalle_producto_envasado->salida_de_molino->observacion}}</div>
                    @endif
                </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Distinctio blanditiis asperiores, corrupti qui, cumque dolores at voluptatem placeat pariatur nostrum, illo quia doloremque minus itaque error ex doloribus! Odio, exercitationem!</div>
        </div>
        <hr>

    </div>
@endif