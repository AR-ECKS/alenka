@extends('layouts.app') @section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background: #f4f6f9;">
        <li class="breadcrumb-item">
            <a href="{{ route('compra.index') }}" >Compra</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Crear Compra</li>
    </ol>
</nav>
<section>
    <div class="card">
        <form method="POST"  action="{{ route('compra.store') }}" class="my-4 mx-4" accept-charset="UTF-8"
            enctype="multipart/form-data">
            @csrf()  @include ('admin.compra.form', ['formMode' => 'create'])
        </form>
    </div>
</section>
@endsection
