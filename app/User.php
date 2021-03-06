<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    //protected $table = 'users';
    //protected $fillable = ['name', 'email', 'password', 'id_rol'];

    public function category()
    {
        return $this->hasMany('App\Category');
    }

    public function rol()
    {
        return $this->belongsTo('App\Rol');
    }

    public function password()
    {
        return $this->hasMany('App\Password');
    }
}
