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
                            <form action="{{ route('users.store') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i> <b>Nombre Completo:</b> </div>
                                        </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="35" name="name" placeholder="Ej: Juan Perez">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i><b> CI:</b> </div>
                                        </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="35" name="ci" placeholder="Ej: 12345678">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i> <b>Nombre de Usuario:</b> </div>
                                        </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="35" name="username" placeholder="Ej: Juan Perez">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-user-edit" style="padding-right:5px"></i> <b>Correo Electronico:</b></div>
                                        </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroup" maxlength="35" name="email" placeholder="Ej: juan@gmail.com">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-key" style="padding-right:5px"></i> <b>Contraseña:</b></div>
                                        </div>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="">
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-key" style="padding-right:5px"></i><b> Confirmar Contraseña:</b></div>
                                        </div>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="operadorSwitch" name="operador">
                                            <label class="custom-control-label" for="operadorSwitch">Operador</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto" id="maquinaField" style="display: none;">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <label for="maquina">Número de Máquina:</label>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" id="maquina" name="maquina" placeholder="Ingrese el número de máquina">
                                    </div>
                                </div>

                                <script>
                                    // Script para manejar la visibilidad del campo 'maquina' basado en el switch 'operadorSwitch'
                                    const operadorSwitch = document.getElementById('operadorSwitch');
                                    const maquinaField = document.getElementById('maquinaField');

                                    operadorSwitch.addEventListener('change', function() {
                                        if (this.checked) {
                                            maquinaField.style.display = 'block';
                                        } else {
                                            maquinaField.style.display = 'none';
                                        }
                                    });
                                </script>


                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-users" style="padding-right:5px"></i> <b>Roles:</b></div>
                                        </div>
                                        <div class="col-md-9">
                                            @foreach ($roles as $id => $role)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="role_{{ $id }}" name="roles[]" value="{{ $role }}" onchange="handleRoleSelection(this)">
                                                <label class="form-check-label" for="role_{{ $id }}">
                                                    <span class="form-check-sign switch"></span>
                                                    {{ $role }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> <i class="fas fa-upload" style="padding-right:5px"></i><b>Subir Imagen:</b></div>
                                        </div>

                                        <input type="file" class="fileInpt" style="padding-top:0.3em;padding-left:0.3em" name="imagen" id="avatarInput" value="{{ isset($user->imagen) ? $user->imagen : '' }}">                                    </div>
                                </div>





                                <button type="submit" class="btn btn-primary" style="float: right;">Registrar Usuario</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const avatarInput = document.querySelector('#avatarInput');
        const avatarName = document.querySelector('.input-file__name');
        const imagePreview = document.querySelector('.image-preview');

        avatarInput.addEventListener('change', e => {
            let input = e.currentTarget;
            let fileName = input.files[0].name;
            avatarName.innerText = `Archivo: ${fileName}`;

            const fileReader = new FileReader();
            fileReader.addEventListener('load', e => {
                let imageData = e.target.result;
                imagePreview.setAttribute('src', imageData);
            })

            fileReader.readAsDataURL(input.files[0]);
        });

        function handleRoleSelection(checkbox) {
            if (checkbox.checked) {
                // Si se selecciona un rol, deshabilitar los demás
                disableOtherRoles(checkbox);
            } else {
                // Si se deselecciona, habilitar todos los roles
                enableAllRoles();
            }
        }

        function disableOtherRoles(selectedCheckbox) {
            var checkboxes = document.querySelectorAll('input[name="roles[]"]');
            checkboxes.forEach(function(checkbox) {
                if (checkbox !== selectedCheckbox) {
                    checkbox.disabled = true;
                }
            });
        }

        function enableAllRoles() {
            var checkboxes = document.querySelectorAll('input[name="roles[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.disabled = false;
            });
        }
    </script>

    <script>
        function validateInput() {
            var input = document.getElementById('name');
            var inputValue = input.value;

            // Permitir solo letras y espacios
            inputValue = inputValue.replace(/[^a-zA-Z\s]/g, '');



            // Actualizar el valor del campo de entrada
            input.value = inputValue;
        }
    </script>


    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var eyeIcon = document.getElementById('eye-icon');

            // Cambiar el tipo de entrada de contraseña a texto y viceversa
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';

            // Cambiar el icono del ojo
            eyeIcon.className = passwordInput.type === 'password' ? 'fas fa-eye-slash' : 'fas fa-eye';
        }

        function checkPasswordStrength() {
            var passwordInput = document.getElementById('password');
            var passwordStrengthBar = document.getElementById('password-strength-bar');
            var passwordStrengthText = document.getElementById('password-strength-text');

            // Evaluar la fortaleza de la contraseña
            var strength = 0;
            var regexList = [/[$@$!%*?&#]/, /[A-Z]/, /[0-9]/, /[a-z]/];

            for (var regex of regexList) {
                if (regex.test(passwordInput.value)) {
                    strength++;
                }
            }

            // Mostrar la barra de fortaleza con colores y longitud proporcionales
            passwordStrengthBar.style.width = (strength * 25) + '%';

            if (strength === 0) {
                passwordStrengthBar.style.backgroundColor = '';
                passwordStrengthText.textContent = '';
            } else if (strength <= 2) {
                passwordStrengthBar.style.backgroundColor = 'red';
                passwordStrengthText.textContent = '';
            } else if (strength <= 3) {
                passwordStrengthBar.style.backgroundColor = 'orange';
                passwordStrengthText.textContent = '';
            } else {
                passwordStrengthBar.style.backgroundColor = 'green';
                passwordStrengthText.textContent = '';
            }
        }
    </script>

    <style>
        .password-strength-bar {
            height: 5px;
            margin-top: 5px;
            transition: width 0.3s ease;
        }

        .password-strength-text {
            margin-top: 5px;
            font-size: 14px;
            color: #555;
        }
    </style>
    <script>
        function checkPasswordMatch() {
            var passwordInput = document.getElementById('password');
            var confirmPasswordInput = document.getElementById('password_confirmation');
            var passwordMatchError = document.getElementById('password-match-error');

            if (passwordInput.value !== confirmPasswordInput.value) {
                passwordMatchError.textContent = 'Las contraseñas no coinciden';
            } else {
                passwordMatchError.textContent = '';
            }
        }
    </script>
    <script>
        function togglePasswordVisibilityConfirmation() {
            var passwordConfirmationInput = document.getElementById('password_confirmation');
            var showPasswordConfirmationCheckbox = document.getElementById('showPasswordConfirmation');

            // Cambiar el tipo de entrada de contraseña a texto y viceversa
            passwordConfirmationInput.type = showPasswordConfirmationCheckbox.checked ? 'text' : 'password';
        }
    </script>

    <script>
        function handleInput(input) {
            updateUsername(input);
            validateNameInput(input);
        }

        function updateUsername(input) {
            var usernameInput = document.getElementById('username');
            var name = input.value.trim();

            // Obtener las iniciales de cada palabra en el nombre
            var initials = name.split(' ').map(word => word[0].toUpperCase()).join('');

            // Limitar la longitud de las iniciales a 5 caracteres
            if (initials.length > 5) {
                initials = initials.substring(0, 5);
            }

            // Establecer el valor del campo de nombre de usuario
            usernameInput.value = initials + '_';
        }

        function validateNameInput(input) {
            // Expresión regular que solo permite letras y espacios
            var regex = /^[A-Za-z\s]+$/;

            // Obtener el valor del campo de entrada
            var inputValue = input.value;

            // Verificar si el valor cumple con la expresión regular
            if (!regex.test(inputValue)) {
                // Si no cumple, mostrar un mensaje de error
                // alert('Por favor, introduzca solo letras y espacios en el campo de nombre.');
                // Limpiar el valor no válido
                input.value = inputValue.replace(/[^A-Za-z\s]+/, '');
            }
        }
    </script>
