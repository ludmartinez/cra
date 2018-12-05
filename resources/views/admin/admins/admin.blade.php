@inject('helper', 'App\CustomHelpers\StringHelper')
@extends('layouts.dashboard')
@section('contenido')
<div class="row bg-secondary text-white">>
    <div class="col-12">
        <h3 class="text-center mx-auto mb-0">
            {{
            $helper->fullName($admin->primerNombre,$admin->segundoNombre,$admin->tercerNombre,$admin->apellidoPaterno,$admin->apellidoMaterno)
            }}
        </h3>
    </div>
    <div class="col text-center pb-2">
        @if ( $admin->estado == true )
        <span class="badge badge-success p-1">Activo</span>
        @else
        <span class="badge badge-danger p-1">Inactivo</span>
        @endif

        @if ( $admin->superUsuario == true )
        <span class="badge badge-info p-1">Master</span>
        @endif
    </div>
</div>

<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
    <div class="mdl-tabs__tab-bar sticky-top bg-light">
        <a href="#info-panel" class="mdl-tabs__tab is-active">
            <div class="form-inline position-relative mt-2 text-center">
                <i class="fas fa-info-circle h2 my-auto mr-md-2"></i>
                <p class="my-auto d-none d-md-block">
                    Información
                </p>
            </div>
        </a>
        <a href="#notas-panel" class="mdl-tabs__tab">
            <div class="form-inline position-relative mt-2">
                <i class="fas fa-award h2 my-0 my-auto mr-md-2"></i>
                <p class="my-auto d-none d-md-block">
                    Notas
                </p>
            </div>
        </a>
        <a href="#matriculas-panel" class="mdl-tabs__tab">
            <div class="form-inline position-relative mt-2">
                <i class="fas fa-th-list h2 my-auto mr-md-2"></i>
                <p class="my-auto d-none d-md-block">
                    Matrículas
                </p>
            </div>
        </a>
    </div>

    <div class="mdl-tabs__panel is-active p-2 container" id="info-panel">
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-12 col-md-4 col-lg-3 col-xl-3 text-center">
                        @if ($admin->foto!=null)
                        <img src="{{ $admin->foto }}" alt="Foto de Alumno" class="img-fluid rounded" style="max-height:17em">
                        @else
                        <img src="{{ asset('img/foto-perfil.jpg') }}" alt="Foto" class="img-fluid rounded"> @endif
                    </div>
                    <div class="col">
                        <h4 class="m-0"><small>Perfil</small></h4>
                        <hr class="m-0">
                        <div class="form-row">
                            <div class="col-12 col-md-4 mt-2">
                                <label for="txt_primerNombre">Primer Nombre</label>
                                <input type="text" class="form-control" id="txt_primerNombre" value="{{ $admin->primerNombre }}"
                                    readonly>
                            </div>
                            <div class="col-12 col-md-4 mt-2">
                                <label for="txt_segundoNombre">Segundo Nombre</label>
                                <input type="text" class="form-control" id="txt_segundoNombre" value="{{ $admin->segundoNombre }}"
                                    readonly>
                            </div>
                            <div class="col-12 col-md-4 mt-2">
                                <label for="txt_tercerNombre">Tercer Nombre</label>
                                <input type="text" class="form-control" id="txt_tercerNombre" value="{{ $admin->tercerNombre }}"
                                    readonly>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <label for="txt_apellidoPaterno">Apellido Paterno</label>
                                <input type="text" class="form-control" id="txt_apellidoPaterno" value="{{ $admin->apellidoPaterno }}"
                                    readonly>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <label for="txt_apellidoMaterno">Apellido Materno</label>
                                <input type="text" class="form-control" id="txt_apellidoMaterno" value="{{ $admin->apellidoMaterno }}"
                                    readonly>
                            </div>
                            <div class="col-12 col-md mt-2">
                                <label for="txt_sexo">Sexo</label>
                                <input type="text" class="form-control" id="txt_sexo" value="{{ $admin->sexo }}"
                                    readonly>
                            </div>
                            <div class="col-12 col-md mt-2">
                                <label for="dtp_fechaNacimiento">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="dtp_fechaNacimiento" value="{{ $admin->fechaNacimiento }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-sm">
                        <h4 class="m-0"><small>Acceso</small></h4>
                        <hr class="m-0">
                        <div class="form-row">
                            <div class="col-12 col-md mt-2">
                                <label for="txt_user">Usuario</label>
                                <input type="text" class="form-control" name="usuario" id="txt_user" value="{{ $user->usuario }}"
                                    readonly>
                            </div>
                            <div class="col-12 col-md mt-2">
                                <label for="txt_password">Contraseña</label>
                                <input type="text" class="form-control" name="password" id="txt_password" value="{{ substr(md5($admin->carnet), -8) }}"
                                    readonly>
                            </div>
                            <div class="col-12 col-md-12 mt-2">
                                <label for="txt_email">Email</label>
                                <input type="email" class="form-control" name="email" id="txt_email" value="{{ $user->email }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <h4 class="m-0"><small>Institucional</small></h4>
                        <hr class="m-0">
                        <div class="form-row">
                            <div class="col-12 col-md mt-2">
                                <label for="txt_carnet">Carnet</label>
                                <input type="text" class="form-control" id="txt_carnet" value="{{ $admin->carnet }}"
                                    readonly>
                            </div>
                            <div class="col-12 col-md mt-2">
                                <label for="txt_dui">DUI</label>
                                <input type="text" class="form-control" id="txt_dui" value="{{ $admin->dui }}"
                                    readonly>
                            </div>
                            <div class="col-12 col-md mt-2">
                                <label for="dtp_fechaIngreso">Fecha de Ingreso</label>
                                <input type="date" class="form-control" id="dtp_fechaIngreso" value="{{ $admin->fechaIngreso }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mdl-tabs__panel" id="notas-panel">
        <ul>
            <li>Tywin</li>
            <li>Cersei</li>
            <li>Jamie</li>
            <li>Tyrion</li>
        </ul>
    </div>
    <div class="mdl-tabs__panel" id="matriculas-panel">
        <ul>
            <li>Viserys</li>
            <li>Daenerys</li>
        </ul>
    </div>
</div>
<style>
    #btnEditarDocente {
        position: fixed;
        display: block;
        right: 0;
        bottom: 0;
        margin-right: 30px;
        margin-bottom: 30px;
        z-index: 900;
    }

</style>
<!-- Colored FAB button with ripple -->
<a id="btnEditarDocente" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bg-warning mdl-color-text--white"
    href="{{ route('admins.edit', $admin) }}">
    <i class="material-icons">edit</i>
</a>
@endsection
