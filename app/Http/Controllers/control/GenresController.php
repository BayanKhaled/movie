<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\Genres;
use Illuminate\Http\Request;
use App\DataTables\GenresDatatable;

class GenresController extends Controller
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

    
    public function index(GenresDatatable $dataTable)
    {
        //
        return $dataTable->render('control.genres.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('control.genres.create');
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
            'name' => 'required|unique:genres|max:255',
        ]);

        $Genre = Genres::create([
            'name' => $data['name'],
        ]);
        return redirect('/control/genres');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genres  $genres
     * @return \Illuminate\Http\Response
     */
    public function show(Genres $genres)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Genres  $genres
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $genre = Genres::find($id);
        return view('control.genres.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genres  $genres
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $this->validate($request, [
           'name' => 'required|unique:genres,name,' .$id,
        ]);
        $actor = Genres::where('id', $id)
        ->update([
            'name' => $data['name'],
        ]);
        return redirect('/control/genres');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genres  $genres
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Genres::destroy($id);
        return redirect('/control/genres');
     }


    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        
        
        if (is_array($ids)) 
        {
            Genres::destroy($ids);
        }
        else
        {
            $pars = explode(",",$ids);
            foreach ($pars as $par){
                Genres::destroy($par);
            }
        }
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
