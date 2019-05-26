@extends('layouts.dashboard')
@section('contenido')
<div class="row">
    <div class="col-12 bg-secondary text-white">
        <h3 class="text-center">Listado de Municipios</h3>
    </div>
</div>
<div class="container py-4">
    <table class="table table-responsive-sm table-hover shadow listado" id="tablaMunicipios">
        <thead class="thead-dark">
            <tr>
                <th scope="col">id</th>
                <th scope="col">Municipio</th>
                <th scope="col">Departamento</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody id="paginated">
            @foreach ($municipios as $municipio)
            <tr style="cursor:pointer" id="row{{ $municipio->id }}">
                <td>{{ $municipio->id }}</td>
                <td>{{ $municipio->municipio }}</td>
                <td>{{ $municipio->departamento->departamento }}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-warning"
                        onclick="editar({{ $municipio->id }}, {{ $municipio->departamento->id }})"><i
                            class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger" onclick="eliminar({{ $municipio->id }})"><i
                            class="fas fa-trash-alt"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    #btnAgregarMunicipio {
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
<a id="btnAgregarMunicipio"
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
            title: 'Agregar Municipio',
            content: '' +
                '<form id="formMunicipio">' +
                '<div class="form-group">' +
                '<label for="departamento">Departamento</label>' +
                '<select id="id_departamento" class="form-control">' +
                '<option value="">--seleccionar--</option>'+
                '@foreach($departamentos as $departamento)<option value="{{ $departamento->id }}">{{ $departamento->departamento }}</departamento> @endforeach'+
                '</select>'+
                '</div>'+
                '<div class="form-group">' +
                '<label for="municipio">Municipio</label>' +
                '<input id="municipio" type="text" placeholder="municipio" class="form-control" />' +
                '</div></form>',
            type: 'blue',
            buttons: {
                agregar: {
                    text: 'Agregar',
                    btnClass: 'btn btn-blue',
                    action: function () {
                        var datos = new FormData();
                        datos.append('municipio', $('#municipio').val());
                        datos.append('id_departamento', $('#id_departamento').val());

                        $.ajax({
                            url: '{{ route("municipios.store") }}',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            cache: false,
                            data: datos,
                            beforeSend: function () {
                                $('form#formMunicipio input').removeClass('is-invalid');
                                $('#formMunicipio').removeClass('was-validated');
                            },
                            success: function (response) {
                                $('#formMunicipio').addClass('was-validated');
                                var row = '<tr id="row'+response.municipio.id+'">'
                                    row += '<td>'+response.municipio.id+'</td>'
                                    row += '<td>'+response.municipio.municipio+'</td>'
                                    row += '<td>'+response.departamento.departamento+'</td>'
                                    row += '<td class="text-center">'
                                    row += '<button type="button" class="btn btn-warning" onclick="editar('+response.municipio.id+')"><i class="fas fa-edit"></i></button>'
                                    row += ' <button type="button" class="btn btn-danger" onclick="eliminar('+response.municipio.id+')"><i class="fas fa-trash-alt"></i></button>'
                                    row += '</td></tr>'
                                $('.listado').dataTable().fnDestroy();
                                $('#tablaMunicipios').find('tbody').append(row);
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
                                if (msj.responseJSON.errors.id_municipio != undefined) {
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
                                    toastr.error(msj.responseJSON.errors.id_municipio, '¡Lo sentimos!');
                                } else {
                                    $('#id_municipio').addClass('is-valid');
                                }
                                if (msj.responseJSON.errors.municipio != undefined) {
                                    $('#municipio').addClass('is-invalid');
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
                                    toastr.error(msj.responseJSON.errors.municipio, '¡Lo sentimos!');
                                } else {
                                    $('#municipio').addClass('is-valid');
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
                this.$content.find('form#formMunicipio').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$agregar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

    function editar(id,depto_id) {
        var municipio =  $('tr#row'+id).find('td').eq(1).text();

        var cf = $.confirm({
            icon: 'fas fa-keyboard',
            title: 'Editar Municipio',
            content: '' +
                '<form id="formMunicipio">' +
                '<div class="form-group">' +
                '<label for="departamento">Departamento</label>' +
                '<select id="id_departamento" class="form-control">' +
                '<option value="">--seleccionar--</option>'+
                '@foreach($departamentos as $departamento)<option value="{{ $departamento->id }}">{{ $departamento->departamento }}</departamento> @endforeach'+
                '</select>'+
                '</div>'+
                '<div class="form-group">' +
                '<label for="municipio">Municipio</label>' +
                '<input id="municipio" type="text" placeholder="municipio" class="form-control" value="'+municipio+'" />' +
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
                        //datos.append('id', id);
                        datos.append('municipio', $('#municipio').val());
                        datos.append('id_departamento', $('#id_departamento').val());

                        $.ajax({
                            url: 'municipios/' + id,
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
                                $('tr#row'+id).find('td').eq(0).text(response.municipio.id);
                                $('tr#row'+id).find('td').eq(1).text(response.municipio.municipio);
                                $('tr#row'+id).find('td').eq(2).text(response.departamento.departamento);
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
                                if (msj.responseJSON.errors.municipio != undefined) {
                                    $('#departamento').addClass('is-invalid');
                                    $('#invalid_departamento').html(msj.responseJSON.errors.municipio);
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
                                    toastr.error(msj.responseJSON.errors.municipio, '¡Lo sentimos!');
                                } else {
                                    $('#municipio').addClass('is-valid');
                                }
                                if (msj.responseJSON.errors.id_departamento != undefined) {
                                    $('#departamento').addClass('is-invalid');
                                    $('#invalid_departamento').html(msj.responseJSON.errors.id_departamento);
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
                                    toastr.error(msj.responseJSON.errors.id_departamento, '¡Lo sentimos!');
                                } else {
                                    $('#id_departamento').addClass('is-valid');
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
                this.$content.find('select#id_departamento').val(depto_id);
            },
        });

    }

</script>
@endsection
