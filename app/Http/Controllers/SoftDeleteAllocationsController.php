<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\User;
use Illuminate\Http\Request;

class SoftDeleteAllocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allocations = Allocation::onlyTrashed()->latest()->get();
        return view('allocations.deleted-allocations',compact('allocations'));
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
        $allocation = Allocation::withTrashed()->where('id',$id)->first();
        $allocation->save();
        $allocation->restore();

        if ($allocation->restore())
        {
            $user = User::where('paynumber',$allocation->paynumber)->first();
            $user->fcount += 1;
            $user->mcount += 1;
            $user->save();

            return redirect('allocations')->with('success','Allocation has been restored successfully');
        }
        else{
            return back()->with('error','Allocation could not be restored properly.');
        }

        return redirect('allocations')->with('error','Failed to restore allocation.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $allocation = Allocation::withTrashed()->where('id',$id)->first();
        $allocation->forceDelete();

        return redirect('allocations')->with('success','Allocation has been deleted Successfully');
    }
}
