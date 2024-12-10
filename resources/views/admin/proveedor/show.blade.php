@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="background: #f4f6f9">
    <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ver Proveedor </li>
  </ol>
</nav>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">

          <!--body-->
          <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success" role="success">
              {{ session('success') }}
            </div>
            @endif
            <div class="row">
              <div class="col-md-4">
                <div class="card card-proveedor">
                  <div class="card-body">
                    <p class="card-text">
                    <div class="author">
                      <a href="#">
                      <img src="{{ asset('storage').'/'.$proveedor->imagen}}" alt="">

                        <h5 class="title mt-3">{{ $proveedor->razon_social }}</h5>
                      </a>
                      <p class="description">
                     <b>   Registrado el:</b>
                        {{ $proveedor->created_at }}
                      </p>
                    </div>
                    </p>
                    <div class="card-description">
                    </div>
                  </div>
                  <div class="card-footer">
                    {{-- <div class="button-container">
                      <button class="btn btn-sm btn-primary">Editar</button>
                    </div> --}}
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
                          <th>Nombre</th>
                          <td>{{ $proveedor->razon_social }}</td>
                          <th>Pais</th>
                          <td><span class="badge badge-primary">{{ $proveedor->pais }}</span></td>
                        </tr>
                        <tr>
                            <th>Direccion</th>
                            <td>{!! $proveedor->direccion !!}</td>
                            <th>Telefono</th>
                            <td>{!! $proveedor->telefono !!}</td>
                        </tr>
                        <tr>
                          <th>Celular</th>
                          <td>{!! $proveedor->celular !!}</td>
                          <th>Correo</th>
                          <td>{{ $proveedor->correo }}</td>
                        </tr>
                        <tr>
                            <th>Pagina web</th>
                          <td>{{ $proveedor->pagina_web }}</td>
                          <th>Nombre Representante</th>
                          <td>{{ $proveedor->pagina_web }}</td>
                        </tr>
                        <tr>
                            <th>Telefono Representante</th>
                            <td>{{ $proveedor->telefono_representante }}</td>
                          <th>Created at</th>
                          <td><a href="#" target="_blank">{{ $proveedor->created_at  }}</a></td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer">
                    {{-- <div class="button-container">
                      <a href="{{ route('proveedors.index') }}" class="btn btn-sm btn-success mr-3"> Volver </a>
                    <a href="#" class="btn btn-sm btn-twitter"> Editar </a>
                  </div> --}}
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
