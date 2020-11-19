<?php

namespace App\Http\Controllers\control;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use Illuminate\Http\Request;
use App\DataTables\AdminsDatatable;


class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminsDatatable $dataTable)
    {
        //
        return $dataTable->render('control.admins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('control.admins.create');
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
            'name' => 'required|string',
            'email' => 'required|string|unique:admins,email',
            'password' => 'required|string',
        ]);

        $like = Admins::create($data);
        return redirect('/control/admins');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admins  $admins
     * @return \Illuminate\Http\Response
     */
    public function show(Admins $admins)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admins  $admins
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $admin = \App\Models\Admins::find($id);
        return view('control.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admins  $admins
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string|unique:admins,email,'.$id,
            'password' => 'required|string',
        ]);

        $like = Admins::where('id', $id)
        ->update($data);

        return redirect('/control/admins');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admins  $admins
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Admins::destroy($id);
        return redirect('/control/admins');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        
        if (is_array($ids)) 
        {
            Admins::destroy($ids);
        }
        else
        {
            $pars = explode(",",$ids);
            foreach ($pars as $par){
                Admins::destroy($par);
            }
        }
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
