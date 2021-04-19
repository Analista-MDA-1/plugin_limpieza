<?php

namespace App\Http\Controllers;
session_start();
//use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class log_user extends Controller
{
    public function login(request $data) {        
		$temp = Http::withHeaders([
        	'auth-tkn-pms' => config('app.api_rest_tkn'),
    	])->post(config('app.api_rest_url').'/login',$data->only('usuario','contras'));
		if ( isset($temp['required'])  ) {
			return redirect()->back()->withErrors('Llene los Datos');
		}
		if ( isset($temp['min'])  ) {
			return redirect()->back()->withErrors('Contraseña Inválida');
		}
		if ( $temp == 'expired_token') {
			return redirect()->back()->withErrors('Ficha de Acceso Expirada');
		}
		if ( $temp == 'User Inactive') {
			return redirect()->back()->withErrors('Usuario Desactivado');
		}
		if ( $temp == 'User Not Found') {
			return redirect()->back()->withErrors('Usuario y/o Contraseña Inválidos');
		} 
		if ( $temp == 'Incorrect Values') {
			return redirect()->back()->withErrors('Usuario y/o Contraseña Inválidos');
		} 
		else {
			$_SESSION["tkn"]=base64_encode($temp);
			$_SESSION["id_user"] = base64_encode(Http::post(config('app.api_rest_url').'/get_session_id',['tkn'=>$temp]));
			$_SESSION["username"] = base64_encode(Http::post(config('app.api_rest_url').'/get_session_username',['tkn'=>$temp]));
			$_SESSION["img"] = base64_encode(Http::post(config('app.api_rest_url').'/get_session_img',['tkn'=>$temp]));
			$_SESSION["permisions"] = base64_encode( Http::post(config('app.api_rest_url').'/get_session_permission',['tkn'=>$temp]) );
			
			return redirect()->route('index')->with(["success" => "Inició Sessión"]); 
		}
	}
	public function logout(request $data) {
		$temp= Http::post(config('app.api_rest_url').'/logout',[
			'id_user'=>  base64_decode($_SESSION["id_user"]),
			'aut_token'=>  base64_decode($_SESSION["tkn"])
		]);
		if ( $temp = 'Sessión Closed' ) {   
			session_destroy();
			//session()->flush();
			return redirect()->to(route('index'));
		}
		else {
			return redirect()->back()->withErrors('Error Al Cerrar Sessión');
		}
	}
	private function get_user_data() {
		$_SESSION["username"]=$temp;
	}
	public function show_login() {
		return view('index');
	}
}
