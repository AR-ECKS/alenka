@if($carac_proceso_preparacion)
    <div class="col-md-12">

        <ul class="nav nav-pills mb-3" {{-- id="pills-tab" --}} role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-despacho-tab" data-toggle="pill" data-target="#pills-despacho" type="button" role="tab" aria-controls="pills-despacho" aria-selected="false">Despacho</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-preparacion-tab" data-toggle="pill" data-target="#pills-preparacion" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Detalles</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-detalle-salida-molino-tab" data-toggle="pill" data-target="#pills-detalle-salida-molino" type="button" role="tab" aria-controls="pills-detalle-salida-molino" aria-selected="false">Salida de molino</button>
            </li>
        </ul>
        <div class="tab-content" {{-- id="pills-tabContent" --}}>
            <div class="tab-pane fade" id="pills-despacho" role="tabpanel" aria-labelledby="pills-despacho-tab">
                @include('livewire.extras.data-despacho', [
                    'data_despacho' => $carac_proceso_preparacion->despacho
                ])
                <p>{{ json_encode( $carac_proceso_preparacion->despacho )}}</p>
            </div>
            <div class="tab-pane fade show active" id="pills-preparacion" role="tabpanel" aria-labelledby="pills-preparacion-tab">
                @include('livewire.extras.data-proceso-preparacion', [
                    'data_proceso_preparacion' => $carac_proceso_preparacion
                ])
            </div>
            <div class="tab-pane fade" id="pills-detalle-salida-molino" role="tabpanel" aria-labelledby="pills-detalle-salida-molino-tab">
                <div class="row">
                    {{-- init --}}
                    @if(count($carac_proceso_preparacion->detalle_proceso_preparacion) > 0)
                        <div class="col-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                @php $first = true; @endphp
                                @foreach($carac_proceso_preparacion->detalle_proceso_preparacion as $det_proceso)
                                    @php $det_proceso->cod_pill = "v-pills-det-preparacion-". $det_proceso->id; @endphp
                                    <button class="nav-link {{$first? 'active': ''}}" id="{{ $det_proceso->cod_pill }}-tab" data-toggle="pill" data-target="#{{ $det_proceso->cod_pill }}" type="button" role="tab" aria-controls="{{ $det_proceso->cod_pill }}" aria-selected="true">Balde {{ $det_proceso->nro_balde }}</button>
                                    @php $first = false; @endphp
                                @endforeach
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                @php $first = true; @endphp
                                @foreach($carac_proceso_preparacion->detalle_proceso_preparacion as $det_proceso)
                                    <div class="tab-pane fade {{$first? 'show active': ''}}" id="{{ $det_proceso->cod_pill }}" role="tabpanel" aria-labelledby="{{ $det_proceso->cod_pill }}-tab">
                                        @if($det_proceso->detalle_salida_de_molino)
                                            <h5>Detalles de Salida de Molino</h5>
                                        @else
                                            <p>Aun no está asignado</p>
                                        @endif
                                        {{$det_proceso->nro_balde}}
                                    </div>
                                    @php $first = false; @endphp
                                @endforeach
                            </div>
                        </div>
                        {{-- <div class="col-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-home-tab" data-toggle="pill" data-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</button>
                                <button class="nav-link" id="v-pills-profile-tab" data-toggle="pill" data-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</button>
                                <button class="nav-link" id="v-pills-messages-tab" data-toggle="pill" data-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</button>
                                <button class="nav-link" id="v-pills-settings-tab" data-toggle="pill" data-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">...</div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
                            </div>
                        </div> --}}
                    @else
                        <p>No hay datos</p>
                    @endif
                    {{-- end --}}
                </div>
            </div>
        </div>
        <hr>

    </div>
@endif