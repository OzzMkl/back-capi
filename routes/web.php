<?php

use App\Http\Controllers\ContactosController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get("/contactos/{type}/{search}", [ContactosController::class,"index"]);
Route::get("/contactos/{idContacto}", [ContactosController::class,"show"]);
Route::post("/contactos", [ContactosController::class,"store"]);
Route::put("/contactos/{idContacto}", [ContactosController::class,"update"]);
Route::delete("/contactos/{idContacto}", [ContactosController::class,"destroy"]);
