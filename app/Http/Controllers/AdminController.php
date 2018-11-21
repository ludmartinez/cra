<?php

namespace App\Http\Controllers;

use App\Admin;
use App\CustomHelpers\StringHelper;
use App\Http\Requests\StoreAdmin;
use App\Http\Requests\UpdateAdmin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segment = $request->segment(1);
        $adminsActivos = Admin::where('estado', true)->get();
        $adminsInactivos = Admin::where('estado', false)->get();
        return view('admin.admins.index', compact('segment', 'adminsActivos', 'adminsInactivos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $segment = $request->segment(1);
        return view('admin.admins.agregar', compact('segment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdmin $request)
    {
        $apellidosIniciales = str_limit($request->apellidoPaterno, 1, '') . str_limit($request->apellidoMaterno, 1, '');
        $correlativo = User::where('usuario', 'like', "$apellidosIniciales%")->count();
        $correlativo++;
        while (strlen($correlativo) < 4) {
            $correlativo = '0' . $correlativo;
        }
        $carnet = $apellidosIniciales . $correlativo . str_after(now()->year, str_limit(now()->year, 2, ''));
        $carnet = StringHelper::str_withoutAccent($carnet);
        $admin = new Admin;
        $admin->carnet = $carnet;
        $admin->fill($request->all());
        if ($request->hasFile('foto')) {
            $path = Storage::url($request->file('foto')->store('fotos/admins'));
            $admin->foto = $path;
        }
        $admin->superUsuario = $request->tipo;
        $admin->save();
        $admin = Admin::find($carnet);
        return response()->json(['admin' => $admin->toArray()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Admin $admin)
    {
        $segment = $request->segment(1);
        $user = $admin->user;
        return view('admin.admins.admin', compact('segment', 'admin', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Admin $admin)
    {
        $segment = $request->segment(1);
        return view('admin.admins.editar', compact('admin', 'segment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdmin $request, Admin $admin)
    {
        $data = $request->all();
        $user = $admin->user;
        // dd($data);
        if (count($data) > 2) {
            $admin->fill($data);
            $user->fill($data);
            if ($request->hasFile('foto')) {
                $path_old = str_after($admin->foto, 'storage/');
                $path = Storage::url($request->file('foto')->store('fotos/admins'));
                Storage::delete($path_old);
                $admin->foto = $path;
            }
            if($request->has('tipo')){
                $admin->superUsuario = $request->tipo;
            }
            $admin->save();
            $user->save();
            return response()->json(['admin' => $admin->toArray(), 'user' => $user->toArray()]);
        }
        return response()->json(['warning' => 'No hay datos para modificar']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
