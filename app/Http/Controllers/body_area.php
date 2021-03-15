<?php

namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class body_area extends Controller {
  public function store_body(request $data) { 
  	$temp = Http::withHeaders([
        'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
    ])->post(config('app.api_rest_url').'/area_attribute',[
      'ref_id_header' => $data['ref_id_header'],
    	'ref_id_attribute' => $data['ref_id_attribute'],
      'max_point' => $data['max_point'],
      'nickname' => $data['nickname']
    ]);
    if ( $temp['Body_Area'] == 'Disapproved' ) { 
    	return redirect()->back()->withErrors('Denegado');
    }
    else if ( $temp['Body_Area'] == 'Error' ) {
    	return redirect()->back()->withErrors('Error al Asignar el Atributo');
    }
    else if ( $temp['Body_Area'] == 'Invalid Attribute' ) {
      return redirect()->back()->withErrors('Atributo Seleccionado Inválido');
    }
    else if ( $temp['Body_Area'] == 'Invalid Area' ) {
    	return redirect()->back()->withErrors('Área Inválida');
    }
    else if ( $temp['Body_Area'] == 'Created' ) {
      return redirect()->back()->withSuccess('Atributo Asignado');
    }
    else {
    	return redirect()->back();
    }
  }

  public function delete_attribute(request $data) {
      # code...
  }

}