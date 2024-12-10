@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: #f4f6f9">
            <li class="breadcrumb-item"><a href="{{ route('proceso.index') }}">Proceso</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Proceso</li>
        </ol>
    </nav>
    <section>
        <div class="card">

            <form method="POST" action="{{ route('proceso.update', $proceso->id) }}"  enctype="multipart/form-data" class="my-4 mx-4">
                {{ method_field('PATCH') }}
                                {{ csrf_field() }}
                                @include ('admin.proceso.form', ['formMode' => 'edit'])
                                </form>
        </div>
    </section>
@endsection

