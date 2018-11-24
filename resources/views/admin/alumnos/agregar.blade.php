@extends('layouts.dashboard')
@section('contenido')
<section class="container mb-2">
    <h3 class="text-center text-md-left">Agregar Alumno</h3>
    <hr>
    <div class="card p-2">
        <form id="formAlumno" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="form-row">
                <div class="col-12">
                    <h4 class="m-0"><small class="text-muted">Identificación</small></h4>
                    <hr class="mt-0">
                </div>
                {{-- seccion foto --}}
                <div class="col-12 col-md-4 col-lg-3 mb-3">
                    {{-- foto del estudiante --}}
                    <div class="form-row card py-2 bg-light">
                        <div class="col-12 mb-1 text-center" id="contenedor-foto">
                            <img src="{{ asset('img/foto-perfil.jpg') }}" id="foto-preview" alt="Foto" class="img-fluid" style="max-height:16.7em">
                        </div>
                        <div class="col-12">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto" name="foto" lang="es" accept="image/*" capture="camera">
                                <label class="custom-file-label" for="foto">Escoga un archivo</label>
                                <div class="invalid-feedback" id="invalid_foto">
                                    ¡Incorrecto!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- seccion inputs --}}
                <div class="col-12 col-md col-lg">
                    <div class="form-row">
                        {{-- nie --}}
                        <div class="col-12 col-md-4 mb-3">
                            <label for="nie">NIE</label>
                            <input type="number" id="nie" name="nie" class="form-control" placeholder="nie">
                            <div id="invalid_nie" class="invalid-feedback">
                                ¡Incorrecto!
                            </div>
                        </div>
                    </div>
                    {{-- nombres --}}
                    <div class="form-row">
                        <div class="col-12 col-md-4 mb-3">
                            <label for="primerNombre">Primer Nombre</label>
                            <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Primer Nombre" required>
                            <div id="invalid_primer_nombre" class="invalid-feedback">
                                ¡Incorrecto!
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <label for="segundoNombre">Segundo Nombre</label>
                            <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" placeholder="Segundo Nombre">
                            <div id="invalid_segundo_nombre" class="invalid-feedback">
                                ¡Incorrecto!
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <label for="tercerNombre">Tercer Nombre</label>
                            <input type="text" class="form-control" id="tercerNombre" name="tercerNombre" placeholder="Tercer Nombre">
                            <div id="invalid_tercer_nombre" class="invalid-feedback">
                                ¡Incorrecto!
                            </div>
                        </div>
                    </div>
                    {{-- apellidos --}}
                    <div class="form-row">
                        <div class="col-md mb-3">
                            <label for="apellidoPaterno">Apellido Paterno</label>
                            <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" placeholder="Apellido Paterno" required>
                            <div id="invalid_apellido_paterno" class="invalid-feedback">
                                ¡Incorrecto!
                            </div>
                        </div>
                        <div class="col-md mb-3">
                            <label for="apellidoMaterno">Apellido Materno</label>
                            <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" placeholder="Apellido Materno" required>
                            <div id="invalid_apellido_materno" class="invalid-feedback">
                                ¡Incorrecto!
                            </div>
                        </div>
                    </div>
                    {{-- nacimiento --}}
                    <div class="form-row">
                        <div class="col-12 col-md mb-3">
                            <label for="sexo">Sexo</label>
                            <select name="sexo" id="sexo" class="form-control" required>
                                <option value="">-- Seleccionar --</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Masculino">Masculino</option>
                            </select>
                            <div id="invalid_sexo" class="invalid-feedback">
                                ¡Incorrecto!
                            </div>
                        </div>
                        <div class="col-12 col-md mb-3">
                            <label for="fechaNacimiento">Fecha de Nacimiento</label>
                            <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="form-control" required>
                            <div id="invalid_fecha_nacimiento" class="invalid-feedback">
                                ¡Incorrecto!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-12">
                    <h4 class="m-0"><small class="text-muted">Institucional</small></h4>
                    <hr class="mt-0">
                </div>
                <div class="col-12 col-md mb-3">
                    <label for="fechaIngreso">Fecha de Ingreso</label>
                    <input type="date" id="fechaIngreso" name="fechaIngreso" class="form-control" required>
                    <div id="invalid_fecha_ingreso" class="invalid-feedback">
                        ¡Incorrecto!
                    </div>
                </div>
            </div>
            <div id="loading" class="mdl-progress mdl-js-progress mdl-progress__indeterminate d-none" style="width:100%"></div>
            <button class="btn btn-block btn-primary" type="submit">Agregar</button>
        </form>
    </div>
</section>
@endsection

@section('scripts')
<script>
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

    $('button[type="submit"]').click(function (event) {
        event.preventDefault();
        var token = $('input[name="_token"]').val();
        var route = "{{ route('alumnos.store') }}";
        var datos = new FormData();
        datos.append('nie', $('#nie').val());
        if ($('#foto')[0].files[0] != undefined) {
            datos.append('foto', $('#foto')[0].files[0]);
        }
        datos.append('primerNombre', $('#primerNombre').val());
        datos.append('segundoNombre', $('#segundoNombre').val());
        datos.append('tercerNombre', $('#tercerNombre').val());
        datos.append('apellidoPaterno', $('#apellidoPaterno').val());
        datos.append('apellidoMaterno', $('#apellidoMaterno').val());
        datos.append('sexo', $('#sexo').val());
        datos.append('fechaNacimiento', $('#fechaNacimiento').val());
        datos.append('fechaIngreso', $('#fechaIngreso').val());

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
                $('#formAlumno').removeClass('was-validated');
                $('#loading').removeClass('d-none');
            },
            success: function (response) {
                $('#formAlumno').addClass('was-validated');
                $('#loading').addClass('d-none');
                console.log(response);
                // console.log(response.alumno.carnet);
                // location.href = "/alumnos/"+response.alumno.carnet;
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
                toastr.success('Registro agregado con éxito.', '¡En hora buena!');
                $.confirm({
                    title: '¿Qué desea?',
                    content: 'Podemos realizar las siguientes acciones:',
                    type: 'green',
                    closeIcon: true,
                    escapeKey: true,
                    backgroundDismiss: true,
                    buttons: {
                        alumno: {
                            text: 'Ver Alumno',
                            btnClass: 'btn-success',
                            action: function(){
                                location.href = "/alumnos/"+response.alumno.carnet;
                            }
                        },
                        listado: {
                            text: 'Ir al listado',
                            btnClass: 'btn-primary',
                            action: function(){
                                location.href = "{{ route('alumnos.index') }}"
                            }
                        },
                    }
                });
            },
            error: function (msj) {
                console.log(msj);
                $('#loading').addClass('d-none');
                if (msj.responseJSON.errors.nie != undefined) {
                    $('#nie').addClass('is-invalid');
                    $('#invalid_nie').html(msj.responseJSON.errors.nie);
                } else {
                    $('#nie').addClass('is-valid');
                }
                if (msj.responseJSON.errors.primerNombre != undefined) {
                    $('#primerNombre').addClass('is-invalid');
                    $('#invalid_primer_nombre').html(msj.responseJSON.errors.primerNombre);
                } else {
                    $('#primerNombre').addClass('is-valid');
                }
                if (msj.responseJSON.errors.segundoNombre != undefined) {
                    $('#segundoNombre').addClass('is-invalid');
                    $('#invalid_segundo_nombre').html(msj.responseJSON.errors.segundoNombre);
                } else {
                    $('#segundoNombre').addClass('is-valid');
                }
                if (msj.responseJSON.errors.tercerNombre != undefined) {
                    $('#tercerNombre').addClass('is-invalid');
                    $('#invalid_tercer_nombre').html(msj.responseJSON.errors.tercerNombre);
                } else {
                    $('#tercerNombre').addClass('is-valid');
                }
                if (msj.responseJSON.errors.apellidoMaterno != undefined) {
                    $('#apellidoMaterno').addClass('is-invalid');
                    $('#invalid_apellido_materno').html(msj.responseJSON.errors.apellidoMaterno);
                } else {
                    $('#apellidoMaterno').addClass('is-valid');
                }
                if (msj.responseJSON.errors.apellidoPaterno != undefined) {
                    $('#apellidoPaterno').addClass('is-invalid');
                    $('#invalid_apellido_paterno').html(msj.responseJSON.errors.apellidoPaterno);
                } else {
                    $('#apellidoPaterno').addClass('is-valid');
                }
                if (msj.responseJSON.errors.fechaNacimiento != undefined) {
                    $('#fechaNacimiento').addClass('is-invalid');
                    $('#invalid_fecha_nacimiento').html(msj.responseJSON.errors.fechaNacimiento);
                } else {
                    $('#fechaNacimiento').addClass('is-valid');
                }
                if (msj.responseJSON.errors.sexo != undefined) {
                    $('#sexo').addClass('is-invalid');
                    $('#invalid_sexo').html(msj.responseJSON.errors.sexo);
                } else {
                    $('#sexo').addClass('is-valid');
                }
                if (msj.responseJSON.errors.fechaIngreso != undefined) {
                    $('#fechaIngreso').addClass('is-invalid');
                    $('#invalid_fecha_ingreso').html(msj.responseJSON.errors.fechaIngreso);
                } else {
                    $('#fechaIngreso').addClass('is-valid');
                }
                if (msj.responseJSON.errors.foto != undefined) {
                    $('#foto').addClass('is-invalid');
                    $('#invalid_foto').html(msj.responseJSON.errors.foto);
                } else {
                    $('#foto').addClass('is-valid');
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
                toastr.error('No se pudo agregar el registro', '¡Lo sentimos!');
            }
        });
    });

</script>
@endsection
