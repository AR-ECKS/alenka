@extends('layouts.app') @section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background: #f4f6f9;">
        <li class="breadcrumb-item">
            <a href="{{ route('categorias.index') }}" >Categoria</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Crear Categoria</li>
    </ol>
</nav>
<section>
    <div class="card">
        <form method="POST"  action="{{ route('categorias.store') }}" class="my-4 mx-4" accept-charset="UTF-8"
            enctype="multipart/form-data">
            @csrf()  @include ('admin.categoria.form', ['formMode' => 'create'])
        </form>
    </div>
</section>
@endsection
