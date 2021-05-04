<?php

namespace App\Http\Controllers\AdminController;

use App\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{    
    public function create(Request $request)
    {
        \Log::info('BlogController@create');
        $validatorObj = Validator::make($request->toArray(), [
            'title' => 'required',
            'post' => 'required',
            'description' => 'required',
            'categoryId' => 'required|array',
            'tagId' => 'array'
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
        $data = [
            'title' => $request->title,
            'post' => $request->post,
            'description' => $request->description,
            'meta_description' => $request->metaDescription,
            'user_id' => Auth::user()->id,
            'image' => $request->image,            
        ];

        DB::beginTransaction();
        try {
            $blog =  Blog::create($data);
        
            $blog->categories()->sync($request->categoryId);

            if($request->tagId) {
                $blog->tags()->sync($request->tagId);
            }
            DB::commit();
        } catch (\Exception $e) {
			\Log::info("############### Exception ############### ");
			\Log::error("Show delivery profile", array(
				'context' => [
					$e->getMessage()
					. ' in file '
					. $e->getFile()
					. ' at line '
					. $e->getLine()
					. " full stack "
					. $e->getTraceAsString()
				]
            ));
            DB::rollback();
            return response()->json([
                'error'=> $e->getMessage(),
            ],422); 
		}
        

        return response()->json($blog->load(['categories','tags']));
    }

    public function update(Request $request)
    {
        $validatorObj = Validator::make($request->toArray(), [
            'title' => 'required',
            'post' => 'required',
            'description' => 'required',
            'categoryId' => 'required|array',
            'tagId' => 'array'
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
        DB::beginTransaction();
        try {
            $blog = Blog::find($request->id);
            
            if(!$blog) {
                return response()->json([
                    'error'=> 'Blog not found!'
                ],422);    
            }
            
            if ($blog->image != $request->image) {
                $file = public_path().$blog->image;
                if (file_exists($file)) {
                    @unlink($file);
                }
            }
            
            $blog->update([
                'title' => $request->title,
                'post' => $request->post,
                'description' => $request->description,
                'meta_description' => $request->metaDescription,
                'user_id' => Auth::user()->id,
                'image' => $request->image,
            ]);

            
            $blog->categories()->sync($request->categoryId);

            if($request->tagId) {
                $blog->tags()->sync($request->tagId);
            }
            DB::commit();
        } catch (\Exception $e) {
			\Log::info("############### Exception ############### ");
			\Log::error("Show delivery profile", array(
				'context' => [
					$e->getMessage()
					. ' in file '
					. $e->getFile()
					. ' at line '
					. $e->getLine()
					. " full stack "
					. $e->getTraceAsString()
				]
            ));
            DB::rollback();
            return response()->json([
                'error'=> $e->getMessage(),
            ],422); 
		}

        return response()->json($blog->load(['categories','tags']));
    }

    public function delete($id)
    {        
        $blog = Blog::find($id);
        
        if(!$blog) {
            return response()->json([
                'error'=> 'Blog not found!'
            ],422);    
        }

        $file = public_path().$blog->image;        
        if(file_exists($file)) {
            @unlink($file);
        }

        $blog->categories()->sync([]);        
        $blog->tags()->sync([]);        
        $blog->delete();
        
        return response()->json([
            'msg' => 'Blog successfully deleted!'
        ]);
    }

    public function getAll(Request $request)
    {
        return Blog::with(['categories','tags'])->orderBy('id','desc')->paginate($request->total);
    }
}
