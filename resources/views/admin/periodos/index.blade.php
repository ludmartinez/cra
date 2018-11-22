@extends('layouts.dashboard')
@section('contenido')
<div class="row">
    <div class="col-12 bg-secondary text-white">
        <h3 class="text-center">Listado de Periodos</h3>
    </div>
</div>
<section class="container mt-3">
    <div class="col">
        @component('admin.periodos.partials.periodos', compact('periodos'))
        @endcomponent
    </div>
</section>

<style>
    #btnAgregarPeriodo {
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
<a id="btnAgregarPeriodo" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-color-text--white"
    onclick="agregar()">
    <i class="material-icons">add</i>
</a>
@endsection
@section('scripts')
<script>
    function agregar() {
        $.confirm({
            icon: 'fas fa-keyboard',
            title: 'Agregar Periodo',
            content: '' +
                '<form id="formPeriodo">' +
                '<div class="form-group">' +
                '<label for="periodo">Periodo</label>' +
                '<input id="periodo" type="number" placeholder="Periodo" class="form-control" />' +
                '</div><div class="form-group">' +
                '<label for="fechaInicio">Fecha de Inicio</label>' +
                '<input id="fechaInicio" type="date" class="form-control" />' +
                '</div><div class="form-group">' +
                '<label for="fechaFin">Fecha de Finalización</label>' +
                '<input id="fechaFin" type="date" class="form-control" />' +
                '</div>'+
                '</form>',
            type: 'blue',
            buttons: {
                agregar: {
                    text: 'Agregar',
                    btnClass: 'btn btn-blue',
                    action: function () {
                        var datos = new FormData();
                        datos.append('periodo', $('#periodo').val());
                        datos.append('fechaInicio', $('#fechaInicio').val());
                        datos.append('fechaFin', $('#fechaFin').val());

                        $.ajax({
                            url: '{{ route("periodos.store") }}',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            cache: false,
                            data: datos,
                            beforeSend: function () {
                                $('form#formPeriodo input').removeClass('is-invalid');
                                $('#formPeriodo').removeClass('was-validated');
                            },
                            success: function (response) {
                                $('#formPeriodo').addClass('was-validated');
                                var row = '<tr id="row'+response.id+'">'
                                    row += '<td>'+response.id+'</td>'
                                    row += '<td>'+response.periodo+'</td>'
                                    row += '<td>'+response.fechaInicio+'</td>'
                                    row += '<td>'+response.fechaFin+'</td>'
                                    row += '<td class="text-center">'
                                    row += '<button type="button" class="btn btn-warning" onclick="editar('+response.id+')"><i class="fas fa-edit"></i></button>'
                                    row += ' <button type="button" class="btn btn-danger" onclick="eliminar('+response.id+')"><i class="fas fa-trash-alt"></i></button>'
                                    row += '</td></tr>'
                                $('.listado').dataTable().fnDestroy();
                                $('#tablaPeriodos').find('tbody').append(row);
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
                                    "timeOut": "15000",
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
                                if (msj.responseJSON.errors.periodo != undefined) {
                                    $('#periodo').addClass('is-invalid');
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
                                        "timeOut": "15000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    };
                                    toastr.error(msj.responseJSON.errors.periodo, '¡Lo sentimos!');
                                } else {
                                    $('#periodo').addClass('is-valid');
                                }
                                if (msj.responseJSON.errors.fechaInicio != undefined) {
                                    $('#fechaInicio').addClass('is-invalid');
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
                                        "timeOut": "15000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    };
                                    toastr.error(msj.responseJSON.errors.fechaInicio, '¡Lo sentimos!');
                                } else {
                                    $('#fechaInicio').addClass('is-valid');
                                }
                                if (msj.responseJSON.errors.fechaFin != undefined) {
                                    $('#fechaFin').addClass('is-invalid');
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
                                        "timeOut": "15000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    };
                                    toastr.error(msj.responseJSON.errors.fechaFin, '¡Lo sentimos!');
                                } else {
                                    $('#fechaFin').addClass('is-valid');
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
                this.$content.find('form#formPeriodo').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$agregar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

    function editar(id) {
        var periodo =  $('tr#row'+id).find('td').eq(1).text();
        var fechaInicio =  ($('tr#row'+id).find('td').eq(2).text()).split('-');
        fechaInicio = fechaInicio[2]+"-"+fechaInicio[1]+"-"+fechaInicio[0];
        var fechaFin =  ($('tr#row'+id).find('td').eq(3).text()).split('-');
        fechaFin = fechaFin[2]+"-"+fechaFin[1]+"-"+fechaFin[0];
        var cf = $.confirm({
            icon: 'fas fa-keyboard',
            title: 'Editar Periodo',
            content: '' +
                '<form id="formPeriodo">' +
                '<div class="form-group">' +
                '<label for="periodo">Periodo</label>' +
                '<input id="periodo" type="text" placeholder="Periodo" class="form-control" value="'+periodo+'" />' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="fechaInicio">Fecha de Inicio</label>' +
                '<input id="fechaInicio" type="date" placeholder="Periodo" class="form-control" value="'+fechaInicio+'" />' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="fechaFin">Fecha de Finalización</label>' +
                '<input id="fechaFin" type="date" placeholder="Periodo" class="form-control" value="'+fechaFin+'" />' +
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
                        datos.append('periodo', $('#periodo').val());
                        datos.append('fechaInicio', $('#fechaInicio').val());
                        datos.append('fechaFin', $('#fechaFin').val());

                        $.ajax({
                            url: 'periodos/' + id,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            cache: false,
                            data: datos,
                            beforeSend: function () {
                                $('form#formPeriodo input').removeClass('is-invalid');
                                $('#formPeriodo').removeClass('was-validated');
                            },
                            success: function (response) {
                                $('#formPeriodo').addClass('was-validated');
                                $('.listado').dataTable().fnDestroy();
                                $('tr#row'+id).find('td').eq(0).text(response.id);
                                $('tr#row'+id).find('td').eq(1).text(response.periodo);
                                $('tr#row'+id).find('td').eq(2).text(response.fechaInicio);
                                $('tr#row'+id).find('td').eq(3).text(response.fechaFin);
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
                                    "timeOut": "15000",
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
                                if (msj.responseJSON.errors.periodo != undefined) {
                                    $('#periodo').addClass('is-invalid');
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
                                        "timeOut": "15000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    };
                                    toastr.error(msj.responseJSON.errors.periodo, '¡Lo sentimos!');
                                } else {
                                    $('#periodo').addClass('is-valid');
                                }
                                if (msj.responseJSON.errors.fechaInicio != undefined) {
                                    $('#fechaInicio').addClass('is-invalid');
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
                                        "timeOut": "15000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    };
                                    toastr.error(msj.responseJSON.errors.fechaInicio, '¡Lo sentimos!');
                                } else {
                                    $('#fechaInicio').addClass('is-valid');
                                }
                                if (msj.responseJSON.errors.fechaFin != undefined) {
                                    $('#fechaFin').addClass('is-invalid');
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
                                        "timeOut": "15000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    };
                                    toastr.error(msj.responseJSON.errors.fechaFin, '¡Lo sentimos!');
                                } else {
                                    $('#fechaFin').addClass('is-valid');
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
                this.$content.find('form#formPeriodo').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$editar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

</script>
@endsection
