@extends('layouts.dashboard')
@section('aside')
@endsection
@section('contenido')
<div class="row">
    <div class="col-12 bg-secondary text-white">
        <h3 class="text-center">Listado Alumnos {{ $grado->grado }} Grado</h3>
    </div>
</div>
<div class="container">
    <ul class="list-group py-4">
        @foreach ($matriculas as $matricula)
        <li class="list-group-item">{{ $matricula->alumno->fullName()}}</li>
        @endforeach
    </ul>
</div>
@endsection
