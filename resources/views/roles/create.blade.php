<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
        background-color: #ccc;
        border-radius: 20px;
        transition: background-color 0.3s;
        cursor: pointer;
        /* Mover el cursor aquí en lugar de en el label */
    }

    .switch:before {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background-color: white;
        top: 1px;
        left: 1px;
        transition: transform 0.3s;
    }

    .category-switch:checked+.switch:before {
        transform: translateX(20px);
    }

    .category-switch:checked+.switch {
        background-color: #1ab394;
    }
</style>

<!-- Modal Crear-->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">


        <div class="modal-content modal-blur">
            <div class="modal-header bg-primary ">
                <h5 class="modal-title " id="exampleModalLabel" style="color:white">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('roles.store') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <label for="name" class="col-sm-6 col-form-label">Nombre del rol:</label>

                            <div class="form-group">
                                <input type="text" class="form-control" name="name" autocomplete="off" maxlength="20" required autofocus oninput="this.value = this.value.toUpperCase();">
                            </div>
                            {{-- <form action="{{ route('roles.store') }}" method="POST">
                            @csrf --}}
                            <!-- Otras campos del formulario -->
                            <div class="row">
                                @foreach ($permissions as $category => $categoryPermissions)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            {{ $category }}
                                            <div class="float-right">
                                                <input type="checkbox" class="category-switch" data-category="{{ $category }}" id="{{ $category }}" style="display: none;">
                                                <label class="switch" for="{{ $category }}" style="cursor: pointer;"></label>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($categoryPermissions as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission }}" data-category="{{ $category }}" id="{{ $permission }}" disabled>
                                                <label class="form-check-label" for="{{ $permission }}">
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



                <!--Footer-->
                <div class="card-footer ml-auto mr-auto">
                    <button type="submit" class="btn btn-primary">Crear Rol</button>
                </div>
                <!--End footer-->
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Manejar el cambio en el interruptor de la categoría
        $('.category-switch').on('change', function() {
            var categoryName = $(this).data('category');
            var isChecked = $(this).prop('checked');

            // Encontrar todos los checkboxes dentro de la categoría y habilitar/deshabilitar
            var categoryCheckboxes = $('[data-category="' + categoryName + '"]').not('.category-switch');
            categoryCheckboxes.prop('checked', isChecked).prop('disabled', false);

            // Deshabilitar todos los checkboxes en la categoría si el interruptor de la categoría está desmarcado
            if (!isChecked) {
                categoryCheckboxes.prop('disabled', true);
            }

            // Habilitar/deshabilitar el botón según sea necesario
            $('.btn-primary').prop('disabled', !$('[data-category="' + categoryName + '"]:checked').length > 0);
        });

        // Manejar el clic en los checkboxes individuales
        $('.form-check-input').on('click', function() {
            var categoryName = $(this).data('category');

            // Desactivar el interruptor de la categoría si todos los checkboxes están desmarcados
            var categoryCheckboxes = $('[data-category="' + categoryName + '"]').not('.category-switch');
            $('[data-category="' + categoryName + '"].category-switch').prop('checked', categoryCheckboxes.is(':checked'));

            // Habilitar/deshabilitar el botón según sea necesario
            $('.btn-primary').prop('disabled', !$('.form-check-input:checked').length > 0);
        });
    });
</script>
