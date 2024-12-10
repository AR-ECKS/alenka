@extends('layouts.app') @section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background: #f4f6f9;">
        <li class="breadcrumb-item">
            <a href="{{ route('despacho.index') }}" >Despacho</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Crear Despacho para PRODUCCIÓN</li>
    </ol>
</nav>
<div class="alert alert-success" role="alert">
    <div class="text-center">
        <h3>ENVIAR MATERIA PRIMA A PRODUCCIÓN</h3>
    </div>
  </div>
<section>
    <div class="card">
        <form method="POST"  action="{{ route('despacho.store') }}" class="my-4 mx-4" accept-charset="UTF-8"
            enctype="multipart/form-data">
            @csrf()  @include ('admin.despacho.form', ['formMode' => 'create'])
        </form>
    </div>
</section>
@endsection
