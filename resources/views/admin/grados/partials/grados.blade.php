<table class="table table-responsive-sm table-hover shadow listado" id="tablaGrados">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Grado</th>
            <th scope="col">Creado</th>
            <th scope="col">Editado</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($grados as $grado)
        <tr id="row{{ $grado->id }}">
            <td>{{ $grado->id }}</td>
            <td>{{ $grado->grado }}</td>
            <td>{{ date('d/m/Y H:i:s', strtotime($grado->created_at)) }}</td>
            <td>{{ date('d/m/Y H:i:s', strtotime($grado->updated_at)) }}</td>
            <td class="text-center">
                <button type="button" class="btn btn-warning" onclick="editar({{ $grado->id }})"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="eliminar({{ $grado->id }})"><i
                        class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{-- {{ $grados->links() }} --}}
<script>
    function eliminar(id) {
        var grado =  $('tr#row'+id).find('td').eq(1).text();
        $.confirm({
            icon: 'fas fa-exclamation-triangle',
            title: '¡Advertencia!',
            content: 'Está a punto de eliminar el grado: <b><mark>' + grado + '</mark></b>, ¿Está seguro?',
            type: 'red',
            buttons: {
                Confirmar: {
                    btnClass: 'btn btn-danger',
                    action: function () {
                        $.ajax({
                            url: "grados/" + id,
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
