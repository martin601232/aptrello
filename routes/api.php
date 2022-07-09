<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\TableroController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UsuTabController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//RUTAS PARA TABLEROS
Route::get("/tableros/publicos",[TableroController::class,'mostrarTablerosPublicos'])->name("tableros.mostrarTablerosPublicos");
Route::get("/tableros",[TableroController::class,'index'])->name("tableros.index");
Route::middleware('auth:sanctum')->post("/tableros",[TableroController::class,'store'])->name("tableros.store");
Route::get("/tableros/{id}",[TableroController::class,'show'])->name("tableros.show");
Route::put("/tableros/{id}",[TableroController::class,'update'])->name("tableros.update");
Route::patch("/tableros/{id}",[TableroController::class,'update'])->name("tableros.update");
Route::middleware('auth:sanctum')->delete("/tableros/{id}",[TableroController::class,'destroy'])->name("tableros.destroy");
//RUTAS PARA LISTAS
Route::get("/listas",[ListaController::class,'index'])->name("listas.index");
Route::middleware('auth:sanctum')->post("/listas",[ListaController::class,'store'])->name("listas.store");
Route::get("/listas/{id}",[ListaController::class,'show'])->name("listas.show");
Route::middleware('auth:sanctum')->put("/listas/{id}",[ListaController::class,'update'])->name("listas.update");
Route::middleware('auth:sanctum')->patch("/listas/{id}",[ListaController::class,'update'])->name("listas.update");
Route::middleware('auth:sanctum')->delete("/listas/{id}",[ListaController::class,'destroy'])->name("listas.destroy");
Route::get("/listas/tableros/{id}",[ListaController::class,'listaDeListasPorTablero'])->name("listaDeListasPorTablero");
Route::get("/listas/cantableros/{id}",[ListaController::class,'CanDeListasPorTablero'])->name("canDeListasPorTablero");
//RUTAS PARA TARJETAS
Route::get("/tareas",[TareaController::class,'index'])->name("tareas.index");
Route::middleware('auth:sanctum')->post("/tareas",[TareaController::class,'store'])->name("tareas.store");
Route::get("/tareas/{id}",[TareaController::class,'show'])->name("tareas.show");
Route::middleware('auth:sanctum')->put("/tareas/{id}",[TareaController::class,'update'])->name("tareas.update");
Route::middleware('auth:sanctum')->patch("/tareas/{id}",[TareaController::class,'update'])->name("tareas.update");
Route::middleware('auth:sanctum')->delete("/tareas/{id}",[TareaController::class,'destroy'])->name("tareas.destroy");
Route::get("/tareas/lista",[ListaController::class,'listaDetareaPorTablero'])->name("listaDeListasPorTablero");
Route::get("/tareas/cantlsta/{id}",[TareaController::class,'CanDetareaPorTablero'])->name("canDeListasPorTablero");
//RUTAS PARA usutab
Route::get("/usutab",[UsuTabController::class,'index'])->name("usutab.index");
Route::post("/usutab",[UsuTabController::class,'store'])->name("usutab.store");
Route::get("/usutab/{id}",[UsuTabController::class,'show'])->name("usutab.show");
Route::put("/usutab/{id}",[UsuTabController::class,'update'])->name("usutab.update");
Route::patch("/usutab/{id}",[UsuTabController::class,'update'])->name("usutab.update");
Route::delete("/usutab/{id}",[UsuTabController::class,'destroy'])->name("usutab.destroy");
Route::get("/usutab/asociado/{id}",[TableroController::class,'showAsociado'])->name("usutab.showAsociado");

//RUTAS PARA USUARIO
Route::get("/users",[AuthController::class,'index'])->name("usuarios.index");
Route::post("/register",[AuthController::class,'register'])->name("users.register");
Route::middleware('auth:sanctum')->get("/users/show",[AuthController::class,'show'])->name("users.show");
Route::put("/users/{id}",[AuthController::class,'update'])->name("users.updatePut");
Route::patch("/users/{id}",[AuthController::class,'update'])->name("users.updatePatch");
Route::delete("/users/{id}",[AuthController::class,'destroy'])->name("users.destroy");
Route::post("/login",[AuthController::class, 'login'])->name("users.login");



//RUTAS PARA image
Route::get("/image",[ImageController::class,'index'])->name("image.index");
Route::post("/image",[ImageController::class,'store'])->name("image.store");
Route::get("/image/{id}",[ImageController::class,'show'])->name("image.show");
Route::put("/image/{id}",[ImageController::class,'update'])->name("image.update");
Route::patch("/image/{id}",[ImageController::class,'update'])->name("image.update");
Route::delete("/image/{id}",[ImageController::class,'destroy'])->name("image.destroy");
Route::get("/image/asociado/{id}",[ImageController::class,'showAsociado'])->name("image.showAsociado");
