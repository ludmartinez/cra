@extends('layouts.dashboard')
@section('contenido')
<section class="container">
    <div class="row">
        <div class="col-12">
            <h5>Listado de alumnos de grado: {{ $grado->grado }}</h5>
            <hr>
        </div>
        <form id="filtro" class="col col-md-4 mb-3">
            <label for="periodo">Periodo</label>
            <select name="p" id="periodo" class="form-control" onchange="submit()">
                <option value="">--selecionar--</option>
                @foreach ($periodos as $periodo)
                @if ($request->p==$periodo->id)
                    <option value="{{ $periodo->id }}" selected>{{ $periodo->periodo }}</option>
                    @else
                    <option value="{{ $periodo->id }}">{{ $periodo->periodo }}</option>
                @endif
                @endforeach
            </select>
        </form>
    </div>

    <table class="table table-responsive-sm table-hover shadow listado" id="tablaGrados">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Carnet</th>
                <th scope="col">Nombre</th>
                <th scope="col">Sexo</th>
                <th scope="col">Fecha de Nacimiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <td>{{ $alumno->carnet }}</td>
                <td>{{ $alumno->fullName() }}</td>
                <td>{{ $alumno->sexo }}</td>
                <td>{{ $alumno->fechaNacimiento }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection

@section('scripts')
@endsection
