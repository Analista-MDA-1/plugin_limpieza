<?php
namespace App\Http\Controllers;
session_start(); 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
 
class page_four extends Controller {
	public function mostrar_atributos($parametro='') {    
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
			return view('atributos')->with('config',$config)->with('unlock_pass','')->with('atributos',$this->buscar_atributos($parametro))->withSuccess('Añadir Nuevo Atributo');
		}
	}  
	private function buscar_atributos($value) { 
        $aux = Http::withHeaders([
          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
        ])->get(config('app.api_rest_url').'/atrribute');$temp = [];
        $aux = json_decode($aux, true); 
        /*foreach ( $aux['Attribute'] as $key => $atributo ) {
        	$temp[$key]['id'] = json_decode($atributo['id'],true);
        	$temp[$key]['fecha'] = json_encode($atributo['updated_at'],JSON_UNESCAPED_UNICODE);
        	$temp[$key]['nombre'] = json_encode($atributo['attribute'],JSON_UNESCAPED_UNICODE);
        	$temp[$key]['estado'] = json_decode($atributo['status'],true);
        }*/  
        if ( is_null($value) || empty($value) ) {
        	foreach ( $aux['Attribute'] as $key => $atributo ) {
	        	$temp[$key]['id'] = $atributo['id'];
	        	$temp[$key]['fecha'] = $atributo['updated_at'];
	        	$temp[$key]['nombre'] = $atributo['attribute'];
	        	$temp[$key]['estado'] = $atributo['status'];
        	}
        }
        else {
        	foreach ( $aux['Attribute'] as $key => $atributo ) {
        		$lev1 = levenshtein($atributo['id'], $value);
        		$lev2 = levenshtein( date('d-m-Y', strtotime($atributo['updated_at'])), $value);
        		$lev3 = levenshtein($atributo['attribute'], $value);
        		if ( $lev1 == 0 || $lev2 == 0 || $lev3 <= 3) {
        			$temp[$key]['id'] = $atributo['id'];
		        	$temp[$key]['fecha'] = $atributo['updated_at'];
		        	$temp[$key]['nombre'] = $atributo['attribute'];
		        	$temp[$key]['estado'] = $atributo['status'];
        		}
        	}
        }
        return $temp;
		//return json_encode($temp, JSON_UNESCAPED_UNICODE);
	}
	public function mostrar_categorias($parametro='') {   
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
			return view('categorias')->with('config',$config)->with('unlock_pass','')->with('categorias',$this->buscar_categorias($parametro))->withSuccess('Añadir Nuevo Atributo');
		}
	}
	private function buscar_categorias($value) {
		$aux = Http::withHeaders([
          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
        ])->get(config('app.api_rest_url').'/categorie');$temp = [];
        $aux = json_decode($aux, true); 
        /*foreach ( $aux['Attribute'] as $key => $atributo ) {
        	$temp[$key]['id'] = json_decode($atributo['id'],true);
        	$temp[$key]['fecha'] = json_encode($atributo['updated_at'],JSON_UNESCAPED_UNICODE);
        	$temp[$key]['nombre'] = json_encode($atributo['attribute'],JSON_UNESCAPED_UNICODE);
        	$temp[$key]['estado'] = json_decode($atributo['status'],true);
        }*/
         
        if ( is_null($value) || empty($value) ) {
        	foreach ( $aux['Categorie'] as $key => $categorie ) {
	        	$temp[$key]['id'] = $categorie['id'];
	        	$temp[$key]['categorie'] = $categorie['categorie'];
	        	$temp[$key]['description'] = $categorie['description'];
        	}
        }
        else {
        	foreach ( $aux['Categorie'] as $key => $categorie ) {
        		$lev1 = levenshtein($categorie['id'], $value);
        		$lev2 = levenshtein($categorie['categorie'], $value);
        		$lev3 = levenshtein($categorie['description'], $value);
        		if ( $lev1 == 0 || $lev2 <= 3 || $lev3 <= 5) {
        			$temp[$key]['id'] = $categorie['id'];
		        	$temp[$key]['categorie'] = $categorie['categorie'];
		        	$temp[$key]['description'] = $categorie['description'];
        		}
        	}
        }
        return $temp;
	}
}
