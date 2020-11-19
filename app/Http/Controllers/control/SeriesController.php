<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\Series;
use Illuminate\Http\Request;
use App\DataTables\SeriesDatatable;


class SeriesController extends Controller
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

    
    public function index(SeriesDatatable $dataTable)
    {
        //
        return $dataTable->render('control.series.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         return view('control.series.create');
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
            'title' => 'required|unique:series|max:255',
            'description' => 'required',
            'release_date' => 'required',
            'poster_path' => 'sometimes',
        ]);

        $series = Series::create($data);

        $series = \App\models\Series::find($series->id);
        if ($request->genres){
            foreach ($request->genres as $genre) {
                $genre = \App\models\Genres::find($genre);
                $series->genres()->attach($genre);
            }
        }

        if ($request->tags){
            foreach ($request->tags as $tag) {
                $tag = \App\models\Tags::find($tag);
                $series->tags()->attach($tag);
            }
        }
        

        return redirect('/control/series');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function show(Series $series)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $series = Series::find($id);

        $genres = array();
        foreach ($series->genres as $genre) {
            array_push($genres,$genre->pivot->genre_id);
        }

        $tags = array();
        foreach ($series->tags as $tag) {
            array_push($tags,$tag->pivot->tag_id);
        }

        return view('control.series.edit', compact('series', 'genres', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $this->validate($request, [
           'title' => 'required|unique:series,title,' .$id,
           'description' => 'required',
           'release_date' => 'required',
           'poster_path' => 'required',
        ]);
        $actor = Series::where('id', $id)
        ->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'release_date' => $data['release_date'],
            'poster_path' => $data['poster_path'],
        ]);

        $Series = \App\models\Series::find($id);
        if ($request->genres){
            $Series->genres()->detach();
            foreach ($request->genres as $genre) {
                $genre = \App\models\Genres::find($genre);
                $Series->genres()->attach($genre);
            }
        }elseif (!$request->genres){
            $Series->genres()->detach();
        }

        if ($request->tags) {
            $Series->tags()->detach();
            foreach ($request->tags as $tag) {
                $tag = \App\models\Tags::find($tag);
                $Series->tags()->attach($tag);
            }
        }elseif (!$request->tags){
            $Series->tags()->detach();
        }

        return redirect('/control/series');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Series::destroy($id);
        return redirect('/control/series');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        
        if (is_array($ids)) 
        {
            Series::destroy($ids);
        }
        else
        {
            $pars = explode(",",$ids);
            foreach ($pars as $par){
                Series::destroy($par);
            }
        }
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
    
}
