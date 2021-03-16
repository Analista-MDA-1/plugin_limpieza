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
        if ($data['quantity'] < 1) {
          return redirect()->back()->withErrors('Indique la Cantidad de Áreas');
        }
        if ( $data['type'] == '200xc' ) {
          $data = '1';
        }
        else if ( $data['type'] == '350ms' ) {
          $rnd_areas = $this->random_areas($data['quantity']);
          if ( $rnd_areas[0] == 'max') {
            return redirect()->back()->withErrors('Solo hay '.$rnd_areas[1].' Áreas Disponibles..!');
          }
          else {
            return $rnd_areas;
          }
        }
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

      private function random_areas($max) {
        $areas = $this->get_areas(); 
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