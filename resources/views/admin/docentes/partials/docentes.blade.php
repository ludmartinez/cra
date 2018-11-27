<table class="table table-responsive-sm table-hover shadow listado" id="tablaDocentes">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Carnet</th>
            <th scope="col">DUI</th>
            <th scope="col">Nombre</th>
            <th scope="col">Sexo</th>
            <th scope="col">Fecha de Nacimiento</th>
            <th scope="col">Fecha de Ingreso</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($docentes as $docente)
        <tr onclick="location.href='{{ route('docentes.show', $docente) }}'" style="cursor:pointer">
            <td>{{ $docente->carnet }}</td>
            <td>{{ $docente->dui }}</td>
            <td>{{ $docente->fullName() }}</td>
            <td>{{ $docente->sexo }}</td>
            <td>{{ date("d/m/Y",strtotime($docente->fechaNacimiento)) }}</td>
            <td>{{ date("d/m/Y",strtotime($docente->fechaIngreso)) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{-- {{ $docentes->links() }} --}}
