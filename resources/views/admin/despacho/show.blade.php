@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: #f4f6f9">
            <li class="breadcrumb-item"><a href="{{ route('despacho.index') }}">Despacho</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Despacho</li>
        </ol>
    </nav>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <!--body-->
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card card-proveedor">
                                        <div class="card-body">
                                            <p class="card-text">
                                            <div class="author">

                                                <b>
                                                    <h5>Despacho de Materia Prima:</h5>
                                                </b>
                                                <a href="#">
                                                    <h5 class="title mt-3">{{ $despacho->codigo }}</h5>
                                                </a>
                                                <p class="description">
                                                    <b> Registrado el:</b>
                                                    {{ $despacho->fecha }}
                                                    <br>
                                                    <b>Sabor:</b>
                                                    {{ $despacho->sabor }}
                                                    <br>
                                                    <b> La envió:</b>
                                                    {{ $despacho->user->name }}
                                                    <br>
                                                    <b> La recibió:</b>
                                                    {{ $receptor }}
                                                </p>
                                            </div>
                                            </p>
                                            <div class="card-description">
                                            </div>
                                        </div>
                                        <div class="card-footer">

                                        </div>
                                    </div>
                                </div><!--end card proveedor-->


                                <!--Start third-->
                                <div class="col-md-8">
                                    <div class="card card-proveedor">

                                        <div class="card-body">
                                            <div class="card-title px-1 py-2" >
                                                <b>
                                                    @if(count($detalles) > 0)
                                                    <p>Se envió la siguiente cantidad de materia prima:</p>
                                                    @else
                                                        <p>ERROR:</p>
                                                    @endif
                                                </b>
                                            </div>
                                            <table class="table table-bordered table-sm table-striped ">
                                                <thead class="thead-dark inventario">
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Cantidad Presentación</th>
                                                        <th>Cantidad Unidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($detalles) > 0)
                                                        @foreach ($detalles as $detalle)
                                                            <tr>
                                                                <td>{{ $detalle->materia_prima->nombre }}</td>
                                                                <td><b>{{ $detalle->cantidad_presentacion }}</b>
                                                                    {{ $detalle->materia_prima->presentacion }}s</td>
                                                                <td><b>{{ $detalle->cantidad_unidad }}</b>
                                                                    {{ $detalle->materia_prima->unidad_medida }} </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="2"><b>Total:</b></td>
                                                            <td><b>{{ number_format($detalle->despacho->total, 2, ',', '.') }}
                                                                </b></td>
                                                        </tr>
                                                    @else
                                                        <p class="text-danger">Este despacho no tiene productos</p>
                                                    @endif
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="card-footer">

                                        </div>
                                    </div>
                                </div>
                                <!--end third-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
