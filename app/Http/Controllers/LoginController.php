<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use App\User;

class LoginController extends Controller
{
    protected function login(Request $req)
    {
    	$email = $_POST['email'];
        $password = $_POST['password'];
        $key = "key";

        if (self::checkLogin($email, $password))
        {
            $array = $arrayName = array
            (
                'email' => $email,
                'password' => $password
            );

            $jwt = JWT::encode($array, $key);

            return response($jwt);
        }
        else
        {
            return response("Los datos no son correctos", 402);

        }
    }

    private function checkLogin($email, $password)
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Song $song)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        //
    }
}