<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(PetController::class)->group(function () {
    Route::get('/pets', 'index')->name('pets.index');
    Route::get('/pets/create', 'create')->name('pets.create');
    Route::get('/pets/{id}', 'show')->name('pets.show');
    Route::get('/pets/{id}/edit', 'edit')->name('pets.edit');
    Route::post('/pets', 'store')->name('pets.store');
    Route::put('/pets/{id}', 'update')->name('pets.update');
    Route::delete('/pets/{id}', 'delete')->name('pets.delete');
});
