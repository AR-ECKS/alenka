@extends('layouts.app')
@section('content')
    @if (session()->has('correcto'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Operación Realizada con éxito",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "ocurrio un error",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>
    @endif
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2 ">

                    </div>
                    <div class="card-body p-3">
                        <div class="float-right mt-3">
                            @can('crear_subcategoria')
                                <a type="button" class="btn btn-primary text-white" href="{{ route('subcategorias.create') }}">
                                    <i class="fas fa-database"></i> Nuevo Subcategoria
                                </a>
                            @endcan
                        </div>
                        <br><br><br>
                        <div class="tab-content">
                            <div class="table-responsive-xl">



                                <table class="table table-sm text-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Descripcion</th>
                                            <th>Categoria Id</th>
                                            <th>Estado</th>
                                            <th class="text-right">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subcategoria as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nombre }}</td>
                                                <td>{{ $item->descripcion }}</td>
                                                <td>{{ $item->categoria_id }}</td>
                                                <td>
                                                    @if ($item->estado == 1)
                                                        <span class="badge bg-warning">Activo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactivo</span>
                                                    @endif
                                                <td class="td-actions text-right">
                                                    @if ($item->estado == 1)
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-info btn-sm dropdown-toggle"
                                                                style="background: #007bff" item="button"
                                                                id="dropdownMenuLink" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-cog"></i> Acciones
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">

                                                                @can('ver_subcategoria')
                                                                    <a href="{{ route('subcategorias.show', $item->id) }}"
                                                                        title="View Subcategorium" class="dropdown-item"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Ver detalles">
                                                                        <i class="far fa-eye"> </i> Ver detalles
                                                                    </a>
                                                                @endcan

                                                                @can('editar_subcategoria')
                                                                <a href="{{ route('subcategorias.edit', $item->id) }}"
                                                                    title="Edit Subcategorium" class="dropdown-item"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Editar">
                                                                    <i class="fas fa-edit"> </i> Editar
                                                                </a>
                                                                @endcan

                                                                @can('eliminar_subcategoria')
                                                                <form
                                                                    action="{{ route('subcategorias.destroy', $item->id) }}"
                                                                    method="POST" class="eliminate"
                                                                    style="display: inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item esd delete-button"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Eliminar">
                                                                        <i class="fas fa-trash"></i> Eliminar
                                                                    </button>
                                                                </form>
                                                                @endcan
                                                            </div>
                                                        @else
                                                        @can('restaurar_subcategoria')

                                                            <a href="{{ route('subcategoria.reingresar', $item->id) }}"
                                                                class="btn-sm btn-dark" data-toggle="tooltip"
                                                                data-placement="top" title="Restaurar">
                                                                <i class="fas fa-undo"></i>
                                                            </a>
                                                            @endcan
                                                    @endif
                            </div>
                            </td>
                            </tr>
                            @endforeach
                            </tbody>
                            </table>



                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".table").DataTable({
                lengthMenu: [10, 25, 50],
                order: [

                    [3, "asc"],
                ],
                language: {
                    decimal: "",
                    emptyTable: "No hay datos",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(Filtro de _MAX_ total registros)",
                    infoPostFix: "",
                    thousands: ",",
                    lengthMenu: "Mostrar _MENU_ registros",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    search: "Buscar:",
                    zeroRecords: "No se encontraron coincidencias",

                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>',
                    },
                    aria: {
                        sortAscending: ": Activar orden de columna ascendente",
                        sortDescending: ": Activar orden de columna desendente",
                    },
                },

            });
        });
    </script>
@endsection
