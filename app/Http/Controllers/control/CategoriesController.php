<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\DataTables\CategoriesDatatable;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    
    public function index(CategoriesDatatable $dataTable)
    {
        //categories
        // return Categories::with('parents')->get();
        return $dataTable->render('control.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categorie = Categories::pluck('name', 'id');
        // return $ar;
        // array_unshift_assoc($ar, "", "");
        $cate =  Categories::select('name', 'id')->get();
        return view('control.categories.create', compact('categorie', 'cate'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $data = $this->validate($request, [
            'name' => 'required|unique:categories|max:255',
            'parent_id' => 'sometimes',
        ]);

        $categorie = Categories::create($data);
        return redirect('/control/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $categorie = Categories::find($id);
        $cate =  Categories::select('name', 'id')->get();
        return view('control.categories.edit', compact('categorie', 'cate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $data = $this->validate($request, [
           'name' => 'required|unique:categories,name,' .$id,
           'parent_id' => 'sometimes:integer',
        ]);
        $categorie = Categories::where('id', $id)
        ->update($data);
        return redirect('/control/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Categories::destroy($id);
        return redirect('/control/categories');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        
        
        if (is_array($ids)) 
        {
            Categories::destroy($ids);
        }
        else
        {
            $pars = explode(",",$ids);
            foreach ($pars as $par){
                Categories::destroy($par);
            }
        }
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
