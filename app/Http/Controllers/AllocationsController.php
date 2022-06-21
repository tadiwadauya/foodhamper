<?php

namespace App\Http\Controllers;

use App\Imports\AllocationsImport;
use App\Models\Allocation;
use App\Models\Department;
use App\Models\User;
use App\Models\Usertype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AllocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allocations = Allocation::orderBy('created_at', 'desc')->get();
        return view('allocations.index',compact('allocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('activated',1)->get();
        return view('allocations.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'paynumber' => 'required',
            'meet_a' => 'required',
            'meet_b' => 'required',
            'allocation' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else {

            try {
                $user = User::where('paynumber',$request->paynumber)->first();

                if ($user->activated == 1) {

                    $allocations = $user->allocations->count();

                    if ($allocations == 0)
                    {
                        $create_alloc = $request->paynumber.$request->input('allocation');

                        try {

                            $allocation = Allocation::create([
                                'paynumber' => $request->input('paynumber'),
                                'allocation' => $create_alloc ,
                                'meet_a' => $request->input('meet_a'),
                                'meet_b' => $request->input('meet_b'),
                                'meet_allocation' => 1,
                                'food_allocation' => 1,
                                'status' => 'not collected',
                            ]);

                            $allocation->save();

                            if ($allocation->save())
                            {
                                $allocation->user->fcount += 1;
                                $allocation->user->mcount += 1;
                                $allocation->user->save();

                                return redirect('allocations')->with('success','User has been allocated successfully');
                            }

                        } catch (\Exception $e)
                        {
                            echo 'Error'.$e;
                        }
                        
                    } else {

                        // previous allocation
                        $user = Auth::user();
                        $create_alloc = $request->paynumber.$request->input('allocation');

                        try {

                            if ($user->hasRole('admin'))
                            {
                                $allocation = Allocation::create([
                                    'paynumber' => $request->input('paynumber'),
                                    'allocation' => $create_alloc ,
                                    'meet_a' => $request->input('meet_a'),
                                    'meet_b' => $request->input('meet_b'),
                                    'meet_allocation' => 1,
                                    'food_allocation' => 1,
                                    'status' => 'not collected',
                                ]);
                                $allocation->save();

                                if ($allocation->save())
                                {
                                    $allocation->user->fcount += 1;
                                    $allocation->user->mcount += 1;
                                    $allocation->user->save();

                                    return redirect('allocations')->with('success','Previous allocation has been created successfully.');
                                }
                            }

                        } catch (\Exception $e) {
                            echo "Error - ".$e;
                        }
                    }

                }
                else {
                    return redirect()->back()->with('warning','User is not activated.');
                }

            } catch (\Exception $th) {
                echo "Error - ".$th;
            }


        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function show(Allocation $allocation)
    {
        return view('allocations.show',compact('allocation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function edit(Allocation $allocation)
    {
        return view('allocations.edit',compact('allocation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Allocation $allocation)
    {
        $validator = Validator::make($request->all(), [
            'meet_a' => 'required',
            'meet_b' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $allocation->meet_a = $request->input('meet_a');
        $allocation->meet_b = $request->input('meet_b');
        $allocation->save();

        return redirect('allocations')->with('success','Allocation has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $allocation = Allocation::findOrFail($id);

        // check the allocation status
        $status = $allocation->status;

        if ($status == 'not collected')
        {
            $deleted = $allocation->delete();

            if ($deleted)
            {
                $allocation->user->fcount -= 1;
                $allocation->user->mcount -= 1;
                $allocation->user->save();

                return redirect('allocations')->with('success','Allocation has been deleted successfully');
            }
        }else
        {
            return redirect()->back()->with('error','Allocation has already been issued.');
        }

        return redirect('allocations')->with('success','Allocation has been deleted Successfully');
    }

    public function getName($paynumber)
    {
        $name = DB::table("users")
          ->where("paynumber",$paynumber)
          ->pluck("user_id");

        return response()->json($name);
    }

    public function allocationImportForm() {

        return view('allocations.import');
    }

    public function allocationImportSend(Request $request) {

        $validator = Validator::make($request->all(),[
            'allocation' => 'required',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Excel::import(new AllocationsImport,request()->file('allocation'));

        return redirect('allocations')->with('Data has been imported successfully');
    }

    public function allAllocations()
    {
        $users = User::all();

        foreach ($users as $user) {

            if ($user->activated == 1) {

                $month_allocation = date('FY');

                if($user->allocation) {
                    // check if user has been allocated for that month
                    $allocation_user = Allocation::where('allocation',$month_allocation)
                        ->where('paynumber',$user->paynumber)
                        ->latest()->first();

                    if (!$allocation_user )
                    {
                        $last_month = DB::table('allocations')->where('paynumber',$user->paynumber)->orderByDesc('id')->first();

                        $allocation = Allocation::create([
                            'allocation' => $month_allocation,
                            'paynumber' => $user->paynumber,
                            'food_allocation' => 1,
                            'meet_allocation' => 1,
                            'meet_a' => $last_month->meet_a,
                            'meet_b' => $last_month->meet_b,
                        ]);
                        $allocation->save();

                        if ($allocation->save()) {

                            $allocation->user->fcount += 1;
                            $allocation->user->mcount +=1;
                            $allocation->user->save();
                        }
                    } else {
                        continue;
                    }
                }
            }
        }

        return redirect('allocations')->with('success','Users has been allocated Successfully');
    }

    public function getDepartmentalUsers($department)
    {
        if($department == "department") {
            $name = DB::table("departments")
            ->where('id','>=',0)
            ->pluck("department");
            return response()->json($name);
        }

        if( $department == "etype") {

            $name = DB::table("usertypes")
            ->where('id','>=',0)
            ->pluck("type");
            return response()->json($name);
        }

    }

    public function getAllocation($paynumber) {

        $allocation = Allocation::where('paynumber',$paynumber)
                    ->where('food_allocation','>',0)
                    ->where('deleted_at','=',null)
                    ->pluck('allocation');

        return response()->json($allocation);
    }

    public function downloadAllocationForm()
    {
        $myFile = public_path("starter-downloads/allocation import.xlsx");

        return response()->download($myFile);
    }

}
