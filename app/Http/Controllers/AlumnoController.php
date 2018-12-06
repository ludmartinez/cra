<?php

namespace App\Http\Controllers;

use App\User;
use App\Grado;
use App\Alumno;
use App\Periodo;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAlumno;
use App\CustomHelpers\StringHelper;
use App\Http\Requests\UpdateAlumno;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Storage;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segment = $request->segment(2);
        $alumnosActivos = Alumno::where('estado', true)->get();
        $alumnosInactivos = Alumno::where('estado', false)->get();
        // dd($segment);
        return view('admin.alumnos.index', compact('alumnosActivos', 'alumnosInactivos', 'segment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $segment = $request->segment(2);
        return view('admin.alumnos.agregar', compact('segment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlumno $request)
    {
        $apellidosIniciales = str_limit($request->apellidoPaterno, 1, '') . str_limit($request->apellidoMaterno, 1, '');
        $correlativo = User::where('usuario', 'like', "$apellidosIniciales%")->count();
        $correlativo++;
        while (strlen($correlativo) < 4) {
            $correlativo = '0' . $correlativo;
        }
        $carnet = $apellidosIniciales . $correlativo . str_after(now()->year, str_limit(now()->year, 2, ''));
        $carnet = StringHelper::str_withoutAccent($carnet);
        $alumno = new Alumno;
        $alumno->carnet = $carnet;
        $alumno->fill($request->all());
        if ($request->hasFile('foto')) {
            $path = Storage::url($request->file('foto')->store('fotos/alumnos'));
            $alumno->foto = $path;
        }
        $alumno->save();
        $alumno = Alumno::find($carnet);
        return response()->json(['alumno' => $alumno->toArray()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function show(Alumno $alumno, Request $request)
    {
        $segment = $request->segment(2);
        $user = $alumno->user;
        $matriculas = $alumno->matriculas;
        $grados = Grado::all();
        $periodos =  Periodo::all();
        // dd($matriculas);
        return view('admin.alumnos.alumno', compact('alumno', 'user', 'matriculas','grados', 'periodos', 'segment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Alumno $alumno)
    {
        $segment = $request->segment(2);
        return view('admin.alumnos.editar', compact('alumno', 'segment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlumno $request, Alumno $alumno)
    {
        $data = $request->all();
        $user = $alumno->user;
        if (count($data) > 2) {
            $alumno->fill($data);
            $user->fill($data);
            if ($request->hasFile('foto')) {
                $path_old = str_after($alumno->foto, 'storage/');
                $path = Storage::url($request->file('foto')->store('fotos/alumnos'));
                Storage::delete($path_old);
                $alumno->foto = $path;
            }
            $alumno->save();
            $user->save();
            return response()->json(['alumno' => $alumno->toArray(), 'user' => $user->toArray()]);
        }
        return response()->json(['warning' => 'No hay datos para modificar']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumno $alumno)
    {
        //
    }
}
