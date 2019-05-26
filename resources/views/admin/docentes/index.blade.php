@extends('layouts.dashboard')
@section('contenido')
<div class="row">
    <div class="col-12 bg-secondary text-white">
        <h3 class="text-center">Listado de Docentes</h3>
    </div>
</div>

<section id="listadoDocentes" class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">

    <div class="mdl-tabs__tab-bar sticky-top bg-light">
        <a href="#activos-panel" class="mdl-tabs__tab is-active">Activos</a>
        {{-- <a href="#inactivos-panel" class="mdl-tabs__tab">Inactivos</a> --}}
    </div>

    <div class="mdl-tabs__panel is-active p-2 container" id="activos-panel">
        @component('admin.docentes.partials.docentes', ['docentes' => $docentesActivos]) @endcomponent
    </div>
    <div class="mdl-tabs__panel p-2 container" id="inactivos-panel">
        @component('admin.docentes.partials.docentes', ['docentes' => $docentesInactivos]) @endcomponent
    </div>

</section>

<style>
    #btnAgregarDocente {
        position: fixed;
        display: block;
        right: 0;
        bottom: 0;
        margin-right: 30px;
        margin-bottom: 30px;
        z-index: 900;
    }
</style>
<!-- Colored FAB button with ripple -->
<a id="btnAgregarDocente" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-color-text--white"
    href="{{ route('docentes.create') }}">
    <i class="material-icons">add</i>
</a>
@endsection
@section('scripts')
<script>
$('.mdl-tabs__tab-bar a').click(function(){
    $('input[type="search"]').val('');
});
</script>
@endsection
