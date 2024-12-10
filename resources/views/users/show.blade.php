@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="background: #f4f6f9">
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ver Usuario </li>
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
                <div class="card card-user">
                  <div class="card-body">
                    <p class="card-text">
                    <div class="author">
                      <a href="#">
                      <img src="{{ asset('storage').'/'.$user->imagen}}" alt="">

                        <h5 class="title mt-3">{{ $user->name }}</h5>
                      </a>
                      <p class="description">
                        {{ $user->username }} <br>
                        {{ $user->email }} <br>
                        {{ $user->created_at }}
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
              </div><!--end card user-->


              <!--Start third-->
              <div class="col-md-4">
                <div class="card card-user">
                  <div class="card-body">
                    <table class="table table-bordered table-striped">
                      <tbody>
                        <tr>
                          <th>ID</th>
                          <td>{{ $user->id }}
                          </td>
                        </tr>
                        <tr>
                          <th>Name</th>
                          <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                          <th>Email</th>
                          <td><span class="badge badge-primary">{{ $user->email }}</span></td>
                        </tr>
                        <tr>
                          <th>Username</th>
                          <td>{!! $user->username !!}</td>
                        </tr>
                        <tr>
                          <th>Created at</th>
                          <td><a href="#" target="_blank">{{ $user->created_at  }}</a></td>
                        </tr>
                        <tr>
                          <th>Roles</th>
                          <td>
                            @forelse ($user->roles as $role)
                            <span class="badge rounded-pill bg-dark text-white">{{ $role->name }}</span>
                            @empty
                            <span class="badge badge-danger bg-danger">No roles</span>
                            @endforelse
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer">
                    {{-- <div class="button-container">
                      <a href="{{ route('users.index') }}" class="btn btn-sm btn-success mr-3"> Volver </a>
                    <a href="#" class="btn btn-sm btn-twitter"> Editar </a>
                  </div> --}}
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