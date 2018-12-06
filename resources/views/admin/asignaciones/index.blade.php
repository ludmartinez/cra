@extends('layouts.dashboard');
@section('contenido')
<section class="container">
    <h3>Listado de Asignaciones</h3>
    <hr>
    <table class="table table-responsive-sm table-hover shadow listado" id="tablaAsignaciones">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Período</th>
                <th scope="col">Docente</th>
                <th scope="col">Edad</th>
                <th scope="col">Sexo</th>
                <th scope="col">Tiempo en institución</th>
                <th scope="col">Materia</th>
                <th scope="col">Grado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asignaciones as $asignacion)
            <tr>
                <td>{{ $asignacion->periodo }}</td>
                <td>{{ $asignacion->docente }}</td>
                <td>{{ $asignacion->edad }}</td>
                <td>{{ $asignacion->sexo}}</td>
                <td>{{ $asignacion->tiempoInstitucion}}</td>
                <td>{{ $asignacion->materia}}</td>
                <td>{{ $asignacion->grado}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
