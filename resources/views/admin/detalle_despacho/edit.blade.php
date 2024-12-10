@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: #f4f6f9">
            <li class="breadcrumb-item"><a href="{{ route('detalle_despacho.index') }}">Detalle_despacho</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Detalle_despacho</li>
        </ol>
    </nav>
    <section>
        <div class="card">

            <form method="POST" action="{{ route('detalle_despacho.update', $detalle_despacho->id) }}"  enctype="multipart/form-data" class="my-4 mx-4">
                {{ method_field('PATCH') }}
                                {{ csrf_field() }}
                                @include ('admin.detalle_despacho.form', ['formMode' => 'edit'])
                                </form>
        </div>
    </section>
@endsection

