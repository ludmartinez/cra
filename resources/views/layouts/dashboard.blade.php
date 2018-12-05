<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-blue.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/af-2.3.2/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-print-1.5.4/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"
    />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <link rel="shortcut icon" href="{{ asset('cra.ico') }}" type="image/x-icon">
    <title>CRA</title>
</head>

<body>
    <!-- The drawer is always open in large screens. The header is always shown,
  even in small screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
mdl-layout--fixed-header">
        <header class="mdl-layout__header">



@section('header')
            <div class="mdl-layout__header-row">
                <span class="mdl-layout-title">CRA</span>
                <div class="mdl-layout-spacer"></div>
                <!-- Botón de usuario -->
                <div class="btn-group">
                    <img src="{{ auth()->user()->usuario()[0]->foto }}" class="d-none d-md-block" style="max-height:3em" alt="foto de perfil">
                    <button type="button" class="btn btn-success">
                        {{ auth()->user()->usuario()[0]->primerNombre }}
                        {{ auth()->user()->usuario()[0]->apellidoPaterno }}
                    </button>
                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-user-edit"></i>
                            Editar Perfil
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-cog"></i>
                            Configuración
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out-alt"></i>
                            Cerrar Sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            @show
        </header>
        <aside class="mdl-layout__drawer">
            <div class="mdl-grid bg-dark">
                <div class="mdl-cell mdl-cell--10-col mdl-cell--1-offset-desktop">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('cra.ico') }}" class="img-fluid" alt="cra isotipo">
                    </a>
                </div>
            </div>
            <nav class="mdl-navigation">
                <a class="mdl-navigation__link @if ($segment=='alumnos') bg-info text-white @endif" href="{{ route( 'alumnos.index') }}">
                    <div class="form-inline">
                        <i class="fas fa-user-graduate mr-3 my-auto" style="width:2em; height:2em"></i>
                        <h5 class="my-auto">
                            Alumnos
                        </h5>
                    </div>
                </a>
                <a class="mdl-navigation__link @if ($segment=='docentes' ) bg-info text-white @endif" href="{{ route('docentes.index') }}">
                    <div class="form-inline">
                        <i class="fas fa-chalkboard-teacher mr-3 my-auto" style="width:2em; height:2em"></i>
                        <h5 class="my-auto">
                            Docentes
                        </h5>
                    </div>
                </a>
                @if (auth()->user()->usuario()[0]->superUsuario)
                <a class="mdl-navigation__link @if ($segment=='admins') bg-info text-white @endif" href="{{ route('admins.index') }}">
                    <div class="form-inline">
                        <i class="fas fa-user-cog mr-3 my-auto" style="width:2em; height:2em"></i>
                        <h5 class="my-auto">
                            Admins
                        </h5>
                    </div>
                </a>
                @endif
                <a class="mdl-navigation__link @if ($segment=='grados') bg-info text-white @endif" href="{{ route('grados.index') }}">
                    <div class="form-inline">
                        <i class="fas fa-list-ol mr-3 my-auto" style="width:2em; height:2em"></i>
                        <h5 class="my-auto">
                            Grados
                        </h5>
                    </div>
                </a>
                <a class=" mdl-navigation__link @if ($segment=='materias' ) bg-info text-white @endif" href="{{ route('materias.index') }}">
                    <div class="form-inline">
                        <i class="fas fa-book mr-3 my-auto" style="width:2em; height:2em"></i>
                        <h5 class="my-auto">
                            Materias
                        </h5>
                    </div>
                </a>
                <a class=" mdl-navigation__link @if ($segment=='periodos' ) bg-info text-white @endif" href="{{ route('periodos.index') }}">
                    <div class="form-inline">
                        <i class="fas fa-calendar-alt mr-3 my-auto" style="width:2em; height:2em"></i>
                        <h5 class="my-auto">
                            Períodos
                        </h5>
                    </div>
                </a>
                <a class="mdl-navigation__link @if ($segment=='matriculas' ) bg-info text-white @endif" href="">
                    <div class="form-inline">
                        <i class="fas fa-th-list mr-3 my-auto" style="width:2em; height:2em"></i>
                        <h5 class="my-auto">
                            Matrículas
                        </h5>
                    </div>
                </a>
            </nav>
        </aside>
        <main class="mdl-layout__content">
            <div class="page-content">
                <!-- Your content goes here -->
                @yield('contenido')
            </div>
            <footer class="mdl-mega-footer">
                <div class="mdl-mega-footer__middle-section">

                    <div class="mdl-mega-footer__drop-down-section">
                        <input class="mdl-mega-footer__heading-checkbox" type="checkbox" checked>
                        <h1 class="mdl-mega-footer__heading">Features</h1>
                        <ul class="mdl-mega-footer__link-list">
                            <li><a href="#">About</a></li>
                            <li><a href="#">Terms</a></li>
                            <li><a href="#">Partners</a></li>
                            <li><a href="#">Updates</a></li>
                        </ul>
                    </div>

                    <div class="mdl-mega-footer__drop-down-section">
                        <input class="mdl-mega-footer__heading-checkbox" type="checkbox" checked>
                        <h1 class="mdl-mega-footer__heading">Details</h1>
                        <ul class="mdl-mega-footer__link-list">
                            <li><a href="#">Specs</a></li>
                            <li><a href="#">Tools</a></li>
                            <li><a href="#">Resources</a></li>
                        </ul>
                    </div>

                    <div class="mdl-mega-footer__drop-down-section">
                        <input class="mdl-mega-footer__heading-checkbox" type="checkbox" checked>
                        <h1 class="mdl-mega-footer__heading">Technology</h1>
                        <ul class="mdl-mega-footer__link-list">
                            <li><a href="#">How it works</a></li>
                            <li><a href="#">Patterns</a></li>
                            <li><a href="#">Usage</a></li>
                            <li><a href="#">Products</a></li>
                            <li><a href="#">Contracts</a></li>
                        </ul>
                    </div>

                    <div class="mdl-mega-footer__drop-down-section">
                        <input class="mdl-mega-footer__heading-checkbox" type="checkbox" checked>
                        <h1 class="mdl-mega-footer__heading">FAQ</h1>
                        <ul class="mdl-mega-footer__link-list">
                            <li><a href="#">Questions</a></li>
                            <li><a href="#">Answers</a></li>
                            <li><a href="#">Contact us</a></li>
                        </ul>
                    </div>

                </div>

                <div class="mdl-mega-footer__bottom-section">
                    <div class="mdl-logo">Title</div>
                    <ul class="mdl-mega-footer__link-list">
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Privacy & Terms</a></li>
                    </ul>
                </div>

            </footer>
        </main>
    </div>

    <!-- Optional JavaScript -->
    <script defer src="https://use.fontawesome.com/releases/v5.4.1/js/all.js" integrity="sha384-L469/ELG4Bg9sDQbl0hvjMq8pOcqFgkSpwhwnslzvVVGpDjYJ6wJJyYjvG3u8XW7"
        crossorigin="anonymous"></script>
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    {{--
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    --}}
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.2/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.es6.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <script>
        function loadTable() {
            $('.listado').DataTable({
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                "language": {
                    "lengthMenu": "Mostrar _MENU_",
                    "zeroRecords": "No se encontró ningún resultado",
                    "info": "Página _PAGE_ de _PAGES_ de _TOTAL_ registros",
                    "infoEmpty": "Ningún resultado",
                    "infoFiltered": "(filtrado de _MAX_ registros)",
                    "decimal": ".",
                    "thousands": ",",
                    "paginate": {
                        "previous": "<",
                        "next": ">"
                    },
                    "processing": "Cargando registros ...",
                    "search": "Buscar:"
                }
            });
        }

        function marcar() {
            $("input[type='search']").on("keyup", function () {
                var keyword = $(this).val();
                options = {
                    "element": "span",
                    "className": "bg-warning",
                    "separateWordSearch": true
                };
                $ctx = $(".listado tbody tr td");
                $ctx.unmark({
                    done: function () {
                        $ctx.mark(keyword, options);
                    }
                });
            });
            $(".page-content").on('click', function () {
                $("input[type='search']").keyup();
            });
        }
        $(document).ready(function () {
            // inicia DataTable
            loadTable();
            // inicia Mark.js
            marcar();
        });
    </script>
    @yield('scripts')
</body>

</html>
