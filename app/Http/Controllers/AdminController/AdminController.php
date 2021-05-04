<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{   
    public function index(Request $request)
    {   
        $user = [];            
        if (strpos($request->path(), 'admin') !== false) {            
            $isAdmin = Auth::check();
            if (!$isAdmin && $request->path() != 'admin/login') {
                return redirect('admin/login');
            }

            if (!$isAdmin && $request->path() == 'admin/login') {
                return view('welcome');
            }
                        
            $user = Auth::user();
            if ($isAdmin && $user->role->is_admin == 0) {
                return redirect('admin/login');
            }

            if ($request->path() == 'admin/login') {
                return redirect('/admin');
            }
        }
        //return view('notFound');

        return $this->checkPermission($user, $request);
        //return view('welcome');
    } 

    public function checkPermission($user, $request)
    {        
        // echo "<pre>";
         //print_r($permissions);
        // exit;        
        if(strpos($request->path(), 'admin') !== false ){
            $permissions = json_decode($user->role->permission);        
            if ($permissions) {
                $hasPermission = false;
                foreach ($permissions as $permission) {
                    //echo $permission->permission_route." == ".$request->path()."<br>";                  
                    if ($permission->permission_route == "/".$request->path()) {
                        if ($permission->read) {                        
                            $hasPermission = true;
                            break;
                        }
                    }
                }
                // echo $hasPermission;
                if ($hasPermission) {
                    return view('welcome');
                }
            }
        } else {
            return view('welcome');
        }
        
        return view('notFound');
    }

    public function create(Request $request)
    {
        $validatorObj = Validator::make($request->toArray(), [
            'fullName' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roleId' => 'required',
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
        $password = bcrypt($request->password);
        return User::create([
            'full_name'=> $request->fullName,
            'email'=> $request->email,
            'password'=> $password,
            'role_id'=> $request->roleId,
            'is_activated'=> 1,            
        ])->load('role');
    }

    public function update(Request $request)
    {
        $validatorObj = Validator::make($request->toArray(), [
            'id' => 'required|exists:users,id',
            'fullName' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->id,
            'password' => 'min:6',
            'roleId' => 'required',
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
        
        $admin = User::find($request->id);
        
        if(!$admin) {
            return response()->json([
                'error'=> 'Admin not found!'
            ],422);    
        }

        // $isExistEmail= User::where('id','!=' ,$request->id)
        //                 ->where('email',$request->email)->first();

        // if($isExistEmail) {
        //     return response()->json([
        //         'error'=> 'Email is already in use.Please try with another email!'
        //     ],422);  
        // }
        $data = [
            'full_name'=> $request->fullName,
            'email'=> $request->email,            
            'role_id'=> $request->roleId,
            'is_activated'=> 1,    
        ];

        if($request->password) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }

        $admin->update($data);

        return response()->json($admin->load('role'));
    }

    public function delete($id)
    {        
        $admin = User::find($id);
        
        if(!$admin) {
            return response()->json([
                'error'=> 'Admin not found!'
            ],422);    
        }

        $admin->delete();
        
        return response()->json([
            'msg' => 'Admin successfully deleted!'
        ]);
    }

    public function getAll()
    {
        return User::with('role')->orderBy('id','desc')->get();
    }

    public function login(Request $request)
    {
        $validatorObj = Validator::make($request->toArray(), [            
            'email' => 'required|email',
            'password' => 'required|min:6'
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

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user= Auth::user();
            if($user->role->is_admin == 0) {
                Auth::logout();
                return response()->json([
                    'error'=> 'Incorrect login details!'
                ],422);        
            }

            return response()->json([
                'msg' => 'You are logged in',
                'user' => $user,
            ]);
        } else {            
            return response()->json([
                'error'=> 'Incorrect login details!'
            ],422);    
        }
    }

    public function logout()
    {        
        if(Auth::check()) {
            Auth::logout();
        }

        return redirect('/admin/login');
    }
}
