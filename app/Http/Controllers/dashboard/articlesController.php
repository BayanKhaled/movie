<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Articles;

class articlesController extends Controller
{
    //
    

    public function show($id)
    {
        //

        $articles = Articles::find($id);
        // return $Articles;
        return view('dashboard.blog.blog', compact('articles'));
        
    }
}
