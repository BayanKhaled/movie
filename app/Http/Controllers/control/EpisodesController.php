<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\Episodes;
use Illuminate\Http\Request;
use App\DataTables\EpisodesDatatable;


class EpisodesController extends Controller
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

    
    public function index(EpisodesDatatable $dataTable)
    {
        //
        // $books = \App\Models\Episodes::with('season.series')->get();//->pluck('id','season.summary',);
        // return Episodes::with('season')->get();
        return $dataTable->render('control.episodes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('control.episodes.create');
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
            'title' => 'required|unique:episodes|max:255',
            'summary' => 'required',
            'duration' => 'required|integer',
            'season_id' => 'required|integer',
        ]);

        $episode = Episodes::create([
            'title' => $data['title'],
            'summary' => $data['summary'],
            'duration' => $data['duration'],
            'season_id' => $data['season_id'],
        ]);

        return redirect('/control/episodes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Episodes  $episodes
     * @return \Illuminate\Http\Response
     */
    public function show(Episodes $episodes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Episodes  $episodes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $episode = Episodes::with('season.series')->find($id);
        $season = $episode->season->id;
        $series = $episode->season->series->id;

        return view('control.episodes.edit', compact('episode', 'season', 'series'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Episodes  $episodes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request);
        $data = $this->validate($request, [
            'title' => 'required|unique:episodes,title,' .$id,
            'summary' => 'required',
            'duration' => 'required|integer',
            'season_id' => 'required|integer',
        ]);
        $season = Episodes::where('id', $id)
        ->update([
            'title' => $data['title'],
            'summary' => $data['summary'],
            'duration' => $data['duration'],
            'season_id' => $data['season_id'],
        ]);

        return redirect('/control/episodes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Episodes  $episodes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Episodes::destroy($id);
        return redirect('/control/episodes');
    }

    public function getSeasons($id)
    {
        //
        $data = \App\Models\Seasons::get()
        ->makeHidden(['season_number', 'duration', 'series_id', 'poster_path', 'created_at', 'updated_at'])
        ->where("series_id", $id);
        return $data;
        return response()->json($data);

        $data = \App\Models\Seasons::exclude(['season_number', 'duration', 'series_id', 'poster_path'])->toJson();
        return $data->toJson();
        return $data->toArray();
    }

}
