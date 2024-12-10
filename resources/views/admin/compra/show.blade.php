@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: #f4f6f9">
            <li class="breadcrumb-item"><a href="{{ route('compra.index') }}">Compra</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Compra</li>
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

                                    <p class="card-text">
                                    <div class="author">
                                        <a href="#">

                                            <h5 class="title mt-3">Detalles de la compra {{ $compra->numero_compra}}</h5>
                                        </a>
                                        <p class="description">
                                            <b>N° Factura:</b>
                                            {{ $compra->factura }} <br>
                                            <b> Registrado el:</b>
                                            {{ \Carbon\Carbon::parse($compra->fecha)->translatedFormat('d \d\e F \d\e Y') }}
                                            <br>
                                            <b>Registrado por:
                                            </b>{{ $compra->user->name }}
                                            <br>

                                        </p>
                                    </div>
                                    </p>



                                </div><!--end card proveedor-->
                                <table id="tablaProductos" style="font-size: 14px; width: 100% !important;" class="table table-sm table-responsive table-striped table-bordered pt">
                                    <thead class="thead-dark inventario">
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Producto</th>
                                            <th>Costo</th>
                                            <th>Cantidad Presentación</th>
                                            <th>Cantidad Unidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($detalles as $detalle)
                                        <tr>
                                            <td>{{ $detalle->materia_prima->codigo }}</td>
                                            <td>{{ $detalle->materia_prima->nombre }}</td>
                                            <td>{{ $detalle->precio_real_presentacion }}</td>
                                            <td><b>{{ $detalle->cantidad_presentacion }}</b> {{ $detalle->materia_prima->presentacion }}s</td>
                                            <td><b>{{ $detalle->cantidad_unidad }}</b> {{ $detalle->materia_prima->unidad_medida}} </td>
                                            <td><b>{{ $detalle->cantidad_presentacion * $detalle->precio_real_presentacion }} Bs</b></td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="5" style="text-align: right;"><b>Total:</b></td>
                                            <td><b>{{ number_format($detalle->compra->total, 2, ',', '.') }} Bs</b></td>
                                        </tr>
                                    </tbody>
                                </table>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
