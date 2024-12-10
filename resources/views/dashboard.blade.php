@extends('layouts.app')
@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
<div class="card">
    <div class="card-body">

        <div class="container">
            {{-- @can('') --}}
                <div class="row">
                    <div class="col-md-3">
                        <div class="small-box bg-info">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3></h3>
                                    <p>Compras de hoy</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <a href="{{ url('admin/venta') }}" class="small-box-footer">
                                    Más información <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                {{-- @endcan
                @can('') --}}
                    <div class="col-md-3">
                        <div class="small-box bg-success">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3></h3>
                                    <p>Mezclas de hoy</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-fill-drip"></i>
                                </div>
                                <a href="{{ url('admin/cotizacion') }}" class="small-box-footer">
                                    Más información <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                {{-- @endcan
                @can('') --}}
                    <div class="col-md-3">
                        <div class="small-box bg-info">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3></h3>
                                    <p>Compras de hoy</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ url('admin/compra') }}" class="small-box-footer">
                                    Más información <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                {{-- @endcan
                @can('') --}}
                    <div class="col-md-3">
                        <div class="small-box bg-success">
                            <div class="small-box bg-info">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3></h3>
                                        <p>Notas de entrega de hoy</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <a href="{{ url('admin/notaentrega') }}" class="small-box-footer">
                                        Más información <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                {{-- @endcan --}}

            </div>
            </div>

        </div>
    </div>

</div>


            @endsection
