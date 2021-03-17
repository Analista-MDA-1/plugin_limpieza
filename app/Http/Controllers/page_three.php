<?php
namespace App\Http\Controllers;
session_start(); 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class page_three extends Controller {
	public function ver_nueva_area() {   
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

			return view('new_area')->with('config',$config)->with('unlock_pass','')->with('datos',$this->datos())->withSuccess('Añadir Nuevo Atributo');
		}
	}
	public function datos() {
		$aux = Http::withHeaders([ 
          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
        ])->get(config('app.api_rest_url').'/categorie');$temp_ctg = [];
        $aux = json_decode($aux, true); 
        foreach ( $aux['Categorie'] as $key => $categoria ) {
	        	$temp_ctg[$key]['id'] = $categoria['id'];
	        	$temp_ctg[$key]['categoria'] = $categoria['categorie'];
        }
		/*$aux = Http::withHeaders([ 
          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
        ])->get(config('app.api_rest_url').'/parameter');$temp = [];
        $aux = json_decode($aux, true); 
        $source_room; 
        foreach ($aux['Parameter'] as $parameter) {
        	if ( $parameter['meta_key'] == '__env-source-room__' ) {
        		$source_room = $parameter['meta_value'];
        	}
        }
        if (  $source_room == '__Mixta__' || $source_room == '__PMS__' ) {
        	# code...
        }*/
        $pms_rooms = Http::withHeaders([ 
	          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
	        ])->get(config('app.api_rest_url').'/get_pms_rooms');
        $datos = [  
			'categorias' => $temp_ctg,
			'areas_pms' => $pms_rooms['Pms_Rooms'],
        ];
        return $datos;
	}
	public function ver_areas($parametro='') {   
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
			$areas = Http::withHeaders([ 
	          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
	        ])->get(config('app.api_rest_url').'/area');
	        $areas = json_decode($areas, true);  //return $areas;
	        //------
	        $categorias = Http::withHeaders([ 
	          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
	        ])->get(config('app.api_rest_url').'/categorie/deleted');
	        $categorias = json_decode($categorias, true); 
	        //------
	        $aux=[];$count=0;
	        foreach ($areas['Area'] as $key => $area) {
	        	foreach ($categorias['Categorie'] as $key2 => $categoria) {
	        		if ( $area['ref_id_categorie'] == $categoria['id']) {
	        			$aux[$count]['id'] = $area['id'];
	        			$aux[$count]['categoria'] = $categoria['categorie'];
	        			if ( $area['identifier_key'] == 1 ) {
	        				$aux[$count]['tipo'] = 'Propio';
	        				$aux[$count]['link'] = 0;
	        			}
	        			if ( $area['identifier_key'] == 2 ) {
	        				$aux[$count]['tipo'] = 'Externo';
	        				$aux[$count]['link'] = $area['identifier_value'];
	        			}
	        			$aux[$count]['nickname'] = $area['nickname'];
	        			if ( $area['statu_area'] == 1) {
	        				$aux[$count]['estado'] = 'Disponible';
	        			}
	        			else if ( $area['statu_area'] == 2) {
	        				$aux[$count]['estado'] = 'En Uso';
	        			}
	        			else if ( $area['statu_area'] == 3) {
	        				$aux[$count]['estado'] = 'Sucia';
	        			}
	        			else if ( $area['statu_area'] == 4) {
	        				$aux[$count]['estado'] = 'Deshabilitada';
	        			}
	        			$count++;
	        		}
	        	}
	        }
	        //------
	        $cc=0;$temp_aux=[];
			if ( $parametro != '' ) {
				foreach ( $aux as $key => $area ) {
					$lev1 = levenshtein($area['id'], $parametro);
					$lev2 = levenshtein($area['categoria'], $parametro);
					$lev3 = levenshtein($area['tipo'], $parametro);
					$lev4 = levenshtein($area['link'], $parametro);
					$lev5 = levenshtein($area['nickname'], $parametro);
					$lev6 = levenshtein($area['estado'], $parametro);
					//$lev7 = levenshtein($area['estado'], $parametro);
					if ( $lev1 == 0 || $lev2 <= 3 || $lev3 <=2  || $lev4 == 0 || $lev5 <= 3 || $lev6 <= 3 ) {
						$temp_aux[$cc]['id'] = $area['id'];
						$temp_aux[$cc]['categoria'] = $area['categoria'];
						$temp_aux[$cc]['tipo'] = $area['tipo'];
						$temp_aux[$cc]['link'] = $area['link'];
						$temp_aux[$cc]['nickname'] = $area['nickname'];
						$temp_aux[$cc]['estado'] = $area['estado']; 
						$cc++;
					}
				}	
				$aux = $temp_aux;
			}
			//$aux = json_encode( $aux, JSON_UNESCAPED_UNICODE );
			return view('areas')->with('config',$config)->with('unlock_pass','')->with('areas',$aux)->withSuccess('Añadir Nuevo Atributo');
		}
	}
}
