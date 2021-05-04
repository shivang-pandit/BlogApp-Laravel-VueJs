<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{    
    public function create(Request $request)
    {
        $validatorObj = Validator::make($request->toArray(), [
            'name' => 'required',
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

        return Tag::create([
            'name'=> $request->name
        ]);
    }

    public function update(Request $request)
    {
        $validatorObj = Validator::make($request->toArray(), [
            'name' => 'required',
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
        
        $tag = Tag::find($request->id);
        
        if(!$tag) {
            return response()->json([
                'error'=> 'Tag not found!'
            ],422);    
        }

        $tag->update([
            'name'=> $request->name
        ]);

        return response()->json($tag);
    }

    public function delete($id)
    {        
        $tag = Tag::find($id);
        
        if(!$tag) {
            return response()->json([
                'error'=> 'Tag not found!'
            ],422);    
        }

        $tag->delete();
        
        return response()->json([
            'msg' => 'Tag successfully deleted!'
        ]);
    }

    public function getAll()
    {
        \Log::info("TagController@getAll");
        return Tag::orderBy('id','desc')->get();
    }
}
