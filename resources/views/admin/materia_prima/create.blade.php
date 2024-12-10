@extends('layouts.app') @section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background: #f4f6f9;">
        <li class="breadcrumb-item">
            <a href="{{ route('materia_prima.index') }}" >Materia_prima</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Crear Materia_prima</li>
    </ol>
</nav>
<section>
    <div class="card">
        <form method="POST"  action="{{ route('materia_prima.store') }}" class="my-4 mx-4" accept-charset="UTF-8"
            enctype="multipart/form-data">
            @csrf()  @include ('admin.materia_prima.form', ['formMode' => 'create'])
        </form>
    </div>
</section>
@endsection
