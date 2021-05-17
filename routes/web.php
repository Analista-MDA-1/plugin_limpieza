<?php

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

/*Route::get('/', function () {
    return view('index');
})->name('show_login');*/

/*Route::get('/template', function () {
    return view('templated');
});*/


/*Route::namespace("App\\Http\\Controllers")->group(function () {
	Route::get("/", "index@show")->name('index');
    Route::post("/log_in", "log_user@login")->name('login');
    Route::post("/log_out", "log_user@logout")->name('logout');
});*/

Route::namespace("App\\Http\\Controllers")->group(function () {
	Route::get("/", "index@show")->name('index');
    Route::post("/log_in", "log_user@login")->name('login');
    Route::post("/log_out", "log_user@logout")->name('logout');
    Route::get("/atributos/{parametro?}", "page_four@mostrar_atributos")->name('attributes'); 
    Route::post("/atributo.store", "atributos@store_attribute")->name('store_atributo');
    
    Route::get("/categorias/{parametro?}", "page_four@mostrar_categorias")->name('categories'); 
    Route::get("/nueva_area", "page_three@ver_nueva_area")->name('ver_nueva_area'); 
    Route::get("/ver_areas/{parametro?}", "page_three@ver_areas")->name('ver_areas');
    Route::post("/categorias.store", "categorias@store_categorie")->name('store_categoria');
    //Route::get("/ver_area/{id?}", "once_area@show")->name('ver_area');
    Route::get("/gestionar_area/{id?}", "once_area@show_edit")->name('gestionar_area');
    Route::get("/ver_area/{id?}", "once_area_view@show")->name('ver_area');
    Route::get("/mi_perfil", "profile_setting@mostrar_perfil")->name('editar_perfil');

    Route::post("/nueva_area", "area_header@store_area")->name('store_header_area');

    Route::post("/body.store", "body_area@store_body")->name('store_body');

    Route::get("/pre_evaluar", "evaluacion@show_selection")->name('show_evaluar_type');
    Route::post("/pre_evaluar", "evaluacion@post_selection")->name('evaluar_type');

    Route::get("/evaluacion/{id}", "show_evaluacion@main")->name('evaluacion_show');

    Route::post("/add_new_are_eva", "evaluacion@add_area_evaluate")->name('eva_new_area_add');
});