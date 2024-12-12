@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="background: #f4f6f9">
    <li class="breadcrumb-item"><a href="{{ route('proceso.index') }}">Proceso</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar Proceso</li>
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
                      <img src="{{-- asset('storage').'/'.proceso->imagen--}}" alt="NO IMAGE">

                        <h5 class="title mt-3">{{ $proceso->id }}</h5>
                      </a>
                      <p class="description">
                     <b>   Registrado el:</b>
                     {{ $proceso->created_at }}
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
                          <td >{{ $proceso->id }}</td>
                      </tr>
                      <tr><td> Codigo </td>
            <td> {{ $proceso->codigo }} </td></tr><tr><td> Observacion </td>
            <td> {{ $proceso->observacion }} </td></tr><tr><td> Fecha </td>
            <td> {{ $proceso->fecha }} </td></tr>


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
