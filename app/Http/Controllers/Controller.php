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
        return  response($json, 200)->header('Access-Control-Allow-Origin', '*');
    }

	// protected function isUserLogged()
 //    {
 //        $headers = getallheaders();

 //        if (!isset($headers['Authorization'])) 
	//     {
	//         return false;
	//     }

	//     $token = $headers['Authorization'];

	//     $key = $this->key;
	    
	//     try 
	//     {
	//         $tokenDecoded = JWT::decode($token, $key, array('HS256')); 
	//         $userLogged = User::where('email', $userSave->email )->first();
	        

	//         if (is_null($userLogged) or $userLogged->password != $tokenDecoded['password'])
	// 	    {
	// 	      	return false;
	// 	    }
	//     } 
	//     catch (Exception $e) 
	//     {	
	//         return false; 
	//     }
	//     return true;
 //    }

    protected function userLogged()
	{
		if ($this->isUserLogged) 
		{
			$userLogged = User::where('email', $userSave->email )->first();
		}
		return $userLogged;
	}

	protected function checkLogin($email, $password)
    {
        $userSave = User::where('email', $email)->first();

        $emailSave = $userSave->email;
        $passwordSave = $userSave->password;

        if($emailSave == $email && $passwordSave == $password)
        {
            return true;
        }
        return false;
    }
}   

