@extends('layouts.dashboard')
@section('contenido')
<section class="container mb-2">
    <h3 class="text-center text-md-left">Agregar Grados</h3>
    <hr>
    <div class="card p-2">
        <form id="formGrado" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="form-row mb-3">
                <div class="col">
                    <label for="grado">Grado</label>
                    <input type="text" class="form-control" name="grado" id="grado">
                    <div id="invalid_grado" class="invalid-feedback"></div>
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
    $('button[type="submit"]').click(function (event) {
        event.preventDefault();
        var token = $('input[name="_token"]').val();
        var route = "{{ route('grados.store') }}";
        var datos = new FormData();
        datos.append('grado', $('#grado').val());

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
                $('form#formGrado input').removeClass('is-invalid');
                $('form#formGrado select').removeClass('is-invalid');
                $('#formGrado').removeClass('was-validated');
                $('#loading').removeClass('d-none');
            },
            success: function (response) {
                $('#formGrado').addClass('was-validated');
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
            },
            error: function (msj) {
                console.log(msj);
                $('#loading').addClass('d-none');
                if (msj.responseJSON.errors.grado != undefined) {
                    $('#grado').addClass('is-invalid');
                    $('#invalid_grado').html(msj.responseJSON.errors.grado);
                } else {
                    $('#grado').addClass('is-valid');
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
