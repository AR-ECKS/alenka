@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="background: #f4f6f9">
    <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}">Categorias</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ver Categoria </li>
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
                      <img src="{{ asset('storage').'/'.$categorium->imagen}}" alt="">

                        <h5 class="title mt-3">{{ $categorium->razon_social }}</h5>
                      </a>
                      <p class="description">
                     <b>   Registrado el:</b>
                        {{ $categorium->created_at }}
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
              </div><!--end card categorium-->


              <!--Start third-->
              <div class="col-md-8">
                <div class="card card-categorium">
                  <div class="card-body">
                    <table class="table table-bordered table-striped table-responsive">
                      <tbody>

                        <tr>
                          <th>Nombre</th>
                          <td>{{ $categorium->nombre }}</td>

                        </tr>
                        <tr>
                            <th>Direccion</th>
                            <td>{!! $categorium->descripcion !!}</td>

                        </tr>

                        <tr>

                          <th>Created at</th>
                          <td><a href="#" target="_blank">{{ $categorium->created_at  }}</a></td>
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
