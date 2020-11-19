<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\Actors;
use App\Models\photos;
use Illuminate\Http\Request;
use App\DataTables\ActorsDatatable;


class ActorsController extends Controller
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

    
    public function index(ActorsDatatable $dataTable)
    {
        //
        return $dataTable->render('control.actors.index');
    }

    public function delete()
    {
        //
        return view('control.actors.delete');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('control.actors.create');
        // return view('test');
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
        if (request()->ajax()) {
            return $editor->process(request());
        }

        $data = $this->validate($request, [
            'name' => 'required|unique:actors|max:255',
            'description' => '',
            'role' => 'max:255',
            'country' => 'max:255',
            'DateOfBirth' => 'date ',
            'icon_path' => 'mimes:png,gif,jpeg',
            'photos' => 'array',
        ]);

        // dd($data);

        $actor = Actors::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'role' => $data['role'],
            'country' => $data['country'],
            'DateOfBirth' => $data['DateOfBirth'],
        ]);

        if($request->hasFile('icon_path')){
            $file = request()->file('icon_path');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('./uploads/actors/icon/', $fileName);
            $path = '/uploads/actors/icon/'.$fileName;
            photos::create(['path'=>$path]);
            $actor->icon_path = $path;
        }

        $actor->save();



        if($request->hasFile('photos')){
            // dd($request->file('photos'));
            $files = $request->file('photos');
            foreach ($files as $file) {
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('./uploads/actors/'. $actor->id .'/', $fileName);
                $path = '/uploads/actors/'. $actor->id .'/' . $fileName;
                photos::create(['path'=>$path, 'actor_id' => $actor->id]);
            }
        }
        return redirect('/control/actors');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Actors  $actors
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Actors  $actors
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $actor = Actors::find($id);
        $icon = photos::where('path', $actor->icon_path)->get();
        $photos = photos::where('actor_id', $actor->id)->get();
        // dd($photos);
        return view('control.actors.edit', compact('actor', 'photos', 'icon',));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Actors  $actors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $this->validate($request, [
            'name' => 'required|unique:actors,name,' .$id,
            'description' => '',
            'role' => 'max:255',
            'country' => 'max:255',
            'DateOfBirth' => 'date ',
            'icon_path' => 'mimes:png,gif,jpeg',
            'photos' => 'array',
        ]);

        // dd($data);

        $actor = Actors::where('id', $id)
        ->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'role' => $data['role'],
            'country' => $data['country'],
            'DateOfBirth' => $data['DateOfBirth'],
        ]);

        if($request->hasFile('icon_path')){
            $file = request()->file('icon_path');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('./uploads/actors/icon/', $fileName);
            $path = '/uploads/actors/icon/'.$fileName;
            photos::create(['path'=>$path]);
            $actor = Actors::find($id);
            $actor->icon_path = $path;
            $actor->save();
        }


        if($request->hasFile('photos')){
            // dd($request->file('photos'));
            $files = $request->file('photos');
            foreach ($files as $file) {
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('./uploads/actors/'. $id .'/', $fileName);
                $path = '/uploads/actors/'. $id .'/' . $fileName;
                photos::create(['path'=>$path, 'actor_id' => $id]);
            }
        }


        


        return redirect('/control/actors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Actors  $actors
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_array($id)) 
        {
            Actors::destroy($id);
        }
        else
        {
            Actors::findOrFail($id)->delete();
        }
        return redirect('/control/actors');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        
        
        if (is_array($ids)) 
        {
            Actors::destroy($ids);
        }
        else
        {
            $pars = explode(",",$ids);
            foreach ($pars as $par){
                Actors::destroy($par);
            }
        }
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
