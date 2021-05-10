<?php

namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class show_evaluacion extends Controller {
 
 public function main($id) {
    $config = [
      'id' => base64_decode($_SESSION["id_user"]),
      'username' => str_replace('"','',base64_decode($_SESSION["username"])),
      'img' => str_replace('"','',base64_decode($_SESSION["img"])),
      'permisos' => json_decode( base64_decode($_SESSION["permisions"]), true)
    ];
    $datos = [
      'todas_areas' => $this->selective_areas(),
      'atributos' => $this->data_atributtes(),
      'header' => $this->data_header($id),
      'aleat_areas' => $this->data_body($id),
    ];
    return view('evaluacion_multiples_areas')->with('datos',$datos)->with('config',$config)->with('unlock_pass','');
    return $datos;
  }
  private function data_body($id) {
    $aux_body = Http::withHeaders([
      'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
    ])->get(config('app.api_rest_url').'/report_body_header/'.$id);
    $aux_body = json_decode($aux_body, true);
    return $aux_body['Report_Body'];      
  }
  private function data_header($id) {
    $aux_header = Http::withHeaders([
      'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
    ])->get(config('app.api_rest_url').'/report/'.$id);
    $aux_header = json_decode($aux_header, true);
    return $aux_header['Report_Header'];
  }   
  private function data_atributtes() {
    $aux_atributos = Http::withHeaders([
          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
        ])->get(config('app.api_rest_url').'/area_attribute');
    $aux_atributos = json_decode($aux_atributos, true);
    return $aux_atributos['Body_Area'];
  }
  private function selective_areas() {
    $areas = $this->get_areas_not_used();  
    $aux=[];
    foreach ($areas as $key => $area) {
      $aux[$key]['id'] = $area['id'];
      $aux[$key]['nickname'] = $area['nickname'];
      $aux[$key]['identifier_value'] = $area['identifier_value'];
      switch ( $area['statu_area'] ) {
        case 1:
          $aux[$key]['estado'] = 'Disponible';
        break;
        case 2:
          $aux[$key]['estado'] = 'En Uso';
        break;
        case 3:
          $aux[$key]['estado'] = 'Sucia';
        break;
        case 4:
          $aux[$key]['estado'] = 'Deshabilitada';
        break;
      }   
    }   
    return $aux;
  }

  private function get_areas_not_used() {
    $areas = Http::withHeaders([ 
      'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
    ])->get(config('app.api_rest_url').'/area');
    $areas = json_decode($areas, true);

    $id_areas_used = Http::withHeaders([ 
      'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
    ])->get(config('app.api_rest_url').'/get_pms_rooms_used');
    $id_areas_used = json_decode($id_areas_used, true); 
    $temp=[];$count=0;$i=0;
    foreach ($areas['Area'] as $key => $area) {
      foreach ($id_areas_used['Pms_Rooms_Used'] as $key => $id_area_used) {
        if ($area['identifier_value'] == $id_area_used) {
            $i=1;
        }
      }
      if ( $i == 0 ) {
        $temp['Area'][$count] = $area;
        $count++;
      }
      else {
        $i = 0;
      }
    }

    return $temp['Area'];
  }
}