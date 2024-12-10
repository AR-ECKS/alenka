@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: #f4f6f9">
            <li class="breadcrumb-item"><a href="{{ route('materia_prima.index') }}">Materia_prima</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver Materia_prima</li>
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
                                                <a href="#">
                                                    {{-- <img src="{{ asset('storage').'/'.materia_prima->imagen}}" alt=""> --}}

                                                    <h5 class="title mt-3">{{ $materia_prima->nombre }}</h5>
                                                </a>
                                                <p class="description">
                                                    <b> Proveedor:</b>
                                                    {{ $materia_prima->proveedor->razon_social }}
                                                    <br>
                                                    <b> Subcategoria:</b>
                                                    {{ $materia_prima->subcategoria->nombre }}

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
                                            <table class="table table-bordered table-striped table-responsive">
                                                <tbody>
                                                    <tr>
                                                        {{-- <td >ID</td>
                          <td >{{ $materia_prima->id }}</td> --}}
                                                    </tr>
                                                    <tr>
                                                        <td> Codigo: </td>
                                                        <td> {{ $materia_prima->codigo }} </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Nombre: </td>
                                                        <td> {{ $materia_prima->nombre }} </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Descripción: </td>
                                                        <td> {{ $materia_prima->descripcion }} </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Presentación: </td>
                                                        <td> <b>{{ $materia_prima->presentacion }}</b> contiene <b>
                                                                {{ $materia_prima->cantidad }}
                                                                {{ $materia_prima->unidad_medida }}</b> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Stock en {{ $materia_prima->presentacion }}s : </td>
                                                        <td> {{ $materia_prima->stock_presentacion }} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Stock en {{ $materia_prima->unidad_medida }} :</td>
                                                        <td> {{ $materia_prima->stock_unidad }} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Precio Compra por {{ $materia_prima->presentacion }} :</td>
                                                        <td> {{ $materia_prima->precio_compra }} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Precio Compra por {{ $materia_prima->unidad }}: </td>
                                                        <td> {{ $materia_prima->costo_unidad }} </td>
                                                    </tr>


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
