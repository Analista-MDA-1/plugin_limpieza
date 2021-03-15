<?php
namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
class index extends Controller {
	public function show() {   
		if ( !isset($_SESSION["tkn"]) ) { 
    		return view('index');
	  		//return redirect()->to(route('start'))->withErrors('Debe Iniciar Sessión');
		}
		/*if ( !session()->has('tkn') ) {  
    		return view('index');
		}*/
		else { 
			$config = [
				'id' => base64_decode($_SESSION["id_user"]),
				'username' => str_replace('"','',base64_decode($_SESSION["username"])),
				'img' => str_replace('"','',base64_decode($_SESSION["img"])),
				'permisos' => json_decode( base64_decode($_SESSION["permisions"]), true)
			];//256bits
			return view('templated')->with('config',$config)->with('unlock_pass','')->withSuccess('Inició Sessión');
		}
	}
}
