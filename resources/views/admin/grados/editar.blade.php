@extends('layouts.dashboard')
@section('contenido')
<section class="container mb-2">
    <h3 class="text-center text-md-left">Agregar Grados</h3>
    <hr>
    <div class="card p-2">
        <form id="formGrado" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')
            <div class="form-row mb-3">
                <div class="col">
                    <label for="grado">Grado</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="grado" id="grado" value="{{ $grado->grado }}" disabled>
                        <div class="input-group-prepend">
                            <button class="btn btn-info" type="button" onclick="editar('grado')"><i class="fas fa-pen"></i></button>
                        </div>
                        <div id="invalid_grado" class="invalid-feedback"></div>
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
    function editar(input) {
        $('#' + input).removeAttr('disabled');
        $('#' + input).focus();
        $('#' + input).select();
    }

    $('button[type="submit"]').click(function (event) {
        event.preventDefault();
        var token = $('input[name="_token"]').val();
        var route = "{{ route('grados.update',$grado->id) }}";
        var datos = new FormData();
        datos.append('id', '{{ $grado->id }}');
        datos.append('_method', $('input[name="_method"]').val());
        if (!$('#grado').attr('disabled')) {
            datos.append('grado', $('#grado').val());
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
                if (response.warning != undefined) {
                    toastr.info('No hay datos para modificar', '¿Qué pasa?');
                } else {
                    toastr.success('Registro editado con éxito.', '¡En hora buena!');
                }
            },
            error: function (msj) {
                console.log(msj);
                $('#loading').addClass('d-none');
                if ((msj.responseJSON.errors.grado != undefined) && (!$('#grado').attr('disabled'))) {
                    $('#grado').addClass('is-invalid');
                    $('#invalid_grado').html(msj.responseJSON.errors.grado);
                } else {
                    $('#grado').attr('disabled', true);
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
