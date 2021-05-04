<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{       
    public function index(Request $request)
    {
        return Inquiry::orderBy('id','desc')->paginate($request->total);
    }
}
