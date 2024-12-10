<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alenka SRL</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.ico') }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--<link rel="stylesheet" href="{{ asset('themes/style/style .css') }}">-->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/css/css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
      {{-- cards --}}
      <link rel="stylesheet" type="text/css"
      href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,400,500,600" rel="stylesheet" type="text/css">
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    {{-- jquery --}}

    {{-- DATATABLES --}}
    <link rel="stylesheet" href="{{ asset('css/DatatableBoostrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/DatatableButtons.css') }}">

    {{-- FONTWAWESONE --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"rossorigin="anonymous"
        referrerpolicy="no-referrer" />
</head>

<body>
    @include('sweetalert::alert')


    <div id="app">




        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto">

            </ul>
            <div class="d-flex justify-content-center">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @if (!Auth::check())
                        <li><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                        <li><a class="nav-link" href="{{ url('/register') }}">Registrar</a></li>
                    @else
                        <li class="nav-item dropdown">


                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        </nav>


        @extends('adminlte::page')
        @section('right-sidebar')
        <!-- Contenido para el sidebar derecho -->
        <div class="p-3">
            <h5>Contenido para el sidebar derecho</h5>
            <p>Aquí puedes poner cualquier contenido que desees mostrar en el sidebar derecho.</p>
        </div>
    @endsection

    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    {{-- DATATABLES --}}
    <script src="{{ asset('js/cdnDatatables.js') }}"></script>
    <script src="{{ asset('js/datatablesSelect.js') }}"></script>
    <script src="{{ asset('js/DatatablePrint.js') }}"></script>
    <script src="{{ asset('js/DatatableButtons.js') }}"></script>
    <script src="{{ asset('js/DatatableDateTime.js') }}"></script>
    <script src="{{ asset('js/DatatableBoostrap.js') }}"></script>
    <script src="{{ asset('js/datatables.js?v=125675dfhj676') }}" defer></script>

    <!-- Para usar los botones -->
    <script src="{{ asset('js/Jszip.js') }}"></script>
    <script src="{{ asset('js/Buttons.js') }}"></script>

    <!-- Para los estilos en Excel     -->
    <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.min.js">
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.templates.min.js">
    </script>
    <!-- Datepicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Datatables -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js">
    </script>
    {{-- ajax --}}
    <script src="{{ asset('js/accionesImportantes.js') }}"></script>
    <!-- Momentjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    {{-- SELECT2 --}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- borbujas --}}
    <script src="https://kit.fontawesome.com/b2e058effd.js" crossorigin="anonymous"></script>

    {{-- SWEETALERT2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.1/sweetalert2.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/tailwind.js') }}"></script>

    {{-- ELIMINACION SWEET ALERT --}}

    <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.min.js">
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.templates.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>
    <audio id="myAudio">
        <source src="{{ asset('sound/error.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="good">
        <source src="{{ asset('sound/success.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="pregunta">
        <source src="{{ asset('sound/pregunta.mp3') }}" type="audio/mpeg">
    </audio>

</body>

</html>
