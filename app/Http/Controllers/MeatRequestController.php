<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Department;
use App\Models\HumberSetting;
use App\Models\Jobcard;
use App\Models\MeatRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MeatRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mrequests = MeatRequest::all();

        return view('mrequests.index', compact('mrequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = HumberSetting::where('id', 1)->first();
        $users = User::all();
        return view('mrequests.create', compact('users', 'settings'));
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
            'department' => 'required',
            'name' => 'required',
            'allocation' => ['required', 'unique:meat_requests']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            try {
                $mrequest = new MeatRequest();
                $latest = MeatRequest::latest()->first();
                if (!$latest) {
                    $mrequest->request = 'REQ' . ((int)1000000000 + 1);
                } else {
                    $mrequest->request = 'REQ' . ((int)1000000000 + $latest->id + 1);
                }

                $mrequest->paynumber = $request->input('paynumber');
                $mrequest->department = $request->input('department');
                $mrequest->name = $request->input('name');
                $mrequest->allocation = $request->input('allocation');
                $mrequest->done_by = Auth::user()->full_name;

                $mrequest->save();

                $logged_user = Auth::user();

                if ($logged_user->hasRole('admin') || $logged_user->hasRole('datacapturer')) {
                    return redirect('mrequests/create')->with('success', 'Your request has been submitted successfully.');
                } else {
                    return redirect('/home')->with('success', 'Your request has been submitted successfully');
                }
            } catch (\Exception $e) {
                echo 'Error' . $e;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MeatRequest  $meatRequest
     * @return \Illuminate\Http\Response
     */
    public function show(MeatRequest $meatRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MeatRequest  $meatRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(MeatRequest $meatRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MeatRequest  $meatRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'paynumber' => 'required',
            'name' => 'required',
            'department' => 'required',
            'reason' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {

                $mrequest = MeatRequest::findOrFail($id);

                if ($mrequest->status == "collected" || $mrequest->status == "approved") {
                    return back()->with("error", " Request has been $mrequest->status already.");
                } else {
                    $mrequest->reason = $request->input('reason');
                    $mrequest->status = "rejected";
                    $mrequest->trash = 0;
                    $mrequest->save();

                    return redirect('mrequests')->with('success', 'Request has been rejected successfully');
                }
            } catch (\Exception $e) {
                echo "error - " . $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MeatRequest  $meatRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $mrequest = MeatRequest::findOrFail($id);

        if (($mrequest->status == "not approved" && $mrequest->issued_on == null) || ($mrequest->status == "rejected" && $mrequest->issued_on == null)) {
            $mrequest->delete();

            if ($user->hasRole('admin')) {
                return redirect('mrequests')->with('success', 'Request has been deleted successfully');
            } else {

                return redirect('/home')->with('success', "Request has been deleted successfully");
            }
        } else {

            if ($mrequest->status == "approved") {
                if ($user->hasRole('admin')) {
                    $mrequest->delete();
                    return redirect('mrequests')->with('success', 'Request has been deleted Successfully');
                } else {

                    return redirect('/home')->with('info', 'You cannot delete an approved request');
                }
            } else {

                return redirect("/home")->with("warning", "Request cannot be deleted.");
            }
        }
    }

    public function getUsername($paynumber)
    {
        $name = DB::table("users")
            ->where("paynumber", $paynumber)
            ->pluck("name");

        return response()->json($name);
    }

    public function approveRequest($id)
    {
        $request = MeatRequest::findOrFail($id);


        $user = User::where('paynumber', $request->paynumber)->first();

        if ($user->activated == 1) {
            $request->status = "approved";
            $request->trash = 1;
            $request->done_by = Auth::user()->name;
            $request->approver = Auth::user()->paynumber;
            $request->updated_at = now();
            $request->save();

            return redirect('pending-requests')->with('success', 'Request has been approved successfully');
        } else {
            return redirect()->back()->with("error", "Selected user is not active.");
        }


        $allocation = Allocation::where('allocation', $request->allocation)->first();
        $settings = HumberSetting::where('id', 1)->first();

        if ($allocation) {

            if ($settings->food_available == 1) {
                if ($allocation->food_allocation == 1) {
                    // check if there is a request approved for the same allocation
                    $previous = MeatRequest::where('allocation', $request->allocation)
                        ->where('status', '=', 'approved')
                        ->where('trash', '=', 1)
                        ->first();

                    if (!$previous) {
                        $user_status_activated = $allocation->user->activated;
                        if ($user_status_activated == 1) {
                            $request->status = "approved";
                            $request->trash = 1;
                            $request->done_by = Auth::user()->name;
                            $request->approver = Auth::user()->paynumber;
                            $request->updated_at = now();
                            $request->save();

                            return redirect('pending-requests')->with('success', 'Request has been approved successfully');
                        } else {

                            return back()->with('error', "Selected User has been De Activated. Please contact admin for user to be activated.");
                        }
                        return redirect('pending-requests')->with('success', 'Humber request has been approved successfully');
                    } else {

                        if ($request->id == $previous->id) {
                            return back()->with('warning', 'This request has been approved already. ');
                        } else {

                            $request->status = "rejected";
                            $request->forceDelete();

                            return back()->with('warning', 'Requested humber has been approved. Please check on your approved requests.');
                        }
                    }
                } else {
                    return redirect()->back()->with('error', 'Meat humber has been collected.');
                }
            } else {

                return back()->with('error', 'Meat Humbers are currently unavailable');
            }
        } else {

            return back()->with('info', 'User has no allocation.');
        }
    }

    public function rejectRequest($id)
    {
        $mrequest = MeatRequest::findOrFail($id);
        return view('mrequests.reject', compact('mrequest'));
    }

    public function getApproved()
    {
        $requests = MeatRequest::where('status', '=', 'approved')->get();
        return view('mrequests.approved', compact('requests'));
    }

    public function getPending()
    {
        $mrequests = MeatRequest::where('status', '=', 'not approved')->get();
        return view('mrequests.pending', compact('mrequests'));
    }

    public function getCollectedRequests()
    {
        $mrequests = MeatRequest::where('status', '=', 'collected')->get();
        return view('mrequests.collected', compact('mrequests'));
    }

    public function getMeatAllocation($paynumber)
    {

        $allocation = DB::table('allocations')
            ->where([
                ['paynumber', '=', $paynumber],
                ['food_allocation', '=', 1], ['deleted_at', '=', null], ['status', '=', 'not collected']
            ])
            ->pluck('allocation');
        // dd($allocation);
        return response()->json($allocation);
    }

    public function dailyApproval()
    {
        return view('mrequests.daily');
    }

    public function dailyApprovalSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            try {

                $approved = MeatRequest::where('status', '=', 'approved')
                    ->whereDate('updated_at', $request->date)
                    ->get();

                return view('mrequests.daily', compact('approved'));
            } catch (\Exception $e) {
                echo "error - " . $e;
            }
        }
    }

    public function bulkApproveRequest()
    {
        return view('mrequests.bulk-approve');
    }

    public function searchResponse(Request $request)
    {

        $query = $request->get('term', '');
        $products = DB::table('meat_requests');
        if ($request->type == 'paynumber') {
            $products->where('paynumber', 'LIKE', '%' . $query . '%')->where('status', '=', 'not approved')->whereNull('deleted_at');
        }
        $products = $products->get();
        $data = array();
        foreach ($products as $product) {
            $data[] = array(
                'paynumber' => $product->paynumber,
                'department' => $product->department,
                'name' => $product->name,
                'allocation' => $product->allocation,
                'created_at' => $product->created_at,
                'done_by' => $product->done_by,
            );
        }
        if (count($data))
            return $data;
        else
            return ['paynumber' => '', 'department' => '', 'name' => '', 'allocation' => '', 'created_at' => '', 'done_by' => ''];
    }

    public function multiInsertPost(Request $request)
    {
        $count = 0;
        for ($count; $count < count($request->paynumber); $count++) {
            if ($request->paynumber) {
                $mrequest = MeatRequest::where('paynumber', $request->paynumber[$count])->first();
                $allocation = Allocation::where('paynumber', $mrequest->paynumber)->first();

                $settings = HumberSetting::where('id', 1)->first();

                if ($settings->food_available == 1) {
                    if ($allocation->food_allocation == 1) {
                        // check if there is a request approved for the same allocation
                        $previous = MeatRequest::where('allocation', $mrequest->allocation)
                            ->where('status', '=', 'approved')
                            ->where('trash', '=', 1)
                            ->first();

                        if (!$previous) {
                            $user_status_activated = $allocation->user->activated;

                            if ($user_status_activated == 1) {
                                $mrequest->status = "approved";
                                $mrequest->trash = 1;
                                $mrequest->done_by = Auth::user()->name;
                                $mrequest->approver = Auth::user()->paynumber;
                                $mrequest->updated_at = now();
                                $mrequest->save();
                            }
                        } else {

                            if ($mrequest->id == $previous->id) {
                                continue;
                            } else {

                                $mrequest->status = "rejected";
                                $mrequest->delete();
                            }
                        }
                    }
                }
            }
        }

        return redirect('mrequests')->with('success', 'Requests has been approved successfully');
    }
}
