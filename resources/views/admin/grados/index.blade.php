@extends('layouts.dashboard')
@section('contenido')
<div class="row">
    <div class="col-12 bg-secondary text-white">
        <h3 class="text-center">Listado de Grados</h3>
    </div>
</div>
<section class="container mt-3">
    <div class="col">
        @component('admin.grados.partials.grados', compact('grados'))
        @endcomponent
    </div>
</section>

<style>
    #btnAgregarGrado {
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
<a id="btnAgregarGrado" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-color-text--white"
    onclick="agregar()">
    <i class="material-icons">add</i>
</a>
@endsection
@section('scripts')
<script>
    function agregar() {
        $.confirm({
            icon: 'fas fa-keyboard',
            title: 'Agregar Grado',
            content: '' +
                '<form id="formGrado">' +
                '<div class="form-group">' +
                '<label>Grado</label>' +
                '<input id="grado" type="text" placeholder="Grado" class="form-control" />' +
                '<div id="invalid_grado" class="invalid-feedback"></div>' +
                '</div>' +
                '</form>',
            type: 'blue',
            buttons: {
                agregar: {
                    text: 'Agregar',
                    btnClass: 'btn btn-blue',
                    action: function () {
                        var datos = new FormData();
                        datos.append('grado', $('#grado').val());

                        $.ajax({
                            url: '{{ route("grados.store") }}',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            cache: false,
                            data: datos,
                            beforeSend: function () {
                                $('form#formGrado input').removeClass('is-invalid');
                                $('#formGrado').removeClass('was-validated');
                            },
                            success: function (response) {
                                $('#formGrado').addClass('was-validated');
                                var row = "<tr id='row" + response.id + "'>" +
                                    "<td>" + response.id + "</td>" +
                                    "<td>" + response.grado + "</td>" +
                                    "<td>" + response.created_at + "</td>" +
                                    "<td>" + response.updated_at + "</td>" +
                                    "<td class='text-center'>" +
                                    "<a href='grados/" + response.id +
                                    "/editar' class='btn btn-warning'><i class='fas fa-edit'></i></a>" +
                                    "<button type='button' class='btn btn-danger' onclick='eliminar(" +
                                    response.id + ", '" + response.grado + "')'>" +
                                    "<i class='fas fa-trash-alt'></i></button>" +
                                    "</td>" +
                                    "</tr>";
                                $('.listado').dataTable().fnDestroy();
                                $('#tablaGrados').find('tbody').append(row);
                                loadTable();
                                marcar();
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
                                toastr.success('Registro agregado con éxito.',
                                    '¡En hora buena!');
                            },
                            error: function (msj) {
                                console.log(msj);
                                if (msj.responseJSON.errors.grado != undefined) {
                                    $('#grado').addClass('is-invalid');
                                    $('#invalid_grado').html(msj.responseJSON.errors.grado);
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
                                    toastr.error(msj.responseJSON.errors.grado, '¡Lo sentimos!');
                                } else {
                                    $('#grado').addClass('is-valid');
                                }
                            }
                        });
                    }
                },
                Cancelar: {

                }
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form#formGrado').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$agregar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

    function editar(id) {
        var grado =  $('tr#row'+id).find('td').eq(1).text();
        var cf = $.confirm({
            icon: 'fas fa-keyboard',
            title: 'Editar Grado',
            content: '' +
                '<form id="formGrado">' +
                '<div class="form-group">' +
                '<label>Grado</label>' +
                '<input id="grado" type="text" placeholder="Grado" class="form-control" value="'+grado+'" />' +
                '<div id="invalid_grado" class="invalid-feedback"></div>' +
                '</div>' +
                '</form>',
            type: 'orange',
            buttons: {
                editar: {
                    text: 'Editar',
                    btnClass: 'btn btn-warning',
                    action: function () {
                        var datos = new FormData();
                        datos.append('_method', 'PUT');
                        datos.append('id', id);
                        datos.append('grado', $('#grado').val());

                        $.ajax({
                            url: 'grados/' + id,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            cache: false,
                            data: datos,
                            beforeSend: function () {
                                $('form#formGrado input').removeClass('is-invalid');
                                $('#formGrado').removeClass('was-validated');
                                console.log($('tr#row'+id).find('td').eq(0).text());
                            },
                            success: function (response) {
                                $('#formGrado').addClass('was-validated');
                                $('.listado').dataTable().fnDestroy();
                                $('tr#row'+id).find('td').eq(0).text(response.id);
                                $('tr#row'+id).find('td').eq(1).text(response.grado);
                                $('tr#row'+id).find('td').eq(2).text(response.created_at);
                                $('tr#row'+id).find('td').eq(3).text(response.updated_at);
                                loadTable();
                                marcar();
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
                                toastr.success('Registro editado con éxito.',
                                    '¡En hora buena!');
                            },
                            error: function (msj) {
                                console.log(msj);
                                if (msj.responseJSON.errors.grado != undefined) {
                                    $('#grado').addClass('is-invalid');
                                    $('#invalid_grado').html(msj.responseJSON.errors.grado);
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
                                    toastr.error(msj.responseJSON.errors.grado, '¡Lo sentimos!');
                                } else {
                                    $('#grado').addClass('is-valid');
                                }
                            }
                        });
                    }
                },
                Cancelar: {}
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form#formGrado').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$editar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

</script>
@endsection
