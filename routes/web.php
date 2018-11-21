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

Route::resources([
    'alumnos' => 'AlumnoController',
    'docentes' => 'DocenteController',
    'admins' => 'AdminController',
]);

Route::resource('grados', 'GradoController')->only(['index', 'store', 'update', 'destroy']);
