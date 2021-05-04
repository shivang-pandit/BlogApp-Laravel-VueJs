<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{    
    public function create(Request $request)
    {
        \Log::info('RoleController@create');
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

        return Role::create([
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
        
        $role = Role::find($request->id);
        
        if(!$role) {
            return response()->json([
                'error'=> 'Role not found!'
            ],422);    
        }

        $role->update([
            'name'=> $request->name
        ]);

        return response()->json($role);
    }

    public function delete($id)
    {        
        $role = Role::find($id);
        
        if(!$role) {
            return response()->json([
                'error'=> 'Role not found!'
            ],422);    
        }

        $role->delete();
        
        return response()->json([
            'msg' => 'Role successfully deleted!'
        ]);
    }

    public function getAll()
    {
        return Role::orderBy('id','desc')->get();
    }

    public function assignPermission(Request $request)
    {
        \Log::info('RoleController@assignPermission');
        $validatorObj = Validator::make($request->toArray(), [
            'permission' => 'required',
            'role_id' => 'required'
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

        $role = Role::find($request->role_id);

        if(!$role) {
            return response()->json([
                'error'=> 'Role not Found!'
            ],422);  
        }
        
        $role->update([
            'permission'=> $request->permission
        ]);

        return response()->json($role);
    }

    public function show($id)
    {
        $role =  Role::find($id);
        
        if(!$role) {
            return response()->json([
                'error'=> 'Role not Found!'
            ],422);  
        }

        return response()->json($role);
    }
}
