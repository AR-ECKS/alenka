@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: #f4f6f9">
            <li class="breadcrumb-item"><a href="{{ route('produccion.index') }}">Produccion</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Produccion</li>
        </ol>
    </nav>
    <section>
        <div class="card">

            <form method="POST" action="{{ route('produccion.update', $produccion->id) }}"  enctype="multipart/form-data" class="my-4 mx-4">
                {{ method_field('PATCH') }}
                                {{ csrf_field() }}
                                @include ('admin.produccion.form', ['formMode' => 'edit'])
                                </form>
        </div>
    </section>
@endsection

