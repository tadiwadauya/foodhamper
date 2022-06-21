<?php

namespace App\Http\Controllers;

use App\Models\Jobcard;
use Illuminate\Http\Request;

class SoftDeleteJobcardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobcards = Jobcard::onlyTrashed()->latest()->get();
        return view('jobcards.deleted-jobcards',compact('jobcards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jobcard = Jobcard::withTrashed()->where('id',$id)->first();
        $jobcard->forceDelete();

        return redirect('jobcards')->with('success','Jobcard has been deleted Successfully');
    }

    public function restoreJob($id) {
        $card = Jobcard::withTrashed()->where('id',$id)->first();
        $card->save();
        $card->restore();

        return redirect('jobcards')->with('success','Jobcard has been restored successfully');
    }
}
