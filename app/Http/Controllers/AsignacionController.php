<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Http\Requests\StoreAsignacion;
use App\Http\Requests\UpdateAsignacion;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAsignacion $request)
    {
        // dd($request->all());
        $existente = Asignacion::where('periodo_id', $request->periodo_id)
            ->where('docente_carnet', $request->docente_carnet)
            ->where('materia_id', $request->materia_id)
            ->where('grado_id', $request->grado_id)
            ->count();
        if ($existente > 0) {
            return response()->json(['error' => 'Ya existe la asignación en el período indicado.'], 422);
        }
        $asignacion = Asignacion::create($request->all());
        $periodo = $asignacion->periodo->periodo;
        $grado = $asignacion->grado->grado;
        $materia = $asignacion->materia->materia;

        return response()->json(['asignacion' => $asignacion, 'periodo' => $periodo, 'grado' => $grado, 'materia' => $materia]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Asignacion  $asignacion
     * @return \Illuminate\Http\Response
     */
    public function show(Asignacion $asignacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asignacion  $asignacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Asignacion $asignacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asignacion  $asignacion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAsignacion $request, Asignacion $asignacion)
    {
        $existente = Asignacion::where('periodo_id', $asignacion->periodo_id)
            ->where('docente_carnet', $asignacion->docente_carnet)
            ->where('materia_id', $asignacion->materia_id)
            ->where('grado_id', $request->grado_id)
            ->count();
        if ($existente > 0) {
            return response()->json(['error' => 'Ya existe la asignación en el período indicado.'], 422);
        }
        $asignacion->update($request->all());
        $periodo = $asignacion->periodo->periodo;
        $grado = $asignacion->grado->grado;
        $materia = $asignacion->materia->materia;

        return response()->json(['asignacion' => $asignacion, 'periodo' => $periodo, 'materia' => $materia, 'grado' => $grado]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asignacion  $asignacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asignacion $asignacion)
    {
        // dd($asignacion->id);
        $asignacion = Asignacion::destroy($asignacion->id);
        return response()->json(['message' => 'Asignación eliminada con éxito']);
    }
}
