<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\Keywords;
use Illuminate\Http\Request;
use App\DataTables\KeywordsDatatable;


class KeywordsController extends Controller
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

    
    public function index(KeywordsDatatable $dataTable)
    {
        //
        return $dataTable->render('control.keywords.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('control.keywords.create');
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
        $data = $this->validate($request, [
            'name' => 'required|string|max:255|unique:keywords,name',
        ]);

        $Genre = Keywords::create([
            'name' => $data['name'],
        ]);
        return redirect('/control/keywords');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $keyword = Keywords::find($id);
        return view('control.keywords.edit', compact('keyword'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $this->validate($request, [
            'name' => 'required|string|max:255|unique:keywords,name,' .$id,
        ]);
        $tag = Keywords::where('id', $id)
        ->update([
            'name' => $data['name'],
        ]);
        return redirect('/control/keywords');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Keywords::destroy($id);
        return redirect('/control/keywords');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        
        
        if (is_array($ids)) 
        {
            Tags::destroy($ids);
        }
        else
        {
            $pars = explode(",",$ids);
            foreach ($pars as $par){
                Tags::destroy($par);
            }
        }
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
