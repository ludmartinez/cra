<?php

namespace App\Http\Controllers;

use App\CustomHelpers\StringHelper;
use App\Docente;
use App\Grado;
use App\Http\Requests\StoreDocente;
use App\Http\Requests\UpdateDocente;
use App\Materia;
use App\Periodo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segment = $request->segment(2);
        $docentesActivos = Docente::where('estado', true)->get();
        $docentesInactivos = Docente::where('estado', false)->get();
        return view('admin.docentes.index', compact('segment', 'docentesActivos', 'docentesInactivos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $segment = $request->segment(2);
        return view('admin.docentes.agregar', compact('segment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocente $request)
    {
        $apellidosIniciales = str_limit($request->apellidoPaterno, 1, '') . str_limit($request->apellidoMaterno, 1, '');
        $correlativo = User::where('usuario', 'like', "$apellidosIniciales%")->count();
        $correlativo++;
        while (strlen($correlativo) < 4) {
            $correlativo = '0' . $correlativo;
        }
        $carnet = $apellidosIniciales . $correlativo . str_after(now()->year, str_limit(now()->year, 2, ''));
        $carnet = StringHelper::str_withoutAccent($carnet);
        $docente = new Docente;
        $docente->carnet = $carnet;
        $docente->fill($request->all());
        if ($request->hasFile('foto')) {
            $path = Storage::url($request->file('foto')->store('fotos/docentes'));
            $docente->foto = $path;
        }
        $docente->save();
        $docente = Docente::find($carnet);
        return response()->json(['docente' => $docente->toArray()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Docente $docente)
    {
        $segment = $request->segment(2);
        $user = $docente->user;
        $asignaciones = $docente->asignaciones;
        $grados = Grado::all();
        $periodos = Periodo::all();
        $materias = Materia::all();
        return view('admin.docentes.docente', compact('segment', 'docente', 'user', 'asignaciones', 'grados', 'periodos', 'materias'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Docente $docente)
    {
        $segment = $request->segment(2);
        return view('admin.docentes.editar', compact('docente', 'segment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocente $request, Docente $docente)
    {
        $data = $request->all();
        $user = $docente->user;
        if (count($data) > 2) {
            $docente->fill($data);
            $user->fill($data);
            if ($request->hasFile('foto')) {
                $path_old = str_after($docente->foto, 'storage/');
                $path = Storage::url($request->file('foto')->store('fotos/docentes'));
                Storage::delete($path_old);
                $docente->foto = $path;
            }
            $docente->save();
            $user->save();
            return response()->json(['docente' => $docente->toArray(), 'user' => $user->toArray()]);
        }
        return response()->json(['warning' => 'No hay datos para modificar']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Docente $docente)
    {
        //
    }

    public function mainpage(Request $request)
    {
        $segment = "";
        $materias = $request->user()->docente->asignaciones->unique('materia_id');
        $asignaciones = $request->user()->docente->asignaciones;
        return view('docente.index', compact('segment', 'materias', 'asignaciones'));
    }
}
