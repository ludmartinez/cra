@extends('layouts.dashboard')
@section('contenido')
<div class="row">
    <div class="col-12 bg-secondary text-white">
        <h3 class="text-center">Listado de Departamentos</h3>
    </div>
</div>
<div class="container py-4">
    <table class="table table-responsive-sm table-hover shadow listado" id="tablaDepartamentos">
        <thead class="thead-dark">
            <tr>
                <th scope="col">id</th>
                <th scope="col">Departamento</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody id="paginated">
            @foreach ($departamentos as $depto)
            <tr style="cursor:pointer" id="row{{ $depto->id }}">
                <td>{{ $depto->id }}</td>
                <td>{{ $depto->departamento }}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-warning" onclick="editar({{ $depto->id }})"><i
                            class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger" onclick="eliminar({{ $depto->id }})"><i
                            class="fas fa-trash-alt"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    #btnAgregarDepartamento {
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
<a id="btnAgregarDepartamento"
    class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-color-text--white"
    onclick="agregar()">
    <i class="material-icons">add</i>
</a>
@endsection
@section('scripts')
<script>
    function agregar() {
        $.confirm({
            icon: 'fas fa-keyboard',
            title: 'Agregar Departamento',
            content: '' +
                '<form id="formDepartamento">' +
                '<div class="form-group">' +
                '<label for="departamento">Departamento</label>' +
                '<input id="departamento" type="text" placeholder="departamento" class="form-control" />' +
                '</div></form>',
            type: 'blue',
            buttons: {
                agregar: {
                    text: 'Agregar',
                    btnClass: 'btn btn-blue',
                    action: function () {
                        var datos = new FormData();
                        datos.append('departamento', $('#departamento').val());

                        $.ajax({
                            url: '{{ route("departamentos.store") }}',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            cache: false,
                            data: datos,
                            beforeSend: function () {
                                $('form#formDepartamento input').removeClass('is-invalid');
                                $('#formDepartamento').removeClass('was-validated');
                            },
                            success: function (response) {
                                $('#formDepartamento').addClass('was-validated');
                                var row = '<tr id="row'+response.id+'">'
                                    row += '<td>'+response.id+'</td>'
                                    row += '<td>'+response.departamento+'</td>'
                                    row += '<td class="text-center">'
                                    row += '<button type="button" class="btn btn-warning" onclick="editar('+response.id+')"><i class="fas fa-edit"></i></button>'
                                    row += ' <button type="button" class="btn btn-danger" onclick="eliminar('+response.id+')"><i class="fas fa-trash-alt"></i></button>'
                                    row += '</td></tr>'
                                $('.listado').dataTable().fnDestroy();
                                $('#tablaDepartamentos').find('tbody').append(row);
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
                                if (msj.responseJSON.errors.departamento != undefined) {
                                    $('#departamento').addClass('is-invalid');
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
                                    toastr.error(msj.responseJSON.errors.departamento, '¡Lo sentimos!');
                                } else {
                                    $('#departamento').addClass('is-valid');
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
                this.$content.find('form#formDepartamento').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$agregar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

    function editar(id) {
        var departamento =  $('tr#row'+id).find('td').eq(1).text();
        var cf = $.confirm({
            icon: 'fas fa-keyboard',
            title: 'Editar Departamento',
            content: '' +
                '<form id="formDepartamento">' +
                '<div class="form-group">' +
                '<label for="departamento">Departamento</label>' +
                '<input id="departamento" type="text" placeholder="Departamento" class="form-control" value="'+departamento+'" />' +
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
                        datos.append('departamento', $('#departamento').val());

                        $.ajax({
                            url: 'departamentos/' + id,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            cache: false,
                            data: datos,
                            beforeSend: function () {
                                $('form#formDepartamento input').removeClass('is-invalid');
                                $('#formDepartamento').removeClass('was-validated');
                            },
                            success: function (response) {
                                $('#formDepartamento').addClass('was-validated');
                                $('.listado').dataTable().fnDestroy();
                                $('tr#row'+id).find('td').eq(0).text(response.id);
                                $('tr#row'+id).find('td').eq(1).text(response.departamento);
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
                                if (msj.responseJSON.errors.departamento != undefined) {
                                    $('#departamento').addClass('is-invalid');
                                    $('#invalid_departamento').html(msj.responseJSON.errors.departamento);
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
                                    toastr.error(msj.responseJSON.errors.departamento, '¡Lo sentimos!');
                                } else {
                                    $('#departamento').addClass('is-valid');
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
                this.$content.find('form#formDepartamento').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$editar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

</script>
@endsection
