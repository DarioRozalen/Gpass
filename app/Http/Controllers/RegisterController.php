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

        if($this->checkPassword($password))
        {
            return $this->error(400,'La contraseña tiene que ser superior a 8 carecteres');
        }
        if($this->checkEmail($email))
        {
            return $this->error(400,'El email no es valido');
        }
        if($this->checkUserExist($email))
        {
            return $this->error(400,'El usuario ya existe');
        }
        
        if (!empty($user) && !empty($email) && !empty($password))
        {
            $users = new User();
            $users->name = $user;
            $users->password = $password;
            $users->email = $email;
            $users->save();
            return $this->success('Usuario registrado',"");                 
        }
        else
        {
            return $this->error(400,'No puede haber campos vacios');
        }    
    }
    public function checkPassword($password)
    {
        if(strlen($password) < 8)
        {
            return true;
        }
        return false;
    }
    public function checkEmail($email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return true;
        }
        return false;
    }
    public function checkUserExist($email)
    {
        $userData = User::where('email',$email)->first();
        if(!is_null($userData))
        {
            return true;
        }
        return false;
    }
}

// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
//             {
//                 return $this->error(401, 'No puede haber espacios en los campos');
//             }