<?php

namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class categorias extends Controller {
    
  public function store_categorie(request $data) {
  	$temp = Http::withHeaders([
        'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
    ])->post(config('app.api_rest_url').'/categorie',[
    	'categorie' => $data['categoria'],
    	'description' => $data['descripcion'],
    ]);
    if ( $temp['Categorie'] == 'Disapproved' ) { 
    	return redirect()->back()->withErrors('Denegado');
    }
    else if ( $temp['Categorie'] == 'Error' ) {
    	return redirect()->back()->withErrors('Error al Crear el Producto');
    }
    else if ( $temp['Categorie'] == 'Created' ) {
    	return redirect()->back()->withSuccess('Categoría Creada');
    }
    else {
    	return redirect()->back();
    }
  }

  public function delete_attribute(request $data) {
      # code...
  }

}