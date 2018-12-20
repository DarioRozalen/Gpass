<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use \Firebase\JWT\JWT;

class CategoryController extends Controller
{
    public function index()
    {
        if ($this->checkLogin()) 
        { 
            $userData = $this->getUserData();
            $categoriesSave = $this->allCategoriesOneUser($userData->id);
            return $this->success('Todas las categorias creadas por el usuario', $categoriesSave);
        }
        else
        {
            return $this->error(400, "No tienes permisos");
        }    
    }

    
    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        if ($this->checkLogin()) 
        { 
            if(!$request->filled("categoryName"))
            {
                return $this->error(400, "No puede estar vacio el nombre de la categoria");
            }
            $userData = $this->getUserData();
            $this->isUsedCategoryName($request->categoryName,$userData->id);
            $category = new Category();
            $category->name = $request->categoryName;
            $category->id_user = $userData->id;
            $category->save();
            return $this->success('Categoria creada', $request->categoryName);
        }
        else
        {
            return $this->error(400, "No tienes permisos");
        }    
    }

    
    public function show($categoryName)
    {
        if ($this->checkLogin()) 
        {
            if(is_null($categoryName))
            {
                return $this->error(400, "El nombre de la categoria tiene que estar rellenado");
            }
            $userData = $this->getUserData();
            $categorySave = $this->oneCategoryOfUser($userData->id,$categoryName);
            if (is_null($categorySave))
            {
                return $this->error(400, "La categoria no existe");
            }
            return $this->success('La categoria selecionada', $categorySave);
        }
        else
        {
            return $this->error(400, "No tienes permisos");
        } 
    }

    
    public function edit(Category $category)
    {
        
    }

    
    public function update(Request $request, $category)
    {
        if ($this->checkLogin()) 
        { 
            if(is_null($category))
            {
                return $this->error(400, "El nombre de la categoria tiene que estar rellenado");
            }
            if(!$request->filled("newCategoryName"))
            {
                return $this->error(400, "El nombre de la nueva categoria tiene que estar rellenado");
            }
            if(is_null($category))
            {
                return $this->error(400, "El nombre de la categoria que quieres cambiar debe estar rellenado");
            }
            $newName = $request->newCategoryName;
            $categoryName = $category;
            $userData = $this->getUserData();
            $this->isUsedCategoryName($userData->id,$newName);
            $categorySave = $this->oneCategoryOfUser($userData->id,$category);
            $categorySave->name = $newName;
            $categorySave->save();
            return $this->success('La categoria a sido actualizada', $categorySave);
        }
        else
        {
            return $this->error(400, "No tienes permisos");
        }
    }

    
    public function destroy($category)
    {
        if ($this->checkLogin()) 
        { 
            $categoryName = $category;
            $categorySave = Category::where('name',$categoryName)->first();
            $categorySave->delete();
            return $this->success('Ha sido borrada la categoria', "");
        }
        else
        {
            return $this->error(400, "No tienes permisos");
        }       
    }

    private function allCategoriesOneUser($id)
    {
        return Category::where('id_user', $id)->get();
    }

    private function isUsedCategoryName($categoryName,$id_user)
    {
        $categoriesSave = $this->allCategoriesOneUser($id_user);
        foreach ($categoriesSave as $Category => $CategorySave) 
        {
            if($CategorySave->name == $categoryName)
            {
                return true;
            }
            
            return false;      
        }
    }

    private function oneCategoryOfUser($id,$categoryname)
    {
        $categoriesSave = $this->allCategoriesOneUser($id);
        foreach ($categoriesSave as $categories => $categorie)
        {
            if($categoryname == $categorie->name)
            {
                return $categorie;
            }
        }
        return null;
    }
}