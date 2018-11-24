<?php

namespace App\Http\Controllers;

use App\Grado;
use Illuminate\Http\Request;

class GradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segment = $request->segment(1);
        $grados = Grado::all();

        return view('admin.grados.index', compact('segment', 'grados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $segment = $request->segment(1);
        return view('admin.grados.agregar', compact('segment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'grado' => 'required|string|max:45|unique:grados',
        ]);

        $grado = Grado::create($request->all());

        return response()->json($grado->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grado $grado)
    {
        $request->validate([
            'grado' => "filled|string|max:45|unique:grados,grado,$request->id",
        ]);

        $grado->update($request->all());
        $grado = Grado::find($request->id);
        return response()->json($grado->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grado  $grado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grado $grado)
    {
        Grado::destroy($grado->id);
        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
