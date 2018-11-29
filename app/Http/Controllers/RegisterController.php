<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    protected function register(Request $req)
    {
    	$user = $_POST['user'];
    	$email = $_POST['email'];
        $password = $_POST['password'];

        if (!empty($user) && !empty($email) && !empty($password))
        {
            $users = new User();
            $users->name = $user;
            $users->password = $password;
            $users->email = $email;

            $users->save();


        	return response("Register Complete");
        }
        
        else
        {
        	return response("Los datos no son correctos");
        }
    }
}
