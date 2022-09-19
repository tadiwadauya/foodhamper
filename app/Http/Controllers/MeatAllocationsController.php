<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AllocationsImport;
use App\Imports\MeatAllocationsImport;
use App\Models\MeatAllocation;
use App\Models\Department;
use App\Models\User;
use App\Models\Usertype;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class MeatAllocationsController extends Controller
{
    // public function index()
    // {
    //     $meatallocations = MeatAllocation::orderBy('created_at', 'desc')->get();
    //     return view('meatallocations.index', compact('meatallocations'));
    // }

    public function index()
    {
        // $allocations = Allocation::orderBy('created_at', 'desc')->get();


        $date = Carbon::today()->addMonths(-1);
        $meatallocations = MeatAllocation::where('created_at', '>=', $date)
            ->get();
        return view('meatallocations.index', compact('meatallocations'));
    }

    public function searchFoodAllocation(Request $request)
    {

        $meatallocations = MeatAllocation::whereBetween('created_at', [$request->From_date, $request->To_date])
            ->get();

        return view('meatallocations.index', compact('meatallocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('activated', 1)->get();
        return view('meatallocations.create', compact('users'));
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
            'meat_a' => 'required',
            'meat_b' => 'required',
            'meatallocation' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            try {
                $user = User::where('paynumber', $request->paynumber)->first();

                if ($user->activated == 1) {

                    $meatallocations = $user->meatallocations;

                    if ($meatallocations == 0) {
                        $create_alloc = $request->paynumber . $request->input('meatallocation');

                        try {

                            $meatallocation = MeatAllocation::create([
                                'paynumber' => $request->input('paynumber'),
                                'meatallocation' => $create_alloc,
                                'meat_a' => $request->input('meat_a'),
                                'meat_b' => $request->input('meat_b'),
                                'meat_allocation' => 1,
                                'status' => 'not collected',
                            ]);

                            $meatallocation->save();

                            if ($meatallocation->save()) {
                                $meatallocation->user->mcount += 1;
                                $meatallocation->user->save();

                                return redirect('meatallocations')->with('success', 'User has been allocated successfully');
                            }
                        } catch (\Exception $e) {
                            echo 'Error' . $e;
                        }
                    } else {

                        // previous allocation
                        $user = Auth::user();
                        $create_alloc = $request->paynumber . $request->input('meatallocation');

                        try {

                            if ($user->hasRole('admin')) {
                                $meatallocation = MeatAllocation::create([
                                    'paynumber' => $request->input('paynumber'),
                                    'meatallocation' => $create_alloc,
                                    'meat_a' => $request->input('meat_a'),
                                    'meat_b' => $request->input('meat_b'),
                                    'meat_allocation' => 1,
                                    'status' => 'not collected',
                                ]);
                                $meatallocation->save();

                                if ($meatallocation->save()) {

                                    $meatallocation->user->mcount += 1;
                                    $meatallocation->user->save();

                                    return redirect('meatallocations')->with('success', 'Previous meat allocation has been created successfully.');
                                }
                            }
                        } catch (\Exception $e) {
                            echo "Error - " . $e;
                        }
                    }
                } else {
                    return redirect()->back()->with('warning', 'User is not activated.');
                }
            } catch (\Exception $th) {
                echo "Error - " . $th;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function show(MeatAllocation $meatallocation)
    {
        return view('meatallocations.show', compact('meatallocation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function edit(MeatAllocation $meatallocation)
    {
        return view('meatallocations.edit', compact('meatallocation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MeatAllocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MeatAllocation $meatallocation)
    {
        $validator = Validator::make($request->all(), [
            'meat_a' => 'required',
            'meat_b' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $meatallocation->meat_a = $request->input('meat_a');
        $meatallocation->meat_b = $request->input('meat_b');
        $meatallocation->save();

        return redirect('meatallocations')->with('success', 'meat Allocation has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meatallocation = MeatAllocation::findOrFail($id);

        // check the allocation status
        $status = $meatallocation->status;

        if ($status == 'not collected') {
            $deleted = $meatallocation->delete();

            if ($deleted) {
                $meatallocation->user->mcount -= 1;
                $meatallocation->user->save();

                return redirect('meatallocations')->with('success', 'meat Allocation has been deleted successfully');
            }
        } else {
            return redirect()->back()->with('error', 'meat Allocation has already been issued.');
        }

        return redirect('meatallocations')->with('success', 'meat Allocation has been deleted Successfully');
    }

    public function getName($paynumber)
    {
        $name = DB::table("users")
            ->where("paynumber", $paynumber)
            ->pluck("user_id");

        return response()->json($name);
    }

    public function meatallocationImportForm()
    {

        return view('meatallocations.import');
    }

    public function meatallocationImportSend(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'meatallocation' => 'required',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Excel::import(new MeatAllocationsImport, request()->file('meatallocation'));

        return redirect('meatallocations')->with('Data has been imported successfully');
    }

    public function allMeatAllocations()
    {
        $users = User::all();

        foreach ($users as $user) {

            if ($user->activated == 1) {

                $month_allocation = date('FY');

                if ($user->meatallocation) {
                    // check if user has been allocated for that month
                    $allocation_user = MeatAllocation::where('meatallocation', $month_allocation)
                        ->where('paynumber', $user->paynumber)
                        ->latest()->first();

                    if (!$allocation_user) {
                        $last_month = DB::table('meatallocations')->where('paynumber', $user->paynumber)->orderByDesc('id')->first();

                        $meatallocation = MeatAllocation::create([
                            'meatallocation' => $month_allocation,
                            'paynumber' => $user->paynumber,
                            'meat_allocation' => 1,
                            'meat_a' => $last_month->meat_a,
                            'meat_b' => $last_month->meat_b,
                        ]);
                        $meatallocation->save();

                        if ($meatallocation->save()) {

                            $meatallocation->user->mcount += 1;
                            $meatallocation->user->save();
                        }
                    } else {
                        continue;
                    }
                }
            }
        }

        return redirect('meatallocations')->with('success', 'Users has been allocated Successfully');
    }

    public function getDepartmentalUsers($department)
    {
        if ($department == "department") {
            $name = DB::table("departments")
                ->where('id', '>=', 0)
                ->pluck("department");
            return response()->json($name);
        }

        if ($department == "etype") {

            $name = DB::table("usertypes")
                ->where('id', '>=', 0)
                ->pluck("type");
            return response()->json($name);
        }
    }

    public function getAllocation($paynumber)
    {

        $meatallocation = MeatAllocation::where('paynumber', $paynumber)
            ->where([
                ['meat_allocation', '>', 0],
                ['deleted_at', '=', null],
                ['status', '=', 'not collected'],
            ])->pluck('meatallocation');

        return response()->json($meatallocation);
    }

    public function downloadAllocationForm()
    {
        $myFile = public_path("starter-downloads/meatallocation import.xlsx");

        return response()->download($myFile);
    }
}
