<?php

namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class evaluacion extends Controller {
      public function show_selection() {
        if ( !isset($_SESSION["tkn"]) ) { 
            return view('index');
        }
        else { 
          $config = [
            'id' => base64_decode($_SESSION["id_user"]),
            'username' => str_replace('"','',base64_decode($_SESSION["username"])),
            'img' => str_replace('"','',base64_decode($_SESSION["img"])),
            'permisos' => json_decode( base64_decode($_SESSION["permisions"]), true)
          ];
          return view('select_type_quantity')->with('config',$config)->with('unlock_pass','');
        }
      }

      public function post_selection(request $data) {
        $config = [
          'id' => base64_decode($_SESSION["id_user"]),
          'username' => str_replace('"','',base64_decode($_SESSION["username"])),
          'img' => str_replace('"','',base64_decode($_SESSION["img"])),
          'permisos' => json_decode( base64_decode($_SESSION["permisions"]), true)
        ];
        if ($data['quantity'] < 1) {
          return redirect()->back()->withErrors('Indique la Cantidad de Áreas');
        }
        if ( $data['type'] == '200xc' ) {
          $all_areas = $this->selective_areas();
          $datos = [
            'todas_areas' => $all_areas,
            'aleat_areas' => 'none',
          ];
        }
        else if ( $data['type'] == '350ms' ) { 
          $areas = $this->random_areas($data['quantity']);
          $all_areas = $this->selective_areas();
          $datos = [
            'todas_areas' => $all_areas,
            'aleat_areas' => $areas,
          ];
          if ( $areas[0] == 'max') {
            return redirect()->back()->withErrors('Solo hay '.$areas[1].' Áreas Disponibles..!');
          }
        }
        return view('evaluacion_multiples_areas')->with('config',$config)->with('unlock_pass','');
        return $datos;
      }

      private function get_categories() {
        $categories = Http::withHeaders([
          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
        ])->get(config('app.api_rest_url').'/categorie');$temp = [];
        $categories = json_decode($categories, true); 
        return $categories['Categorie'];
      }
      private function get_areas() {
        $areas = Http::withHeaders([ 
          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
        ])->get(config('app.api_rest_url').'/area');
        $areas = json_decode($areas, true);
        return $areas['Area'];
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
                $i=1;//echo $area['identifier_value'].'-';
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
      private function selective_areas() {
        $areas = $this->get_areas_not_used();  
        $aux=[];
        foreach ($areas as $key => $area) {
          $aux[$key]['id'] = $area['id'];
          $aux[$key]['nickname'] = $area['nickname'];
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
      private function random_areas($max) {
        $areas = $this->get_areas_not_used();  
        $aux=[];
        if ( $max <= count($areas) ) {
          $areas_keys = [];$areas_keys[0]=-5;
          for ($i=0; $i < $max; $i++) { 

            do {
              $rnd = mt_rand(0,count($areas)-1);
              $rnd = rand(0,$rnd);
             // $search_rnd = in_array($rnd, $count, false);
              $search_rnd = array_search($rnd,$areas_keys);
              if ( $search_rnd === false ) {
                $areas_keys[$i] = $rnd;
                $valid = true;
              }
              else {
                $valid = false;
              }
            } while ($valid == false);

          } 
          foreach ($areas_keys as $key => $indice) {
            foreach ($areas as $yek => $area) {
              if ( $indice == $yek) {
                $aux[$key]['id'] = $area['id'];
                $aux[$key]['nickname'] = $area['nickname'];
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
            }
          }
        }
        else{
          $aux = ['max',count($areas)];
        }
        return $aux;
      }
}