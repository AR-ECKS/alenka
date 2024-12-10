@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="background: #f4f6f9">
    <li class="breadcrumb-item"><a href="{{ route('detalle_produccion.index') }}">Detalle_produccion</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar Detalle_produccion</li>
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
                      <img src="{{ asset('storage').'/'.detalle_produccion->imagen}}" alt="">

                        <h5 class="title mt-3">{{ $detalle_produccion->id }}</h5>
                      </a>
                      <p class="description">
                     <b>   Registrado el:</b>
                     {{ $detalle_produccion->created_at }}
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
                          <td >{{ $detalle_produccion->id }}</td>
                      </tr>
                      <tr><td> Produccion Id </td>
            <td> {{ $detalle_produccion->produccion_id }} </td></tr><tr><td> User Id </td>
            <td> {{ $detalle_produccion->user_id }} </td></tr><tr><td> Baldes </td>
            <td> {{ $detalle_produccion->baldes }} </td></tr>


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
