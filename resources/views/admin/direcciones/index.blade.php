@extends('layouts.dashboard')
@section('contenido')
<div class="row">
    <div class="col-12 bg-secondary text-white">
        <h3 class="text-center">Direcciones</h3>
    </div>
</div>
<div class="container">
    <div class="row py-4">
        <div class="col">
            <a class="btn btn-block btn-lg btn-primary py-4"
                href="{{ route('departamentos.index') }}">Departamentos</a>
        </div>
        <div class="col">
            <a class="btn btn-block btn-lg btn-primary py-4" href="{{ route('municipios.index') }}">Municipios</a>
        </div>
    </div>
</div>
@endsection
