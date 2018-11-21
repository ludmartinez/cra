@extends('layouts.dashboard')
@section('contenido')
<style>
    .card-header {
        cursor: pointer;
        color: #17a2b8;
    }

    .card-header:hover {
        color: white;
        background-color: #17a2b8;
    }
</style>
<section class="container my-2">
    <h3 class="text-center text-sm-left">Editar Alumno <small><a href="{{ route('alumnos.show', $alumno) }}">{{
                $alumno->carnet }}</a></small></h3>
    <hr>
    <form class="accordion" id="formAlumno">
        <div class="card">
            <div class="card-header" id="headingPerfil" data-toggle="collapse" data-target="#collapsePerfil"
                aria-expanded="true" aria-controls="collapsePerfil">
                <div class="form-inline">
                    <i class="fas fa-address-card h2 mb-0 mr-2"></i>
                    <h5 class="my-0">
                        Perfil
                    </h5>
                </div>
            </div>

            <div id="collapsePerfil" class="collapse show" aria-labelledby="headingPerfil" data-parent="#formAlumno">
                <div class="card-body">
                    @csrf @method('PUT')
                    <div class="form-row">
                        <!--seccion foto-->
                        <div class="col-12 col-md-4 col-lg-3 mb-3">
                            <!-- foto del estudiante -->
                            <div class="form-row card py-2 bg-light">
                                <div class="col-12 mb-1 text-center" id="contenedor-foto">
                                    <img src="{{ $alumno->foto }}" id="foto-preview" alt="Foto" class="img-fluid" style="max-height:16.7em">
                                </div>
                                <div class="col-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="foto" name="foto" lang="es"
                                            accept="image/*" capture="camera">
                                        <label class="custom-file-label" for="foto">Escoga un archivo</label>
                                        <div class="invalid-feedback" id="invalid_foto">
                                            ¡Incorrecto!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- seccion inputs -->
                        <div class="col-12 col-md col-lg">
                            <div class="form-row">
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="carnet">Carnet</label>
                                    <input type="text" id="carnet" name="carnet" class="form-control" placeholder="carnet"
                                        value="{{ $alumno->carnet }}" disabled>
                                    <div id="invalid_carnet" class="invalid-feedback">
                                        ¡Incorrecto!
                                    </div>
                                </div>
                            </div>
                            <!-- nombres -->
                            <div class="form-row">
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="primerNombre">Primer Nombre</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="primerNombre" name="primerNombre"
                                            placeholder="Primer Nombre" required value="{{ $alumno->primerNombre }}"
                                            disabled>
                                        <div class="input-group-prepend">
                                            <button class="btn btn-info" type="button" onclick="editar('primerNombre')"><i
                                                    class="fas fa-pen"></i></button>
                                        </div>
                                        <div id="invalid_primer_nombre" class="invalid-feedback">
                                            ¡Incorrecto!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="segundoNombre">Segundo Nombre</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="segundoNombre" name="segundoNombre"
                                            placeholder="Segundo Nombre" value="{{ $alumno->segundoNombre }}" disabled>
                                        <div class="input-group-prepend">
                                            <button class="btn btn-info" type="button" onclick="editar('segundoNombre')"><i
                                                    class="fas fa-pen"></i></button>
                                        </div>
                                        <div id="invalid_segundo_nombre" class="invalid-feedback">
                                            ¡Incorrecto!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="tercerNombre">Tercer Nombre</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="tercerNombre" name="tercerNombre"
                                            placeholder="Tercer Nombre" value="{{ $alumno->tercerNombre }}" disabled>
                                        <div class="input-group-prepend">
                                            <button class="btn btn-info" type="button" onclick="editar('tercerNombre')"><i
                                                    class="fas fa-pen"></i></button>
                                        </div>
                                        <div id="invalid_tercer_nombre" class="invalid-feedback">
                                            ¡Incorrecto!
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- apellidos -->
                            <div class="form-row">
                                <div class="col-md mb-3">
                                    <label for="apellidoPaterno">Apellido Paterno</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno"
                                            placeholder="Apellido Paterno" required value="{{ $alumno->apellidoPaterno }}"
                                            disabled>
                                        <div class="input-group-prepend">
                                            <button class="btn btn-info" type="button" onclick="editar('apellidoPaterno')"><i
                                                    class="fas fa-pen"></i></button>
                                        </div>
                                        <div id="invalid_apellido_paterno" class="invalid-feedback">
                                            ¡Incorrecto!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md mb-3">
                                    <label for="apellidoMaterno">Apellido Materno</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno"
                                            placeholder="Apellido Materno" required value="{{ $alumno->apellidoMaterno }}"
                                            disabled>
                                        <div class="input-group-prepend">
                                            <button class="btn btn-info" type="button" onclick="editar('apellidoMaterno')"><i
                                                    class="fas fa-pen"></i></button>
                                        </div>
                                        <div id="invalid_apellido_materno" class="invalid-feedback">
                                            ¡Incorrecto!
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- nacimiento -->
                            <div class="form-row">
                                <div class="col-12 col-md mb-3">
                                    <label for="sexo">Sexo</label>
                                    <div class="input-group">
                                        <select name="sexo" id="sexo" class="form-control" disabled>
                                            <option value="">-- Seleccionar --</option>

                                            <option value="Femenino" @if ($alumno->sexo === 'Femenino') selected
                                                @endif>Femenino</option>
                                            <option value="Masculino" @if ($alumno->sexo === 'Masculino') selected
                                                @endif>Masculino</option>
                                        </select>
                                        <div class="input-group-prepend">
                                            <button class="btn btn-info" type="button" onclick="editar('sexo')"><i
                                                    class="fas fa-pen"></i></button>
                                        </div>
                                        <div id="invalid_sexo" class="invalid-feedback">
                                            ¡Incorrecto!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md mb-3">
                                    <label for="fechaNacimiento">Fecha de Nacimiento</label>
                                    <div class="input-group">
                                        <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="form-control"
                                            value="{{ $alumno->fechaNacimiento }}" disabled>
                                        <div class="input-group-prepend">
                                            <button class="btn btn-info" type="button" onclick="editar('fechaNacimiento')"><i
                                                    class="fas fa-pen"></i></button>
                                        </div>
                                        <div id="invalid_fecha_nacimiento" class="invalid-feedback">
                                            ¡Incorrecto!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingInstitucional" data-toggle="collapse" data-target="#collapseInstitucional"
                aria-expanded="true" aria-controls="collapseInstitucional">
                <div class="form-inline">
                    <i class="fas fa-university h2 mb-0 mr-2"></i>
                    <h5 class="my-0">
                        Institucional
                    </h5>
                </div>
            </div>
            <div id="collapseInstitucional" class="collapse" aria-labelledby="headingInstitucional" data-parent="#formAlumno">
                <div class="card-body">
                    <div class="form-row">
                        <!-- nie -->
                        <div class="col-12 col-md-4 mb-3">
                            <label for="nie">NIE</label>
                            <div class="input-group">
                                <input type="number" id="nie" name="nie" class="form-control" placeholder="nie" value="{{ $alumno->nie }}"
                                    disabled>
                                <div class="input-group-prepend">
                                    <button class="btn btn-info" type="button" onclick="editar('nie')"><i class="fas fa-pen"></i></button>
                                </div>
                                <div id="invalid_nie" class="invalid-feedback">
                                    ¡Incorrecto!
                                </div>
                            </div>
                        </div>
                        <!-- fecha de ingreso-->
                        <div class="col-12 col-md mb-3">
                            <label for="fechaIngreso">Fecha de Ingreso</label>
                            <div class="input-group">
                                <input type="date" id="fechaIngreso" name="fechaIngreso" class="form-control" value="{{ $alumno->fechaIngreso }}"
                                    disabled>
                                <div class="input-group-prepend">
                                    <button class="btn btn-info" type="button" onclick="editar('fechaIngreso')"><i
                                            class="fas fa-pen"></i></button>
                                </div>
                                <div id="invalid_fecha_ingreso" class="invalid-feedback">
                                    ¡Incorrecto!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-md">
                            <label for="solvencia">Solvencia</label>
                            <div class="input-group">
                                <select id="solvencia" name="solvencia" class="form-control" disabled>
                                    <option value="1" @if ($alumno->solvencia == true)
                                        selected
                                        @endif>Solvente</option>
                                    <option value="0" @if ($alumno->solvencia == false)
                                        selected
                                        @endif>Insolvente</option>
                                </select>
                                <div class="input-group-prepend">
                                    <button class="btn btn-info" type="button" onclick="editar('solvencia')"><i class="fas fa-pen"></i></button>
                                </div>
                                <div id="invalid_solvencia" class="invalid-feedback">
                                    ¡Incorrecto!
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md">
                            <label for="estado">Estado</label>
                            <div class="input-group">
                                <select id="estado" name="estado" class="form-control" disabled>
                                    <option value="1" @if ($alumno->estado == true)
                                        selected
                                        @endif>Activo</option>
                                    <option value="0" @if ($alumno->estado == false)
                                        selected
                                        @endif>Inactivo</option>
                                </select>
                                <div class="input-group-prepend">
                                    <button class="btn btn-info" type="button" onclick="editar('estado')"><i class="fas fa-pen"></i></button>
                                </div>
                                <div id="invalid_estado" class="invalid-feedback">
                                    ¡Incorrecto!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingAcceso" data-toggle="collapse" data-target="#collapseAcceso"
                aria-expanded="false" aria-controls="collapseAcceso">
                <div class="form-inline">
                    <i class="fas fa-door-open h2 mb-0 mr-2"></i>
                    <h5 class="my-0">
                        Acceso
                    </h5>
                </div>
            </div>
            <div id="collapseAcceso" class="collapse" aria-labelledby="headingAcceso" data-parent="#formAlumno">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-12 col-md">
                            <label for="usuario">Usuario</label>
                            <div class="input-group">
                                <input type="text" id="usuario" name="usuario" class="form-control" value="{{ $alumno->user->usuario }}"
                                    disabled>
                                <div class="input-group-prepend">
                                    <button class="btn btn-info" type="button" onclick="editar('usuario')"><i class="fas fa-pen"></i></button>
                                </div>
                                <div id="invalid_usuario" class="invalid-feedback">
                                    ¡Incorrecto!
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md">
                            <label for="usuario">Email</label>
                            <div class="input-group">
                                <input type="text" id="email" name="email" class="form-control" value="{{ $alumno->user->email }}"
                                    disabled>
                                <div class="input-group-prepend">
                                    <button class="btn btn-info" type="button" onclick="editar('email')"><i class="fas fa-pen"></i></button>
                                </div>
                                <div id="invalid_email" class="invalid-feedback">
                                    ¡Incorrecto!
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md">
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                <input type="text" id="password" name="password" class="form-control" value="{{ $alumno->user->password }}"
                                    disabled>
                                <div class="input-group-prepend">
                                    <button class="btn btn-info" type="button" onclick="editar('password')"><i class="fas fa-pen"></i></button>
                                </div>
                                <div id="invalid_password" class="invalid-feedback">
                                    ¡Incorrecto!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="mt-3">
        <div id="loading" class="mdl-progress mdl-js-progress mdl-progress__indeterminate d-none" style="width:100%"></div>
        <a class="btn btn-block btn-warning" type="submit">Editar</a>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function editar(input) {
        $('#' + input).removeAttr('disabled');
        $('#' + input).focus();
        $('#' + input).select();
    }

    $(function () {
        $("input[type=file]").change(function () {
            readURL(this);
        });
        const readURL = (input) => {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    $('#foto-preview').attr('src', e.target.result);
                    // $('#container-logo').css('display', 'block');
                }
                reader.readAsDataURL(input.files[0]);
            }
        };
    });

    $('a[type="submit"]').click(function (event) {
        event.preventDefault();
        var token = $('input[name="_token"]').val();
        var route = "{{ route('alumnos.update', $alumno) }}";
        var datos = new FormData();
        datos.append('carnet', '{{ $alumno->carnet }}');
        datos.append('_method', $('input[name="_method"]').val());
        if (!$('#nie').attr('disabled')) {
            datos.append('nie', $('#nie').val());
        }
        if ($('#foto')[0].files[0] != undefined) {
            datos.append('foto', $('#foto')[0].files[0]);
        }
        if (!$('#primerNombre').attr('disabled')) {
            datos.append('primerNombre', $('#primerNombre').val());
        }
        if (!$('#segundoNombre').attr('disabled')) {
            datos.append('segundoNombre', $('#segundoNombre').val());
        }
        if (!$('#tercerNombre').attr('disabled')) {
            datos.append('tercerNombre', $('#tercerNombre').val());
        }
        if (!$('#apellidoPaterno').attr('disabled')) {
            datos.append('apellidoPaterno', $('#apellidoPaterno').val());
        }
        if (!$('#apellidoMaterno').attr('disabled')) {
            datos.append('apellidoMaterno', $('#apellidoMaterno').val());
        }
        if (!$('#sexo').attr('disabled')) {
            datos.append('sexo', $('#sexo').val());
        }
        if (!$('#fechaNacimiento').attr('disabled')) {
            datos.append('fechaNacimiento', $('#fechaNacimiento').val());
        }
        if (!$('#fechaIngreso').attr('disabled')) {
            datos.append('fechaIngreso', $('#fechaIngreso').val());
        }
        if (!$('#solvencia').attr('disabled')) {
            datos.append('solvencia', $('#solvencia').val());
        }
        if (!$('#estado').attr('disabled')) {
            datos.append('estado', $('#estado').val());
        }
        if (!$('#usuario').attr('disabled')) {
            datos.append('usuario', $('#usuario').val());
        }
        if (!$('#email').attr('disabled')) {
            datos.append('email', $('#email').val());
        }
        if (!$('#password').attr('disabled')) {
            datos.append('password', $('#password').val());
        }


        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': token
            },
            type: 'POST',
            contentType: false,
            processData: false,
            cache: false,
            data: datos,
            beforeSend: function () {
                $('form#formAlumno input').removeClass('is-invalid');
                $('form#formAlumno select').removeClass('is-invalid');
                // $('#formAlumno').removeClass('was-validated');
                $('#loading').removeClass('d-none');
            },
            success: function (response) {
                $('#loading').addClass('d-none');
                console.log(response);
                // console.log(response.alumno.carnet);
                $('form#formAlumno input').attr('disabled', true);
                $('form#formAlumno select').attr('disabled', true);
                $('#foto').removeAttr('disabled');

                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                if (response.warning != undefined) {
                    toastr.info('No hay datos para modificar', '¿Qué pasa?');
                } else {
                    toastr.success('Registro editado con éxito.', '¡En hora buena!');
                }
            },
            error: function (msj) {
                console.log(msj);
                $('#loading').addClass('d-none');
                if ((msj.responseJSON.errors.nie != undefined) && (!$('#nie').attr('disabled'))) {
                    $('#nie').addClass('is-invalid');
                    $('#invalid_nie').html(msj.responseJSON.errors.nie);
                    $('#collapseInstitucional').addClass('show');
                } else {
                    $('#nie').attr('disabled', true);
                }
                if (msj.responseJSON.errors.primerNombre != undefined && (!$('#primerNombre').attr(
                        'disabled'))) {
                    $('#primerNombre').addClass('is-invalid');
                    $('#invalid_primer_nombre').html(msj.responseJSON.errors.primerNombre);
                    $('#collapsePerfil').addClass('show');
                } else {
                    $('#primerNombre').attr('disabled', true);
                }
                if (msj.responseJSON.errors.segundoNombre != undefined && (!$('#segundoNombre').attr(
                        'disabled'))) {
                    $('#segundoNombre').addClass('is-invalid');
                    $('#invalid_segundo_nombre').html(msj.responseJSON.errors.segundoNombre);
                    $('#collapsePerfil').addClass('show');
                } else {
                    $('#segundoNombre').attr('disabled', true);
                }
                if (msj.responseJSON.errors.tercerNombre != undefined && (!$('#tercerNombre').attr(
                        'disabled'))) {
                    $('#tercerNombre').addClass('is-invalid');
                    $('#invalid_tercer_nombre').html(msj.responseJSON.errors.tercerNombre);
                    $('#collapsePerfil').addClass('show');
                } else {
                    $('#tercerNombre').attr('disabled', true);
                }
                if (msj.responseJSON.errors.apellidoMaterno != undefined && (!$('#apellidoMaterno')
                        .attr('disabled'))) {
                    $('#apellidoMaterno').addClass('is-invalid');
                    $('#invalid_apellido_materno').html(msj.responseJSON.errors.apellidoMaterno);
                    $('#collapsePerfil').addClass('show');
                } else {
                    $('#apellidoMaterno').attr('disabled', true);
                }
                if (msj.responseJSON.errors.apellidoPaterno != undefined && (!$('#apellidoPaterno')
                        .attr('disabled'))) {
                    $('#apellidoPaterno').addClass('is-invalid');
                    $('#invalid_apellido_paterno').html(msj.responseJSON.errors.apellidoPaterno);
                    $('#collapsePerfil').addClass('show');
                } else {
                    $('#apellidoPaterno').attr('disabled', true);
                }
                if (msj.responseJSON.errors.fechaNacimiento != undefined && (!$('#fechaNacimiento')
                        .attr('disabled'))) {
                    $('#fechaNacimiento').addClass('is-invalid');
                    $('#invalid_fecha_nacimiento').html(msj.responseJSON.errors.fechaNacimiento);
                    $('#collapsePerfil').addClass('show');
                } else {
                    $('#fechaNacimiento').attr('disabled', true);
                }
                if (msj.responseJSON.errors.sexo != undefined && (!$('#sexo').attr('disabled'))) {
                    $('#sexo').addClass('is-invalid');
                    $('#invalid_sexo').html(msj.responseJSON.errors.sexo);
                    $('#collapsePerfil').addClass('show');
                } else {
                    $('#sexo').attr('disabled', true);
                }
                if (msj.responseJSON.errors.fechaIngreso != undefined && (!$('#fechaIngreso').attr(
                        'disabled'))) {
                    $('#fechaIngreso').addClass('is-invalid');
                    $('#invalid_fecha_ingreso').html(msj.responseJSON.errors.fechaIngreso);
                    $('#collapseInstitucional').addClass('show');
                } else {
                    $('#fechaIngreso').attr('disabled', true);
                }
                if (msj.responseJSON.errors.solvencia != undefined && (!$('#solvencia').attr(
                        'disabled'))) {
                    $('#solvencia').addClass('is-invalid');
                    $('#invalid_solvencia').html(msj.responseJSON.errors.solvencia);
                    $('#collapseInstitucional').addClass('show');
                } else {
                    $('#solvencia').attr('disabled', true);
                }
                if (msj.responseJSON.errors.estado != undefined && (!$('#estado').attr(
                        'disabled'))) {
                    $('#estado').addClass('is-invalid');
                    $('#invalid_estado').html(msj.responseJSON.errors.estado);
                    $('#collapseInstitucional').addClass('show');
                } else {
                    $('#estado').attr('disabled', true);
                }
                if (msj.responseJSON.errors.foto != undefined) {
                    $('#foto').addClass('is-invalid');
                    $('#invalid_foto').html(msj.responseJSON.errors.foto);
                    $('#collapsePerfil').addClass('show');
                }
                if (msj.responseJSON.errors.usuario != undefined && !$('#usuario').attr('disabled')) {
                    $('#usuario').addClass('is-invalid');
                    $('#invalid_usuario').html(msj.responseJSON.errors.usuario);
                    $('#collapseAcceso').addClass('show');
                } else {
                    $('#usuario').attr('disabled', true);
                }
                if (msj.responseJSON.errors.email != undefined && !$('#email').attr('disabled')) {
                    $('#email').addClass('is-invalid');
                    $('#invalid_email').html(msj.responseJSON.errors.email);
                    $('#collapseAcceso').addClass('show');
                } else {
                    $('#email').attr('disabled', true);
                }
                if (msj.responseJSON.errors.password != undefined && !$('#password').attr(
                        'disabled')) {
                    $('#password').addClass('is-invalid');
                    $('#invalid_password').html(msj.responseJSON.errors.password);
                    $('#collapseAcceso').addClass('show');
                } else {
                    $('#password').attr('disabled', true);
                }
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.error('No se pudo editar el registro', '¡Lo sentimos!');
            }
        });
    });

</script>
@endsection
