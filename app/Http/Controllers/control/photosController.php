<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\photos;
use DB;
use Illuminate\Support\Facades\Storage;


class photosController extends Controller
{
    //

    
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    public function index(Request $request)
    {
        //
        $photos = photos::get();
        return view('control.photos.index', compact('photos'));
    }


    public function save(Request $request)
    {
        // if($request->hasFile('photos')){
        //     // dd($request->file('photos'));
        //     $files = $request->file('photos');
        //     foreach ($files as $file) {
        //         $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
        //         $file->move('./uploads/publicPhotos/', $fileName);
        //         $path = '/uploads/publicPhotos/'. $fileName;
        //         photos::create(['path'=>$path]);
        //     }
        // }
        // $fileName = $request->file('photos')[0]->getClientOriginalName();
        // $request->file('photos')[0]->store('avatars' );
        Storage::putFile('avatars', $request->file('photos')[0]);


        dd($request->file('photos')[0]->getClientOriginalName());
        $path = $request->file('avatar')->store('avatars');


        if($request->hasFile('photos')){
            $files = $request->file('photos');
            foreach ($files as $file) {
                // $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                // $request->file($file)->storeAs('./uploads/publicPhotos', $fileName);  
                // $request->file('avatar')->store('avatars/'.$request->user()->id, 's3');
                // Storage::putFileAs('avatars', $request->file('avatar'), $request->user()->id);
                // Storage::putFileAs('./uploads/publicPhotos' . $fileName, $file, 'avatars'); 
                $file->store('./uploads/publicPhotos/'. $fileName, );
                // $path = '/uploads/publicPhotos/'. $fileName;   
                // photos::create(['path'=>$path]);
            }
        } 

        return redirect()->back();
    }


    

    public function store(Request $request)
    {


    	$data = $this->validate($request, [
            'id' => 'integer',
        ]);


          
        if($request->hasFile('photos')){
            $files = $request->file('photos');
            foreach ($files as $file) {
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('./uploads/actors/'. $data['id'] .'/', $fileName);
                $path = '/uploads/actors/'. $data['id'] .'/' . $fileName;
                photos::create(['path'=>$path, 'actor_id' => $data['id']]);
            }
        }
        return redirect()->back();

    }

    public function destroy($id)
    {
        // photos::find($id)->delete($id);
        DB::table('photos')->where('id', $id)->delete();
        // photos::find($id)->destroy();
        return redirect()->back();
    }


    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        
        if (is_array($ids)) 
        {
            photos::destroy($ids);
        }
        else
        {
            $pars = explode(",",$ids);
            foreach ($pars as $par){
                photos::destroy($par);
            }
        }
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
