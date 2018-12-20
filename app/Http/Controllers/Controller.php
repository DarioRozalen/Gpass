<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \Firebase\JWT\JWT;
use App\User;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $key = '^fg?4xtyDXcjb5c__aXWb$J?2wn#9jBB4Wbc68d4YUDsB*ZuQ$p4b!rj';

	protected function error($code, $message)
	{
		$json = ['message' => $message];
		$json = json_encode($json);
		return  response($json, $code)->header('Access-Control-Allow-Origin', '*');
	}

	protected function success($message, $data = [])
	{
		$json = ['message' => $message, 'data' => $data];
		$json = json_encode($json);
		return  response($json, 200)->withHeaders([
			'Access-Control-Allow-Origin' => '*',
			'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept, Authorization',
		]);
	}
	protected function getOneHeader($header)
	{
		$headers = getallheaders();
		if(isset($headers[$header]))
		{
			$header = $headers[$header];
			return $header;
		}
		return null;	
	}

	protected function checkLogin()
	{
		$userData = $this->getUserData();
		if(is_null($userData))
		{
			return false;
		}
		$userSave = User::where('email', $userData->email)->first();
		
		if(!is_null($userSave) && $userSave->password == $userData->password)
		{
			return true;
		}
		return false;
	}

	private function getToken()
	{
		$token = $this->getOneHeader("Authorization");
		if(is_null($token))
		{
			return $this->error(400, "Primero logeate");
		}
		return $token;
	}

	protected function getUserData()
	{
		try 
		{
			$userData = JWT::decode($this->getToken(), $this->key, array('HS256'));
			return $userData;      
		} 
		catch (\Exception $e) 
		{
			return null;
		}	
	}
}   