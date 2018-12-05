<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix('admin')->middleware('auth')->group(function(){
    Route::resources([
        'alumnos' => 'AlumnoController',
        'docentes' => 'DocenteController',
        'admins' => 'AdminController',
    ]);

    Route::resource('grados', 'GradoController')->except(['edit', 'create']);
    Route::resource('materias', 'MateriaController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('periodos', 'PeriodoController')->except(['create']);
    Route::resource('matriculas', 'MatriculaController');
    Route::resource('asignaciones', 'AsignacionController')->parameters(['asignaciones' => 'asignacion']);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
