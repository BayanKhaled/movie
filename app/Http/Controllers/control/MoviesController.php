<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\Movies;
use App\Models\photos;
use Illuminate\Http\Request;
use App\DataTables\MoviesDatatable;


class MoviesController extends Controller
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

    
    public function index(MoviesDatatable $dataTable)
    {
        //
        return $dataTable->render('control.movies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $movie = \App\models\Movies::find(1);
        // $genre = \App\models\Genres::find(1);
        // $movie->genres()->attach($genre);
        // return ;

        return view('control.movies.create');
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
            'title' => 'required|unique:movies|max:255',
            'description' => 'required',
            'release_date' => 'sometimes',
            'duration' => 'sometimes|integer',
            'poster_path' => 'mimes:png,gif,jpeg',
            'photos' => 'array',
        ]);

        $movie = Movies::create($data);

        $movie = \App\models\Movies::find($movie->id);
        
        if ($request->actors){
            foreach ($request->actors as $actor) {
                $actor = \App\models\Actors::find($actor);
                $movie->actors()->attach($actor);
            }
        }
        
        if ($request->genres){
            foreach ($request->genres as $genre) {
                $genre = \App\models\Genres::find($genre);
                $movie->genres()->attach($genre);
            }
        }
        
        if ($request->tags){
            foreach ($request->tags as $tag) {
                $tag = \App\models\Tags::find($tag);
                $movie->tags()->attach($tag);
            }
        }

        if($request->hasFile('poster_path')){
            $file = request()->file('poster_path');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('./uploads/movie/icon/', $fileName);
            $path = '/uploads/movie/icon/'.$fileName;
            photos::create(['path'=>$path]);
            $movie->poster_path = $path;
        }

        $movie->save();
        

        if($request->hasFile('photos')){
            // dd($request->file('photos'));
            $files = $request->file('photos');
            foreach ($files as $file) {
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('./uploads/movie/'. $movie->id .'/', $fileName);
                $path = '/uploads/movie/'. $movie->id .'/' . $fileName;
                photos::create(['path'=>$path, 'movie_id' => $movie->id]);
            }
        }
        
        return redirect('/control/movies');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function show(Movies $movies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $movies = Movies::find($id);
        // $tag = \App\models\Tags::find(3);
        // $movie = \App\models\Movies::find(1);
        // $movie->tags()->attach($tag);
        // $movies = \App\Models\Movies::with('actors', 'genres', 'tags')->find($id);
        
        // return $movies->poster_path;

        $actors = array();
        foreach ($movies->actors as $actor) {
            array_push($actors,$actor->pivot->actor_id);
        }

        $genres = array();
        foreach ($movies->genres as $genre) {
            array_push($genres,$genre->pivot->genre_id);
        }

        $tags = array();
        foreach ($movies->tags as $tag) {
            array_push($tags,$tag->pivot->tag_id);
        }

        $icon = photos::where('path', $movies->poster_path)->get();
        $photos = photos::where('actor_id', $movies->id)->get();

        // return $icon = photos::where('path', $movies->poster_path)->get()[0]->id;

        return view('control.movies.edit', compact('movies','actors','genres', 'tags', 'icon', 'photos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        
        $movie = \App\models\Movies::find($id);
        $data = $this->validate($request, [
            'title' => 'required|unique:movies,title,' .$id,
            'description' => 'required',
            'release_date' => 'sometimes',
            'duration' => 'sometimes|integer',
        ]);


        $movie = Movies::where('id', $id)
        ->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'release_date' => $data['release_date'],
            'duration' => $data['duration'],
        ]);

        $movie = \App\models\Movies::find($id);



        if ($request->actors) {
            $movie->actors()->detach();
            foreach ($request->actors as $actor) {
                $actor = \App\models\Actors::find($actor);
                $movie->actors()->attach($actor);
            }
        }elseif (!$request->actors){
            $movie->actors()->detach();
        }

        if ($request->genres) {
            $movie->genres()->detach();
            foreach ($request->genres as $genre) {
                $genre = \App\models\Genres::find($genre);
                $movie->genres()->attach($genre);
            }
        }elseif (!$request->genres){
            $movie->genres()->detach();
        }

        if ($request->tags) {
            $movie->tags()->detach();
            foreach ($request->tags as $tag) {
                $tag = \App\models\Tags::find($tag);
                $movie->tags()->attach($tag);
            }
        }elseif (!$request->tags){
            $movie->tags()->detach();
        }



        if($request->hasFile('poster_path')){
            if (photos::where('path', $movie->poster_path)->get()[0]->id > 0) {
                $icon = photos::where('path', $movie->poster_path)->get()[0]->id;
                photos::destroy($icon);
            }
            $file = request()->file('poster_path');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('./uploads/movie/icon/', $fileName);
            $path = '/uploads/movie/icon/'.$fileName;
            photos::create(['path'=>$path]);
            $movie = Movies::find($id);
            $movie->poster_path = $path;
            $movie->save();
        }

        return redirect('/control/movies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Movies::destroy($id);
        return redirect('/control/movies');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        
        if (is_array($ids)) 
        {
            Movies::destroy($ids);
        }
        else
        {
            $pars = explode(",",$ids);
            foreach ($pars as $par){
                Movies::destroy($par);
            }
        }
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
