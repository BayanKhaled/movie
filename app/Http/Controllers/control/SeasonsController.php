<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\Seasons;
use Illuminate\Http\Request;
use App\DataTables\SeasonsDatatable;


class SeasonsController extends Controller
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

    
    public function index(SeasonsDatatable $dataTable)
    {
        //
        return $dataTable->render('control.seasons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('control.seasons.create');
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
            'season_number' => 'required|integer|unique:seasons|max:255',
            'summary' => 'required',
            'duration' => 'required|integer',
            'series_id' => 'required|integer',
            'poster_path' => 'sometimes',
        ]);
        // dd($data);

        $season = Seasons::create($data);

        if ($request->actors){
            foreach ($request->actors as $actor) {
                $actor = \App\models\Actors::find($actor);
                $season->actors()->attach($actor);
            }
        }

        return redirect('/control/seasons');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seasons  $seasons
     * @return \Illuminate\Http\Response
     */
    public function show(Seasons $seasons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seasons  $seasons
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $season = \App\Models\Seasons::with('actors')->find($id);
        $actors = array();
        foreach ($season->actors as $actor) {
            array_push($actors,$actor->pivot->actor_id);
        }

        $seasons = Seasons::find($id);
        return view('control.seasons.edit', compact('seasons', 'actors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seasons  $seasons
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $this->validate($request, [
            'season_number' => 'required|integer|unique:seasons,season_number,' .$id,
            'summary' => 'required',
            'duration' => 'required|integer',
            'series_id' => 'required|integer',
            'poster_path' => 'sometimes',
        ]);
        $season = Seasons::where('id', $id)
        ->update([
            'summary' => $data['summary'],
            'season_number' => $data['season_number'],
            'duration' => $data['duration'],
            'series_id' => $data['series_id'],
            'poster_path' => $data['poster_path'],
        ]);

        $season = \App\models\Seasons::find($id);
        if ($request->actors){
            $season->actors()->detach();
            foreach ($request->actors as $actor) {
                $actor = \App\models\Actors::find($actor);
                $season->actors()->attach($actor);
            }
        }
        
        return redirect('/control/seasons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seasons  $seasons
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Seasons::destroy($id);
        return redirect('/control/seasons');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        
        if (is_array($ids)) 
        {
            Seasons::destroy($ids);
        }
        else
        {
            $pars = explode(",",$ids);
            foreach ($pars as $par){
                Seasons::destroy($par);
            }
        }
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
