<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use App\User;//Para poder acceder al odelo de User

class LoginController extends Controller
{
    protected function login(Request $req)
    {
        if (!isset($_POST['email']) or !isset($_POST['password'])) 
        {
            return $this->error(1, 'No puede haber campos vacíos');
        }

    	$email = $_POST['email'];
        $password = $_POST['password'];
        $key = $this->key;

        if (self::checkLogin($email, $password))
        {
            $userSave = User::where('email', $email)->first();

            $array = $arrayName = array
            (
                'id' => $userSave->id,
                'email' => $email,
                'password' => $password,
                'name' => $userSave->name
            );

            $jwt = JWT::encode($array, $key);

            return response($jwt)->header('Access-Control-Allow-Origin', '*');
        }
        else
        {
            return response("Los datos no son correctos", 400)->header('Access-Control-Allow-Origin', '*');
        }
    }
}