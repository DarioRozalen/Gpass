<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected function login(Request $req)
    {
    	$user = $_POST['user'];
        $user = $_POST['password'];

        if ($user = 'user' && $user = 'password')
        {
        	return response("Login Complete");
        }
        else
        {
        	return response("Los datos no son correctos");
        }
    }
}
