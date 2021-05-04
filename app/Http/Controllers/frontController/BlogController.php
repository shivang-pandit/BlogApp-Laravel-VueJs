<?php

namespace App\Http\Controllers\FrontController;

use App\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{       
    public function getTop(Request $request)
    {        
        if(isset($request->blog_id)) {
            return Blog::where('id','<>',$request->blog_id)->orderBy('id','desc')->with(['categories', 'user'])->limit(6)->get();    
        }
        //return Blog::orderBy('id','desc')->with(['categories','user'])->limit(6)->get('id','title','image','post','description','user_id','full_name');
        return Blog::orderBy('id','desc')->with(['categories', 'user'])->limit(6)->get();
    }

    public function blogDetail($id)
    {
        return Blog::where('id',$id)->with(['categories', 'user', 'tags'])->first();
    }

    public function getAll(Request $request)
    {        
        // $blog = Blog::orderBy('id','desc')->with(['categories', 'user', 'tags'])->orderBy('id','desc')->paginate($request->total);         
        $blog = Blog::with(['categories', 'user', 'tags'])->whereHas('categories', function ($query) use ($request) {
            if ($request->category) {
                $query->where('category_id', $request->category);
            }
        });
        
        $blog->whereHas('tags', function ($query) use ($request) {
            if ($request->tag_id) {
                $query->where('tag_id', $request->tag_id);
            }
        });

        if ($request->user_id) {
            $blog->where('user_id', $request->user_id);
        }   
        
        $blog = $blog->orderBy('id','desc')->paginate($request->total);

        return $blog;
    }
}
