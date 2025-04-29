<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\VehiclesController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('vehicles',VehiclesController::class);

//api
Route::get('api/list', [VehiclesController::class, 'listar']);
Route::get('api/listarup/{id}', [VehiclesController::class, 'listarup']);

Route::get('/marcas', [VehiclesController::class, 'Listarmarca']);
Route::get('/marcas/{id}/modelos', [VehiclesController::class, 'modelos']);
