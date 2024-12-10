@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background: #f4f6f9">
        <li class="breadcrumb-item active" aria-current="page">Editar rol</li>
    </ol>
</nav>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('roles.update', $role->id) }}" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <label for="name" class="col-sm-2 col-form-label">Nombre del rol:</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $role->name) }}" autocomplete="off" autofocus>
                                </div>
                            </div>
                            <div class="row">
                                <label for="name" class="col-sm-2 col-form-label">Permisos:</label>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="row">
                                            @foreach ($permissions as $category => $categoryPermissions)
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-header bg-primary text-white">
                                                            {{ $category }}
                                                        </div>
                                                        <div class="card-body">
                                                            @foreach ($categoryPermissions as $permission)
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="" type="checkbox" name="permissions[]"
                                                                               value="{{ $permission }}"
                                                                               {{ in_array($permission, $role->permissions->pluck('name')->toArray()) ? 'checked' : '' }}>
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                        {{ $permission }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group float-right">
                                <button type="submit" class="btn btn-primary">Guardar Rol</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
