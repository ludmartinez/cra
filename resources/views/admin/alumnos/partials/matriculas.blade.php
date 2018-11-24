<div class="row">
    <div class="col">
        <button class="btn btn-primary pull-right mb-3" onclick="agregar()">Agregar</button>
    </div>
</div>
<table class="table table-responsive-sm table-hover shadow listado" id="tablaMatriculas">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Período</th>
            <th scope="col">Grado</th>
            <th scope="col">Creado</th>
            <th scope="col">Editado</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($matriculas as $matricula)
        <tr id="row{{ $matricula->id }}">
            <td>{{ $matricula->periodo->periodo }}</td>
            <td>{{ $matricula->grado->grado }}</td>
            <td>{{ $matricula->created_at }}</td>
            <td>{{ $matricula->updated_at}}</td>
            <td class="text-center">
                <button type="button" class="btn btn-warning" onclick="editar({{ $matricula->id }}, '{{ route('matriculas.update', $matricula) }}')"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="eliminar({{ $matricula->id }}, '{{ route('matriculas.destroy', $matricula) }}')"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{-- {{ $matriculas->links() }} --}}
<script>
    function agregar() {
        var contenido = '<form id="formMatricula">' +
                '<div class="form-group">' +
                '<label for="periodo">Periodo</label>' +
                '<select id="periodo" class="form-control">' +
                '<option value="">--seleccionar--</option>'+
                '@foreach($periodos as $periodo)<option value="{{ $periodo->id }}">{{ $periodo->periodo }}</periodo> @endforeach'+
                '</select>'+
                '</div>'+
                '<div class="form-group">' +
                '<label for="grado">Grado</label>' +
                '<select id="grado" class="form-control" >'+
                '<option value="">--seleccionar--</option>';
            contenido+= "@foreach($grados as $grado) <option value='{{ $grado->id }}'>{{ $grado->grado }}</option> @endforeach";
            contenido+=  '</select>'+
                        '</div>'+
                        '</form>',
        $.confirm({
            icon: 'fas fa-keyboard',
            closeIcon: true,
            escapeKey: true,
            backgroundDismiss: true,
            title: 'Agregar Matrícula',
            content: contenido,
            type: 'blue',
            buttons: {
                agregar: {
                    text: 'Agregar',
                    btnClass: 'btn btn-blue',
                    action: function () {
                        var datos = new FormData();
                        datos.append('periodo_id', $('#periodo').val());
                        datos.append('alumno_carnet', "{{ $alumno->carnet }}");
                        datos.append('grado_id', $('#grado').val());

                        $.ajax({
                            url: '{{ route("matriculas.store") }}',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            cache: false,
                            data: datos,
                            beforeSend: function () {
                                $('form#formMatricula input').removeClass('is-invalid');
                                $('#formMatricula').removeClass('was-validated');
                            },
                            success: function (response) {
                                $('#formMatricula').addClass('was-validated');
                                var row = '<tr id="row'+response.matricula.id+'">'
                                    row += '<td>'+response.periodo+'</td>'
                                    row += '<td>'+response.grado+'</td>'
                                    row += '<td>'+response.matricula.created_at+'</td>'
                                    row += '<td>'+response.matricula.updated_at+'</td>'
                                    row += '<td class="text-center">'
                                    row += '<button type="button" class="btn btn-warning" onclick="editar('+response.matricula.id+')"><i class="fas fa-edit"></i></button>'
                                    row += ' <button type="button" class="btn btn-danger" onclick="eliminar('+response.matricula.id+')"><i class="fas fa-trash-alt"></i></button>'
                                    row += '</td></tr>'
                                $('.listado').dataTable().fnDestroy();
                                $('#tablaMatriculas').find('tbody').append(row);
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
                                if(msj.responseJSON.error != undefined){
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
                                    toastr.error(msj.responseJSON.error, '¡Lo sentimos!');
                                }
                                if (msj.responseJSON.errors.periodo_id != undefined) {
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
                                        "timeOut": "5000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    };
                                    toastr.error(msj.responseJSON.errors.periodo_id, '¡Lo sentimos!');
                                } else {
                                    $('#periodo').addClass('is-valid');
                                }
                                if (msj.responseJSON.errors.grado_id != undefined) {
                                    $('#grado').addClass('is-invalid');
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
                                    toastr.error(msj.responseJSON.errors.grado_id, '¡Lo sentimos!');
                                } else {
                                    $('#grado').addClass('is-valid');
                                }
                                if (msj.responseJSON.errors.alumno_carnet != undefined) {
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
                                    toastr.error(msj.responseJSON.errors.alumno_carnet, '¡Lo sentimos!');
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
                this.$content.find('form#formMatricula').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$agregar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

    function editar(id, url) {
        var periodo =  $('tr#row'+id).find('td').eq(0).text();
        var grado =  $('tr#row'+id).find('td').eq(1).text();
        $.confirm({
            icon: 'fas fa-keyboard',
            title: 'Editar Matricula '+periodo,
            content: '' +
                '<form id="formMatricula">' +
                '<div class="form-group">' +
                '<label for="grado">Grado</label>' +
                '<select id="grado" class="form-control">' +
                '<option value="" selected>--Seleccionar--</option>'+
                '@foreach($grados as $grado)<option value="{{ $grado->id }}">{{ $grado->grado }}</option> @endforeach'+
                '</select>'+
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
                        datos.append('grado_id', $('#grado').val());

                        $.ajax({
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            cache: false,
                            data: datos,
                            beforeSend: function () {
                                $('form#formMatricula input').removeClass('is-invalid');
                                $('#formMatricula').removeClass('was-validated');
                            },
                            success: function (response) {
                                $('#formMatricula').addClass('was-validated');
                                $('.listado').dataTable().fnDestroy();
                                $('tr#row'+id).find('td').eq(0).text(response.periodo);
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
                                if (msj.responseJSON.errors.grado_id != undefined) {
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
                                    toastr.error(msj.responseJSON.errors.grado_id, '¡Lo sentimos!');
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
                this.$content.find('form#formMatricula').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$editar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

    function eliminar(id, url) {
        var periodo =  $('tr#row'+id).find('td').eq(0).text();
        $.confirm({
            icon: 'fas fa-exclamation-triangle',
            title: '¡Advertencia!',
            content: 'Está a punto de eliminar el período: <b><mark>' + periodo + '</mark></b>, ¿Está seguro?',
            type: 'red',
            buttons: {
                Confirmar: {
                    btnClass: 'btn btn-danger',
                    action: function () {
                        $.ajax({
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'DELETE',
                            success: function (response) {
                                $('.listado').dataTable().fnDestroy();
                                $('#row' + id).remove();
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
                                toastr.success('Registro eliminado con éxito.',
                                    '¡En hora buena!');
                            },
                            error: function (msj) {
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
                                toastr.error('No se pudo eliminar el registro', '¡Lo sentimos!');
                            }
                        });
                    }
                },
                Cancelar: function () {},
            }
        });
    }
</script>
