<?php

namespace App\Http\Controllers\FrontController;

use App\Http\Controllers\Controller;
use App\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InquiryController extends Controller
{       
    public function create(Request $request)
    {
        $validatorObj = Validator::make($request->toArray(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'message' => 'required|min:20',
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

        return Inquiry::create([
            'name'=> $request->name,
            'email'=> $request->email,            
            'message'=> $request->message,            
        ]);
    }
}
