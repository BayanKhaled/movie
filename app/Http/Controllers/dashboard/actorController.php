<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actors;
use App\Models\photos;

class actorController extends Controller
{
    //
    public function show($id)
    {
        //

        $actor = Actors::with('movies')->find($id);
        $actorCount = $actor->movies->count();
        $icon = photos::where('path', $actor->icon_path)->get();
        $photos = photos::where('actor_id', $actor->id)->get();
        return view('dashboard.actor.single', compact('actor', 'icon', 'photos', 'actorCount'));
        
    }

    public function list()
    {
        $actors = Actors::get();
        $actorCount = $actors->count();
        return view('dashboard.actor.actorlist', compact('actors', 'actorCount'));
    }

    public function search(Request $request)
    {
        // $actor = Actors::get();
        $data = $this->validate($request, [
            'nameSearch' => 'required|max:255|string',
        ]);

        $actor = Actors::where('name', 'LIKE', $data['nameSearch'])->get();
        // $actor = Actors::whereRaw('match (name) against (? in boolean mode)', [$data['nameSearch']]);
        dd($actor);
        return view('dashboard.actor.actorlist', compact('actor'));
    }
}
