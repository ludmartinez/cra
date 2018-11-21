@extends('layouts.dashboard')
@section('contenido')
<div class="row">
    <div class="col-12 bg-secondary text-white">
        <h3 class="text-center">Listado de Materias</h3>
    </div>
</div>
<section class="container mt-3">
    <div class="col">
        @component('admin.materias.partials.materias', compact('materias'))
        @endcomponent
    </div>
</section>

<style>
    #btnAgregarMateria {
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
<a id="btnAgregarMateria" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-color-text--white"
    onclick="agregar()">
    <i class="material-icons">add</i>
</a>
@endsection
@section('scripts')
<script>
    function agregar() {
        $.confirm({
            icon: 'fas fa-keyboard',
            title: 'Agregar Materia',
            content: '' +
                '<form id="formMateria">' +
                '<div class="form-group">' +
                '<label for="materia">Materia</label>' +
                '<input id="materia" type="text" placeholder="Materia" class="form-control" />' +
                '</div></form>',
            type: 'blue',
            buttons: {
                agregar: {
                    text: 'Agregar',
                    btnClass: 'btn btn-blue',
                    action: function () {
                        var datos = new FormData();
                        datos.append('materia', $('#materia').val());

                        $.ajax({
                            url: '{{ route("materias.store") }}',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            cache: false,
                            data: datos,
                            beforeSend: function () {
                                $('form#formMateria input').removeClass('is-invalid');
                                $('#formMateria').removeClass('was-validated');
                            },
                            success: function (response) {
                                $('#formMateria').addClass('was-validated');
                                var row = '<tr id="row'+response.id+'">'
                                    row += '<td>'+response.id+'</td>'
                                    row += '<td>'+response.materia+'</td>'
                                    row += '<td>'+response.created_at+'</td>'
                                    row += '<td>'+response.updated_at+'</td>'
                                    row += '<td class="text-center">'
                                    row += '<button type="button" class="btn btn-warning" onclick="editar('+response.id+')"><i class="fas fa-edit"></i></button>'
                                    row += ' <button type="button" class="btn btn-danger" onclick="eliminar('+response.id+')"><i class="fas fa-trash-alt"></i></button>'
                                    row += '</td></tr>'
                                $('.listado').dataTable().fnDestroy();
                                $('#tablaMaterias').find('tbody').append(row);
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
                                if (msj.responseJSON.errors.materia != undefined) {
                                    $('#materia').addClass('is-invalid');
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
                                    toastr.error(msj.responseJSON.errors.materia, '¡Lo sentimos!');
                                } else {
                                    $('#materia').addClass('is-valid');
                                }
                                if (msj.responseJSON.errors.cupo != undefined) {
                                    $('#cupo').addClass('is-invalid');
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
                                    toastr.error(msj.responseJSON.errors.cupo, '¡Lo sentimos!');
                                } else {
                                    $('#cupo').addClass('is-valid');
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
                this.$content.find('form#formMateria').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$agregar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

    function editar(id) {
        var materia =  $('tr#row'+id).find('td').eq(1).text();
        var cf = $.confirm({
            icon: 'fas fa-keyboard',
            title: 'Editar Materia',
            content: '' +
                '<form id="formMateria">' +
                '<div class="form-group">' +
                '<label for="materia">Materia</label>' +
                '<input id="materia" type="text" placeholder="Materia" class="form-control" value="'+materia+'" />' +
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
                        datos.append('materia', $('#materia').val());

                        $.ajax({
                            url: 'materias/' + id,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            cache: false,
                            data: datos,
                            beforeSend: function () {
                                $('form#formMateria input').removeClass('is-invalid');
                                $('#formMateria').removeClass('was-validated');
                            },
                            success: function (response) {
                                $('#formMateria').addClass('was-validated');
                                $('.listado').dataTable().fnDestroy();
                                $('tr#row'+id).find('td').eq(0).text(response.id);
                                $('tr#row'+id).find('td').eq(1).text(response.materia);
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
                                if (msj.responseJSON.errors.materia != undefined) {
                                    $('#materia').addClass('is-invalid');
                                    $('#invalid_materia').html(msj.responseJSON.errors.materia);
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
                                    toastr.error(msj.responseJSON.errors.materia, '¡Lo sentimos!');
                                } else {
                                    $('#materia').addClass('is-valid');
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
                this.$content.find('form#formMateria').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$editar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

</script>
@endsection
