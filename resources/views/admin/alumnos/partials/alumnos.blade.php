<table class="table table-responsive-sm table-hover shadow listado" id="tablaAlumnos">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Carnet</th>
            <th scope="col">NIE</th>
            <th scope="col">Nombre</th>
            <th scope="col">Sexo</th>
            <th scope="col">Solvencia</th>
            <th scope="col">Fecha de Nacimiento</th>
            <th scope="col">Fecha de Ingreso</th>
        </tr>
    </thead>
    <tbody id="paginated">
        @foreach ($alumnos as $alumno)
        <tr onclick="location.href='{{ route('alumnos.show', $alumno->carnet) }}'" style="cursor:pointer">
            <td>{{ $alumno->carnet }}</td>
            <td>{{ $alumno->nie }}</td>
            <td>{{ $alumno->fullName() }}</td>
            <td>{{ $alumno->sexo }}</td>
            <td>@if ($alumno->solvencia) Solvente @else Insolvente @endif</td>
            <td>{{ date("d/m/Y",strtotime($alumno->fechaNacimiento)) }}</td>
            <td>{{ date("d/m/Y",strtotime($alumno->fechaIngreso)) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{-- {{ $alumnos->links() }} --}}
