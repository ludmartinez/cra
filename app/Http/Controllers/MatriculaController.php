<?php

namespace App\Http\Controllers;

use App\Grado;
use App\Http\Requests\StoreMatricula;
use App\Http\Requests\UpdateMatricula;
use App\Materia;
use App\Matricula;
use App\Periodo;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segment = $request->segment(2);
        $matriculas = Matricula::historial();
        return view('admin.matriculas.index', compact('segment', 'matriculas'));
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
    public function store(StoreMatricula $request)
    {
        $existente = Matricula::where('periodo_id', $request->periodo_id)
            ->where('alumno_carnet', $request->alumno_carnet)->count();
        if ($existente > 0) {
            return response()->json(['error' => 'Ya existe una matrícula en este período.'], 422);
        }
        $matricula = Matricula::create($request->all());
        $periodo = $matricula->periodo->periodo;
        $grado = $matricula->grado->grado;

        return response()->json(['matricula' => $matricula, 'periodo' => $periodo, 'grado' => $grado]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function show(Matricula $matricula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function edit(Matricula $matricula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMatricula $request, Matricula $matricula)
    {
        $matricula->update($request->all());
        $periodo = $matricula->periodo->periodo;
        $grado = $matricula->grado->grado;

        return response()->json(['matricula' => $matricula, 'periodo' => $periodo, 'grado' => $grado]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matricula $matricula)
    {
        Matricula::destroy($matricula->id);
        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    public function listadoGrados(Periodo $periodo, Materia $materia, Grado $grado)
    {
        $segment = "";
        $matriculas = Matricula::where([
            ['periodo_id', $periodo->id],
            ['grado_id', $grado->id],
        ])->get();
        return view('docente.listadogrados', compact('segment', 'matriculas', 'grado'));
        // return dd($matriculas);
    }
}
