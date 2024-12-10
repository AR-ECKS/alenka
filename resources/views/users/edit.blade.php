@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background: #f4f6f9">
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar Usuario</li>
    </ol>
</nav>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card">

                        <div class="card-body">

                        <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i> <b>Nombre Completo:</b> </div>
                                        </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="35" name="name" placeholder="Ej: Juan Perez" value="{{ old('name', $user->name) }}">
                                    </div>
                                </div>

                        <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i> <b>Nombre de Usuario:</b> </div>
                                        </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="35" name="name" placeholder="Ej: Juan Perez" value="{{ old('name', $user->username) }}">
                                    </div>
                                </div>

                        <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i> <b>Correo:</b> </div>
                                        </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="35" name="name" placeholder="Ej: Juan Perez" value="{{ old('name', $user->email) }}">
                                    </div>
                                </div>
                        <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i> <b>Contraseña:</b> </div>
                                        </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="35" name="name" placeholder="Ej: Juan Perez" value="{{ old('name', $user->password) }}">
                                    </div>
                                </div>



                        <div class="col-auto">
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <div class="input-group-text"> <i class="fas fa-users" style="padding-right:5px"></i> <b>Roles:</b></div>
        </div>
        <div class="col-md-9">
            @foreach ($roles as $id => $role)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="role_{{ $id }}" name="roles[]" value="{{ $role }}" @if (in_array($id, $userRoles)) checked @endif onchange="handleRoleSelection(this)">
                <label class="form-check-label" for="role_{{ $id }}">
                    <span class="form-check-sign switch"></span>
                    {{ $role }}
                </label>
            </div>
            @endforeach
        </div>
    </div>
</div><div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-upload" style="padding-right:5px"></i><b>Subir Imagen:</b></div>
                                        </div>

                                        <input type="file" class="fileInpt" style="padding-top:0.3em;padding-left:0.3em" name="imagen" id="avatarInput" value="{{ isset($user->imagen) ? $user->imagen : '' }}">                                    </div>
                                </div>





                    <!--Footer-->
                    <div class="card-footer ml-auto mr-auto float-right">
                        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                    </div>
                    <!--End footer-->
            </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
