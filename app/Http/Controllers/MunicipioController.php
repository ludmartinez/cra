<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segment = $request->segment(2);
        $municipios = Municipio::all();
        $departamentos = Departamento::all();
        return view('admin.direcciones.municipio.index', compact('segment', 'municipios', 'departamentos'));
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
    public function store(Request $request)
    {
        $request->validate([
            'municipio' => 'required|string|max:35|unique:municipios',
            'id_departamento' => 'required|integer',
        ]);
        $municipio = Municipio::create($request->all());
        $departamento = $municipio->departamento;

        return response()->json(compact('municipio', 'departamento'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function show(Municipio $municipio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function edit(Municipio $municipio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Municipio $municipio)
    {
        $request->validate([
            'municipio' => "required|string|max:30|unique:municipios,municipio,$municipio->id",
            'id_departamento' => "required|integer",
        ]);
        $municipio->update($request->all());
        $departamento = $municipio->departamento;

        return response()->json(['municipio' => $municipio, 'departamento' => $departamento]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Municipio $municipio)
    {
        //
    }
}
