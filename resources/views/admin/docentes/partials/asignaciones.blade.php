<div class="row">
    <div class="col">
        <button class="btn btn-primary pull-right mb-3" onclick="agregar()">Agregar</button>
    </div>
</div>
<table class="table table-responsive-sm table-hover shadow listado" id="tablaAsignaciones">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Período</th>
            <th scope="col">Materia</th>
            <th scope="col">Grado</th>
            <th scope="col">Creado</th>
            <th scope="col">Editado</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($asignaciones as $asignacion)
        <tr id="row{{ $asignacion->id }}">
            <td>{{ $asignacion->periodo->periodo }}</td>
            <td>{{ $asignacion->materia->materia }}</td>
            <td>{{ $asignacion->grado->grado }}</td>
            <td>{{ $asignacion->created_at }}</td>
            <td>{{ $asignacion->updated_at}}</td>
            <td class="text-center">
                <button type="button" class="btn btn-warning" onclick="editar({{ $asignacion->id }}, '{{ route('asignaciones.update', $asignacion) }}')"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="eliminar({{ $asignacion->id }}, '{{ route('asignaciones.destroy', $asignacion) }}')"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{-- {{ $asignaciones->links() }} --}}
<script>
    function agregar() {
        var contenido = '<form id="formAsignacion">' +
                '<div class="form-group">' +
                '<label for="periodo">Periodo</label>' +
                '<select id="periodo" class="form-control">' +
                '<option value="">--seleccionar--</option>'+
                '@foreach($periodos as $periodo)<option value="{{ $periodo->id }}">{{ $periodo->periodo }}</periodo> @endforeach'+
                '</select>'+
                '</div>'+
                '<div class="form-group">' +
                '<label for="materia">Materia</label>' +
                '<select id="materia" class="form-control">' +
                '<option value="">--seleccionar--</option>'+
                '@foreach($materias as $materia)<option value="{{ $materia->id }}">{{ $materia->materia }}</materia> @endforeach'+
                '</select>'+
                '</div>'+
                '<div class="form-group">' +
                '<label for="grado">Grado</label>' +
                '<select id="grado" class="form-control" >'+
                '<option value="">--seleccionar--</option>'+
                '@foreach($grados as $grado) <option value="{{ $grado->id }}">{{ $grado->grado }}</option> @endforeach'+
                '</select>'+
                '</div>'+
                '</form>';
        $.confirm({
            icon: 'fas fa-keyboard',
            closeIcon: true,
            escapeKey: true,
            backgroundDismiss: true,
            title: 'Agregar Asignación',
            content: contenido,
            type: 'blue',
            buttons: {
                agregar: {
                    text: 'Agregar',
                    btnClass: 'btn btn-blue',
                    action: function () {
                        var datos = new FormData();
                        datos.append('periodo_id', $('#periodo').val());
                        datos.append('docente_carnet', "{{ $docente->carnet }}");
                        datos.append('materia_id', $('#materia').val());
                        datos.append('grado_id', $('#grado').val());

                        $.ajax({
                            url: '{{ route("asignaciones.store") }}',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            cache: false,
                            data: datos,
                            beforeSend: function () {
                                $('form#formAsignacion input').removeClass('is-invalid');
                                $('#formAsignacion').removeClass('was-validated');
                            },
                            success: function (response) {
                                var url = '{{ url("/admin/asignaciones") }}/'+response.asignacion.id;
                                $('#formAsignacion').addClass('was-validated');
                                var row = '<tr id="row'+response.asignacion.id+'">'
                                    row += '<td>'+response.periodo+'</td>'
                                    row += '<td>'+response.materia+'</td>'
                                    row += '<td>'+response.grado+'</td>'
                                    row += '<td>'+response.asignacion.created_at+'</td>'
                                    row += '<td>'+response.asignacion.updated_at+'</td>'
                                    row += '<td class="text-center">'
                                    row += '<button type="button" class="btn btn-warning" onclick="editar('+response.asignacion.id+', \''+url+'\')"><i class="fas fa-edit"></i></button>'
                                    row += ' <button type="button" class="btn btn-danger" onclick="eliminar('+response.asignacion.id+', \''+url+'\')"><i class="fas fa-trash-alt"></i></button>'
                                    row += '</td></tr>'
                                $('.listado').dataTable().fnDestroy();
                                $('#tablaAsignaciones').find('tbody').append(row);
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
                                toastr.success('Asignación agregada con éxito.',
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
                                }
                                if (msj.responseJSON.errors.docente_carnet != undefined) {
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
                                    toastr.error(msj.responseJSON.errors.docente_carnet, '¡Lo sentimos!');
                                }
                                if (msj.responseJSON.errors.materia_id != undefined) {
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
                                    toastr.error(msj.responseJSON.errors.materia_id, '¡Lo sentimos!');
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
                this.$content.find('form#formAsignacion').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$agregar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

    function editar(id, url) {
        var periodo =  $('tr#row'+id).find('td').eq(0).text();
        var materia =  $('tr#row'+id).find('td').eq(1).text();
        $.confirm({
            icon: 'fas fa-keyboard',
            title: 'Editar Matricula '+periodo,
            content: '' +
                '<form id="formAsignacion">' +
                '<div class="form-group">' +
                '<label for="periodo">Materia</label>' +
                '<input id="periodo" type="text" class="form-control" value="'+periodo+'" readonly>'+
                '</div>' +
                '<div class="form-group">' +
                '<label for="materia">Materia</label>' +
                '<input id="materia" type="text" class="form-control" value="'+materia+'" readonly>'+
                '</div>' +
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
                                $('form#formAsignacion input').removeClass('is-invalid');
                                $('#formAsignacion').removeClass('was-validated');
                            },
                            success: function (response) {
                                $('#formAsignacion').addClass('was-validated');
                                $('.listado').dataTable().fnDestroy();
                                $('tr#row'+id).find('td').eq(0).text(response.periodo);
                                $('tr#row'+id).find('td').eq(1).text(response.materia);
                                $('tr#row'+id).find('td').eq(2).text(response.grado);
                                $('tr#row'+id).find('td').eq(3).text(response.created_at);
                                $('tr#row'+id).find('td').eq(4).text(response.updated_at);
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
                                toastr.success('Matrícula editada con éxito.',
                                    '¡En hora buena!');
                            },
                            error: function (msj) {
                                console.log(msj);
                                if (msj.responseJSON.error != undefined) {
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
                                if (msj.responseJSON.errors.materia_id != undefined) {
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
                                    toastr.error(msj.responseJSON.errors.materia_id, '¡Lo sentimos!');
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
                this.$content.find('form#formAsignacion').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$editar.trigger('click'); // reference the button and click it
                });
            },
        });
    }

    function eliminar(id, url) {
        $.confirm({
            icon: 'fas fa-exclamation-triangle',
            title: '¡Advertencia!',
            content: 'Está a punto de eliminar la asignación, ¿Está seguro?',
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
