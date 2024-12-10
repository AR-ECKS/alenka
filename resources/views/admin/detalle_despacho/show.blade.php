@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="background: #f4f6f9">
    <li class="breadcrumb-item"><a href="{{ route('detalle_despacho.index') }}">Detalle_despacho</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar Detalle_despacho</li>
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
                      <img src="{{ asset('storage').'/'.detalle_despacho->imagen}}" alt="">

                        <h5 class="title mt-3">{{ $detalle_despacho->id }}</h5>
                      </a>
                      <p class="description">
                     <b>   Registrado el:</b>
                     {{ $detalle_despacho->created_at }}
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
                          <td >ID</td>
                          <td >{{ $detalle_despacho->id }}</td>
                      </tr>
                      <tr><td> Cantidad Presentacion </td>
            <td> {{ $detalle_despacho->cantidad_presentacion }} </td></tr><tr><td> Cantidad Unidad </td>
            <td> {{ $detalle_despacho->cantidad_unidad }} </td></tr><tr><td> Materia Prima Id </td>
            <td> {{ $detalle_despacho->materia_prima_id }} </td></tr>


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
