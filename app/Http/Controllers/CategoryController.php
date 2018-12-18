<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use \Firebase\JWT\JWT;

class CategoryController extends Controller
{
    public function index()
    {
        
    }

    
    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        $headers = getallheaders();
        $token = $headers['Authorization'];
        $key = '^fg?4xtyDXcjb5c__aXWb$J?2wn#9jBB4Wbc68d4YUDsB*ZuQ$p4b!rj';
        $userData = JWT::decode($token, $key, array('HS256'));//Tipo de encriptacion que usamos

        if ($this->checkLogin($userData->email , $userData->password)) 
        { 
            $category = new Category();
            $category->name = $request->categoryName;
            $category->id_user = $userData->id;
            $category->save();

            return $this->success('Categoria creada', $request->categoryName);
        }
        else
        {
            return $this->error(401, "No tienes permisos");
        }  
    }

    
    public function show()
    {
        
    }

    
    public function edit(Category $category)
    {
        
    }

    
    public function update(Request $request, Category $category)
    {
        
    }

    
    public function destroy(Category $category)
    {
        
    }
}
