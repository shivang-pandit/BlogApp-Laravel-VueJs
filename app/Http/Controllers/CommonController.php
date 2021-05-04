<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller
{
    public function upload(Request $request)
    {
        $validatorObj = Validator::make($request->toArray(), [
            'file' => 'required|mimes:jpeg,png,jpg' ,
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
        $folder_path = 'uploads';
        if($request->folder_path){
            $folder_path = $request->folder_path;
        }        
        $fileName = time().'.'.$request->file->extension();        
        $filePath = $request->file->move(public_path($folder_path),$fileName);
        return $fileName;        
    }

    public function deleteFile(Request $request)
    {
        $validatorObj = Validator::make($request->toArray(), [
            'file_path' => 'required' ,
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
        
        $file = public_path().$request->file_path;        
        if(file_exists($file)) {
            @unlink($file);
        }
        return 'success';
    }

    public function uploadEditorImage(Request $request)
    {
        $validatorObj = Validator::make($request->toArray(), [
            'image' => 'required|mimes:jpeg,png,jpg' ,
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
        
        $fileName = time().'.'.$request->image->extension();        
        $filePath = $request->image->move(public_path('uploads'),$fileName);
        return '/uploads/'.$fileName;        
    }
}
