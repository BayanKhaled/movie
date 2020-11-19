<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\Tags;
use Illuminate\Http\Request;
use App\DataTables\TagsDatatable;


class TagsController extends Controller
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

    
    public function index(TagsDatatable $dataTable)
    {
        //
        return $dataTable->render('control.tags.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('control.tags.create');
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
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        $Genre = Tags::create([
            'name' => $data['name'],
        ]);
        return redirect('/control/tags');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $tag = Tags::find($id);
        return view('control.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $this->validate($request, [
            'name' => 'required|string|max:255|unique:tags,name,' .$id,
        ]);
        $tag = Tags::where('id', $id)
        ->update([
            'name' => $data['name'],
        ]);
        return redirect('/control/tags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Tags::destroy($id);
        return redirect('/control/tags');
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
