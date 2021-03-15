<?php
namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;

class area_body extends Controller {

	public function mostrar_perfil() {   
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
			/*Http::withHeaders([  
	          'auth-tkn-pms' => base64_decode($_SESSION["tkn"]),
	        ])->get(config('app.api_rest_url').'/get_session_img');*/
			return view('profile')->with('config',$config)->with('unlock_pass','')->withSuccess('Mi Perfil');
		}
	}

}
