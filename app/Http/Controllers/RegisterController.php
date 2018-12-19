<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use App\User;

class RegisterController extends Controller
{

    public function register (Request $request)
    {
        if (!isset($_POST['user']) or !isset($_POST['email']) or !isset($_POST['password'])) 
        {
            return $this->error(1, 'No puede haber campos vacíos');
        }

        $user = $_POST['user'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!empty($user) && !empty($email) && !empty($password))
        {
            if(strlen($password) >= 8)
            {
                try
                {
                    $users = new User();
                    $users->name = $user;
                    $users->password = $password;
                    $users->email = $email;

                    $users->save();
                }
                catch(Exception $e)
                {
                    return $this->error(2, $e->getMessage());
                }

                return $this->error(200, 'Usuario registrado');
            }
            else
            {
                return $this->error(401, 'The password must be bigger than 8 characters');
            }
        }
        else
        {
            return $this->error(401, 'No puede haber campos vacios');
        }
    }  
}

// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
//             {
//                 return $this->error(401, 'No puede haber espacios en los campos');
//             }