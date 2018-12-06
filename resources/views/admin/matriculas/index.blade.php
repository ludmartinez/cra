@extends('layouts.dashboard')
@section('contenido')
<section class="container">
    <h3>Listado de Matriculas</h3>
    <hr>
    <table class="table table-responsive-sm table-hover shadow listado" id="tablamatriculaes">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Período</th>
                <th scope="col">Alumno</th>
                <th scope="col">Edad</th>
                <th scope="col">Sexo</th>
                <th scope="col">Grado</th>
                <th scope="col">Tiempo en institución</th>
                <th scope="col">Fecha de Matricula</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matriculas as $matricula)
            <tr>
                <td>{{ $matricula->periodo }}</td>
                <td>{{ $matricula->alumno }}</td>
                <td>{{ $matricula->edad }}</td>
                <td>{{ $matricula->sexo}}</td>
                <td>{{ $matricula->grado}}</td>
                <td>{{ $matricula->tiempoInstitucion}}</td>
                <td>{{ $matricula->fechaMatricula}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
