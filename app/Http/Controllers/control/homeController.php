<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class homeController extends Controller
{
    //


    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    public function index()
    {

        return view('control.index');
        
    }
}
