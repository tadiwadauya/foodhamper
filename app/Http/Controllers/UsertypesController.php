<?php

namespace App\Http\Controllers;

use App\Models\Usertype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsertypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usertypes = Usertype::all();
        return view('usertypes.index',compact('usertypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usertypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'type' => 'required|unique:usertypes',
                'description' => 'required'
            ],
        );

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $type = Usertype::create([
            'type' => $request->input('type'),
            'description' => strip_tags($request->input('description')),
        ]);
        $type->save();

        return redirect('usertypes')->with('success','New user type has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usertype  $usertype
     * @return \Illuminate\Http\Response
     */
    public function show(Usertype $usertype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usertype  $usertype
     * @return \Illuminate\Http\Response
     */
    public function edit(Usertype $usertype)
    {
        return view('usertypes.edit',compact('usertype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usertype  $usertype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usertype $usertype)
    {
        $validator = Validator::make($request->all(),[
                'type' => 'required|unique:usertypes',
                'description' => 'required',
            ],
        );

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $usertype->type = $request->input('type');
        $usertype->description = $request->input('description');
        $usertype->save();

        return redirect('usertypes')->with('success','Employee type has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usertype  $usertype
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usertype = Usertype::findOrFail($id);
        $usertype->delete();

        return redirect('usertypes')->with('success','Employee type has been deleted successfully');
    }
}
