<table class="table table-responsive-sm table-hover shadow listado" id="tablaMaterias">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Materia</th>
            <th scope="col">Creado</th>
            <th scope="col">Editado</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($materias as $materia)
        <tr id="row{{ $materia->id }}">
            <td>{{ $materia->id }}</td>
            <td>{{ $materia->materia }}</td>
            <td>{{ date('d/m/Y H:i:s', strtotime($materia->created_at)) }}</td>
            <td>{{ date('d/m/Y H:i:s', strtotime($materia->updated_at)) }}</td>
            <td class="text-center">
                <button type="button" class="btn btn-warning" onclick="editar({{ $materia->id }})"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="eliminar({{ $materia->id }})"><i
                        class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{-- {{ $materias->links() }} --}}
<script>
    function eliminar(id) {
        var materia =  $('tr#row'+id).find('td').eq(1).text();
        $.confirm({
            icon: 'fas fa-exclamation-triangle',
            title: '¡Advertencia!',
            content: 'Está a punto de eliminar la materia: <b><mark>' + materia + '</mark></b>, ¿Está seguro?',
            type: 'red',
            buttons: {
                Confirmar: {
                    btnClass: 'btn btn-danger',
                    action: function () {
                        $.ajax({
                            url: "materias/" + id,
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
