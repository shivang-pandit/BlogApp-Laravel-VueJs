<?php

namespace App\Http\Controllers\FrontController;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{       
    public function getAll()
    {
        return Category::orderBy('id','desc')->get();
    }
}
