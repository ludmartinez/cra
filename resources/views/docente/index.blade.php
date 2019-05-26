@extends('layouts.dashboard')
@section('aside')
@endsection
@section('contenido')
<div class="row">
    <div class="col-12 bg-secondary text-white">
        <h3 class="text-center">Materias Asignadas</h3>
    </div>
</div>
<div class="container">
    <div class="accordion py-4" id="accordionMaterias">
        @foreach ($materias as $materia)
        <div class="card">
            <div class="card-header p-0" id="encabezado{{ $materia->materia_id }}">
                <h2 class="mb-1 m-0">
                    <button class="btn btn-block btn-dark py-4" type="button" data-toggle="collapse"
                        data-target="#collapse{{ $materia->materia_id }}" aria-expanded="true"
                        aria-controls="collapse{{ $materia->materia_id }}">
                        {{ $materia->materia->materia }}
                    </button>
                </h2>
            </div>

            <div id="collapse{{ $materia->materia_id }}" class="collapse show"
                aria-labelledby="encabezado{{ $materia->materia_id }}" data-parent="#accordionMaterias">
                <div class="card-body p-0">
                    <div class="list-group">
                        @foreach ($asignaciones as $asignacion)
                        @if ($asignacion->materia_id==$materia->materia_id)
                        <a href="{{ route('matricula.listadogrados', ['periodo'=>$asignacion->periodo,'materia'=> $asignacion->materia, 'grado' => $asignacion->grado]) }}"
                            class="list-group-item list-group-item-action">
                            {{ $asignacion->grado->grado }}
                        </a>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
