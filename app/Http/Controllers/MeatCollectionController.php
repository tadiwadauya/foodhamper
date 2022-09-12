<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Beneficiary;
use App\Models\MeatRequest;
use App\Models\Jobcard;
use App\Models\MeatAllocation;
use App\Models\MeatCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MeatCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections = MeatCollection::latest()->get();
        return view('mcollections.index', compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $requests = MeatRequest::where([
            ['trash', '=', 1],
            ['status', '=', 'approved'],
            ['issued_on', '=', null]
        ])
            ->get();

        return view('mcollections.create', compact('requests'));
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
            'jobcard' => 'required',
            'mrequest' => 'required|unique:meat_collections,mrequest',
            'allocation' => 'required|unique:meat_collections,allocation',
            'issue_date' => 'required',
            'iscollector' => 'required',
            'pin' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            try {

                $mrequest = MeatRequest::findOrFail($request->paynumber);
                $user = User::where('paynumber', $mrequest->paynumber)->first();

                $collect = new MeatCollection();
                $collect->paynumber = $user->paynumber;
                $collect->jobcard = $request->input('jobcard');
                $collect->mrequest = $request->input('mrequest');
                $collect->allocation = $request->input('allocation');
                $collect->issue_date = $request->input('issue_date');

                if ($request->iscollector == 'self') {
                    $collect->self = 1;
                } else {
                    $id_number = $request->collected_by;

                    if ($id_number) {
                        $beneficiary = Beneficiary::where('id_number', $id_number)->first();
                        $collect->self = 0;
                        $collect->collected_by = $beneficiary->full_name;
                        $collect->id_number = $beneficiary->id_number;
                    } else {

                        return redirect()->back()->with("error", "Please select employee beneficiary");
                    }
                }

                if (Hash::check($request->pin, $user->pin)) {
                    $collect->done_by = Auth::user()->id;
                    $collect->updated_at = now();
                    $collect->status = 1;

                    $jobcard = Jobcard::where('card_number', $request->input('jobcard'))->first();
                    // $job_month = $mrequest->paynumber . $jobcard->card_month;

                    if ($jobcard->remaining > 0) {
                        $jobcard->updated_at = now();
                        $jobcard->issued += 1;

                        $jobcard->remaining -= 1;
                        $jobcard->save();

                        if ($jobcard->save()) {
                            $collect->save();

                            if ($collect->save()) {
                                $mrequest->status = "collected";
                                $mrequest->jobcard = $jobcard->card_number;
                                $mrequest->issued_on = now();
                                $mrequest->save();

                                $allocation = MeatAllocation::where('meatallocation', $request->allocation)->first();
                                $allocation->meat_allocation -= 1;
                                $allocation->status = "collected";
                                $allocation->save();

                                $user->mcount -= 1;
                                $user->save();
                            }

                            return redirect('mcollections/create')->with('success', 'Collection has been processed successfully');
                        }
                    } else {
                        return redirect()->back()->with('error', 'Selected jobcard has no remaining units');
                    }
                } else {
                    return redirect()->back()->with('error', 'Invalid pin supplied.');
                }
            } catch (\Exception $e) {
                echo "error - " . $e;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MeatCollection  $meatCollection
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collection = MeatCollection::findOrFail($id);

        return view('mcollections.show', compact('collection'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MeatCollection  $meatCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(MeatCollection $meatCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MeatCollection  $meatCollection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MeatCollection $meatCollection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MeatCollection  $meatCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(MeatCollection $meatCollection)
    {
        //
    }

    public function getRequestType($id)
    {
        $type = DB::table("food_requests")
            ->where("id", $id)
            ->pluck("type");

        return response()->json($type);
    }

    public function getMeatRequest($id)
    {
        $data = DB::table("meat_requests")
            ->where("id", $id)
            ->pluck("request");

        return response()->json($data);
    }

    public function getMeatRequestAllocation($id)
    {
        $allocation = DB::table("meat_requests")
            ->where("id", $id)
            ->pluck("allocation");

        return response()->json($allocation);
    }

    public function getMeatType($id)
    {
        $mrequest = MeatRequest::findOrFail($id);

        $allocation = DB::table('meat_allocations')
            ->where('meatallocation', $mrequest->allocation)
            ->pluck('meat_a', 'meat_b');

        return response()->json($allocation);
    }

    public function getUserBeneficiaries($id)
    {
        $request = MeatRequest::where('id', $id)->first();

        $user = User::where('paynumber', $request->paynumber)->first();

        $beneficiaries = DB::table('beneficiary_user')
            ->rightJoin('beneficiaries', 'beneficiary_user.beneficiary_id', '=', 'beneficiaries.id')
            ->where('beneficiary_user.user_id', '=', $user->id)
            ->pluck('first_name', 'id_number');

        return response()->json($beneficiaries);
    }
}
