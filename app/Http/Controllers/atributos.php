<?php

namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class atributos extends Controller {
    
  public function store_attribute(request $data) {
  	$temp = Http::withHeaders([
        'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
    ])->post(config('app.api_rest_url').'/atrribute',[
    	'attribute' => $data['atributo'],
    	'tkn' => $_SESSION["tkn"],
    ]);
    if ( $temp['Attribute'] == 'Disapproved' ) { 
    	return redirect()->back()->withErrors('Denegado');
    }
    else if ( $temp['Attribute'] == 'Error' ) {
    	return redirect()->back()->withErrors('Error al Crear el Producto');
    }
    else if ( $temp['Attribute'] == 'Created' ) {
    	return redirect()->back()->withSuccess('Atributo Creado');
    }
    else {
    	return redirect()->back();
    }
  }

  public function delete_attribute(request $data) {
      # code...
  }

}