<?php
namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class once_area_view extends Controller { 

	public function show($id='') {   
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
			if ( $id == '' ) {
				//return redirect()->route('ver_areas')->withErrors('Parámetro Inválido');
			}
			else { 
				$area_header = $this->area_header($id);
				$area_body = $this->area_body($id);
				return view('show_area')->with('header',$area_header)->with('body',$area_body)->with('config',$config)->with('unlock_pass','')->withSuccess('Gestionar Área');
			}		
		}
	}

	private function area_header($id) {
		$temp_area_header = Http::withHeaders([
          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
        ])->get(config('app.api_rest_url').'/area/'.$id);
        $temp_area_header = json_decode($temp_area_header, true); 
        $temp_area_header  = $temp_area_header['Area'];

        $aux_categorie = Http::withHeaders([
          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
        ])->get(config('app.api_rest_url').'/categorie/deleted');
        $aux_categorie = json_decode($aux_categorie, true);
        //$aux_area_header = [];
        $count_aux_header=0; 
    	foreach ($aux_categorie['Categorie'] as $key => $categoria) {
    			if ( $temp_area_header['ref_id_categorie'] == $categoria['id'] ) {
    				$aux_area_header[$count_aux_header]['id'] = $temp_area_header['id'];
    				$aux_area_header[$count_aux_header]['id_categorie'] = $temp_area_header['ref_id_categorie'];
    				$aux_area_header[$count_aux_header]['categorie'] = $categoria['categorie'];
    				if ( $temp_area_header['identifier_key'] == 1 ) {  
    					$aux_area_header[$count_aux_header]['identifier_key'] = 'Propio';
    					$aux_area_header[$count_aux_header]['link'] = 0;
    				}
    				elseif ( $temp_area_header['identifier_key'] == 2 ) {
    					$aux_area_header[$count_aux_header]['identifier_key'] = 'Externo';
    					$aux_area_header[$count_aux_header]['link'] = $temp_area_header['identifier_value'];
    				}
    				$aux_area_header[$count_aux_header]['nickname'] = $temp_area_header['nickname'];
    				if ( $temp_area_header['statu_area'] == 1 ) {
    					$aux_area_header[$count_aux_header]['estado'] = 'Disponible';
    				}
    				elseif ( $temp_area_header['statu_area'] == 2 ) {
    					$aux_area_header[$count_aux_header]['estado'] = 'En Uso';
    				}
    				elseif ( $temp_area_header['statu_area'] == 3 ) {
    					$aux_area_header[$count_aux_header]['estado'] = 'Sucia';
    				}
    				elseif ( $temp_area_header['statu_area'] == 4 ) {
    					$aux_area_header[$count_aux_header]['estado'] = 'Deshabilitada';
    				}
    				$count_aux_header++;
    			}
    	}    
    	return $aux_area_header[0];
	}
	public function area_body($id) {
		$aux_body = Http::withHeaders([
          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
        ])->get(config('app.api_rest_url').'/get_area_attribute/'.$id);$temp = [];
        $aux_body = json_decode($aux_body, true);
        $aux_atributos = Http::withHeaders([
          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),     
        ])->get(config('app.api_rest_url').'/atrribute/deleted');
        $aux_atributos = json_decode($aux_atributos, true);
        $count_aux_body=0; 
		foreach ( $aux_body['Body_Area'] as $key => $value) {
			foreach ( $aux_atributos['Attribute'] as $key => $atributo ) {
				if ( $atributo['id'] ==  $value['ref_id_attribute'] ) {
					$temp[$count_aux_body]['id'] = $value['id'];
					$temp[$count_aux_body]['ref_id_header'] = $value['ref_id_header'];
					$temp[$count_aux_body]['atributo'] = $atributo['attribute'];
					$temp[$count_aux_body]['max_point'] = $value['max_point'];
					$temp[$count_aux_body]['nickname'] = $value['nickname'];
					$temp[$count_aux_body]['status'] = $value['status'];
					$count_aux_body++;
				}
			}
		} 
		return $temp; 
	}
}
