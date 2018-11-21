@inject('helper', 'App\CustomHelpers\StringHelper')
<table class="table table-responsive-sm table-hover shadow listado" id="tablaAdmins">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Carnet</th>
            <th scope="col">DUI</th>
            <th scope="col">Nombre</th>
            <th scope="col">Sexo</th>
            <th scope="col">Tipo</th>
            <th scope="col">Fecha de Nacimiento</th>
            <th scope="col">Fecha de Ingreso</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($admins as $admin)
        <tr onclick="location.href='{{ route('admins.show', $admin) }}'" style="cursor:pointer">
            <td>{{ $admin->carnet }}</td>
            <td>{{ $admin->dui }}</td>
            <td>{{
                $helper->fullName($admin->primerNombre,$admin->segundoNombre,$admin->tercerNombre,$admin->apellidoPaterno,$admin->apellidoMaterno)
                }}</td>
            <td>{{ $admin->sexo }}</td>
            <td>@if ($admin->superUsuario == true) Master @else Normal @endif</td>
            <td>{{ date("d/m/Y",strtotime($admin->fechaNacimiento)) }}</td>
            <td>{{ date("d/m/Y",strtotime($admin->fechaIngreso)) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{-- {{ $admins->links() }} --}}
