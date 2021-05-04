<?php

namespace App\Http\Controllers\AdminController;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{    
    public function create(Request $request)
    {
        $validatorObj = Validator::make($request->toArray(), [
            'name' => 'required',
            'image' => 'required'
        ]);
        
        $errorsArr = array();
        if ($validatorObj->fails()) {
            $errorsArr = array_merge($errorsArr, $validatorObj->messages()->all(':message'));
        }
        if (count($errorsArr) > 0) {                                    
            return response()->json([
                'error'=> implode("", $errorsArr)
            ],422);    
        }

        return Category::create([
            'name'=> $request->name,
            'image'=> $request->image
        ]);
    }

    public function update(Request $request)
    {
        $validatorObj = Validator::make($request->toArray(), [
            'id' => 'required',
            'name' => 'required',
            'image' => 'required'
        ]);
        
        $errorsArr = array();
        if ($validatorObj->fails()) {
            $errorsArr = array_merge($errorsArr, $validatorObj->messages()->all(':message'));
        }
        if (count($errorsArr) > 0) {                                    
            return response()->json([
                'error'=> implode("", $errorsArr)
            ],422);    
        }
        
        $category = Category::find($request->id);
        
        if(!$category) {
            return response()->json([
                'error'=> 'Category not found!'
            ],422);    
        }
        
        if ($category->image != $request->image) {
            $file = public_path().$category->image;
            if (file_exists($file)) {
                @unlink($file);
            }
        }

        $category->update([
            'name'=> $request->name,
            'image'=> $request->image
        ]);

        return response()->json($category);
    }

    public function delete($id)
    {        
        $category = Category::find($id);
        
        if(!$category) {
            return response()->json([
                'error'=> 'Tag not found!'
            ],422);    
        }
        
        $file = public_path().$category->image;        
        if(file_exists($file)) {
            @unlink($file);
        }

        $category->delete();
        
        return response()->json([
            'msg' => 'Category successfully deleted!'
        ]);
    }

    public function getAll()
    {
        return Category::orderBy('id','desc')->get();
    }
}
