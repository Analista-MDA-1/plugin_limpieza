<?php

namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class area_header extends Controller {
        
  public function store_area(request $data) {
    if ( $data['ref_id_categorie'] == 'nix') {
      return redirect()->back()->withErrors('Seleccionar una Categoría');
    }
    if ( $data['fuente_area'] == 'nix' || ( $data['fuente_area'] > 2 && $data['fuente_area'] < 1) ) {
      return redirect()->back()->withErrors('Seleccionar el Origen o Fuente');
    }
    if ( empty($data['nickname']) || $data['nickname'] == '' ) {
      return redirect()->back()->withErrors('Indique un Apodo');
    }    
    if ( $data['statu_area'] == 'nix') {
      return redirect()->back()->withErrors('Seleccionar Estado Actual del Area');
    } 
    $identifier_key;$identifier_value =0;
    if ( $data['fuente_area'] == 1 ) { 
      $identifier_key = 1;
    }
    else if ( $data['fuente_area'] == 2 ) {
      if ( $data['area_externa'] == 'nix' ) {
        return redirect()->back()->withErrors('Seleccione Area de Referencia');
      } 
      else {
        $identifier_key = 1;
        $identifier_value = $data['area_externa'];
      }
    }
    ///return redirect()->back()->withSuccess('Success');

  	$temp = Http::withHeaders([
        'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
    ])->post(config('app.api_rest_url').'/area',[
      'ref_id_categorie' => $data['ref_id_categorie'],
      'identifier_key' => $identifier_key,
      'identifier_value' => $identifier_value,
      'nickname' => $data['nickname'],
      'statu_area' => $data['statu_area'],
    ]);
    //return $temp;
    if ( $temp['Area'] == 'Disapproved' ) { 
    	return redirect()->back()->withErrors('Denegado');
    }
    else if ( $temp['Area'] == 'Error' ) {
    	return redirect()->back()->withErrors('Error al Crear Area');
    }
    else if ( $temp['Area'] == 'Created' ) {
    	return redirect()->back()->withSuccess('Area Creada');
    }
    else {
    	return redirect()->back();
    }
  }

  public function delete_attribute(request $data) {
      # code...
  }

}