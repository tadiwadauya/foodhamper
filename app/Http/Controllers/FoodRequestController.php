<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Department;
use App\Models\FoodRequest;
use App\Models\HumberSetting;
use App\Models\Jobcard;
use App\Models\User;
use App\Notifications\FoodRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FoodRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $frequests = FoodRequest::all();

        return view('frequests.index', compact('frequests'));
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
        return view('frequests.create', compact('users', 'settings'));
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
            'allocation' => ['required', 'unique:food_requests']
            // 'type' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            try {
                $frequest = new FoodRequest();
                $latest = FoodRequest::latest()->first();
                if (!$latest) {
                    $frequest->request = 'REQ' . ((int)1000000000 + 1);
                } else {
                    $frequest->request = 'REQ' . ((int)1000000000 + $latest->id + 1);
                }

                $frequest->paynumber = $request->input('paynumber');
                $frequest->department = $request->input('department');
                $frequest->name = $request->input('name');
                $frequest->allocation = $request->input('allocation');
                $frequest->done_by = Auth::user()->full_name;

                $frequest->save();

                $logged_user = Auth::user();

                if ($logged_user->hasRole('admin') || $logged_user->hasRole('datacapturer')) {
                    return redirect('frequests/create')->with('success', 'Your request has been submitted successfully.');
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

                $frequest = FoodRequest::findOrFail($id);

                if ($frequest->status == "collected" || $frequest->status == "approved") {
                    return back()->with("error", " Request has been $frequest->status already.");
                } else {
                    $frequest->reason = $request->input('reason');
                    $frequest->status = "rejected";
                    $frequest->trash = 0;
                    $frequest->save();

                    return redirect('frequests')->with('success', 'Request has been rejected successfully');
                }
            } catch (\Exception $e) {
                echo "error - " . $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $frequest = FoodRequest::findOrFail($id);

        if (($frequest->status == "not approved" && $frequest->issued_on == null) || ($frequest->status == "rejected" && $frequest->issued_on == null)) {
            $frequest->delete();

            if ($user->hasRole('admin')) {
                return redirect('frequests')->with('success', 'Request has been deleted successfully');
            } else {

                return redirect('/home')->with('success', "Request has been deleted successfully");
            }
        } else {

            if ($frequest->status == "approved") {
                if ($user->hasRole('admin')) {
                    $frequest->delete();
                    return redirect('frequests')->with('success', 'Request has been deleted Successfully');
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
        $request = FoodRequest::findOrFail($id);

        $allocation = Allocation::where('allocation', $request->allocation)->first();
        $settings = HumberSetting::where('id', 1)->first();

        if ($allocation) {
            if ($settings->food_available == 1) {
                if ($allocation->food_allocation == 1) {
                    // check if there is a request approved for the same allocation
                    $previous = FoodRequest::where('allocation', $request->allocation)
                        ->where('status', '=', 'approved')
                        ->where('trash', '=', 1)
                        ->first();

                    if (!$previous) {
                        // check if there is a jobcard with non allocated units
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
                    return redirect()->back()->with('error', 'Food humber has been collected.');
                }
            } else {

                return back()->with('error', 'Food Humbers are currently unavailable');
            }
        } else {

            return back()->with('info', 'User has no allocation.');
        }
    }

    public function rejectRequest($id)
    {
        $frequest = FoodRequest::findOrFail($id);
        return view('frequests.reject', compact('frequest'));
    }

    public function getApproved()
    {
        $requests = FoodRequest::where('status', '=', 'approved')->get();
        return view('frequests.approved', compact('requests'));
    }

    public function getPending()
    {
        $frequests = FoodRequest::where('status', '=', 'not approved')->get();
        return view('frequests.pending', compact('frequests'));
    }

    public function getCollectedRequests()
    {
        $frequests = FoodRequest::where('status', '=', 'collected')->get();
        return view('frequests.collected', compact('frequests'));
    }

    public function getAllocation($paynumber)
    {

        $allocation = DB::table('allocations')->where([
            ['paynumber', '=', $paynumber],
            ['status', '=', 'not collected'], ['deleted_at', '=', null]
        ])
            ->pluck('allocation');

        return response()->json($allocation);
    }

    public function dailyApproval()
    {
        return view('frequests.daily');
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

                $approved = FoodRequest::where('status', '=', 'approved')
                    ->whereDate('updated_at', $request->date)
                    ->get();

                return view('frequests.daily', compact('approved'));
            } catch (\Exception $e) {
                echo "error - " . $e;
            }
        }
    }

    public function bulkApproveRequest()
    {
        return view('frequests.bulk-approve');
    }

    public function searchResponse(Request $request)
    {

        $query = $request->get('term', '');
        $products = DB::table('food_requests');
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
                $frequest = FoodRequest::where('paynumber', $request->paynumber[$count])->first();
                $allocation = Allocation::where('paynumber', $frequest->paynumber)->first();

                $settings = HumberSetting::where('id', 1)->first();

                if ($settings->food_available == 1) {
                    if ($allocation->food_allocation == 1) {
                        // check if there is a request approved for the same allocation
                        $previous = FoodRequest::where('allocation', $frequest->allocation)
                            ->where('status', '=', 'approved')
                            ->where('trash', '=', 1)
                            ->first();

                        if (!$previous) {
                            $user_status_activated = $allocation->user->activated;

                            if ($user_status_activated == 1) {
                                $frequest->status = "approved";
                                $frequest->trash = 1;
                                $frequest->done_by = Auth::user()->name;
                                $frequest->approver = Auth::user()->paynumber;
                                $frequest->updated_at = now();
                                $frequest->save();
                            }
                        } else {

                            if ($frequest->id == $previous->id) {
                                continue;
                            } else {

                                $frequest->status = "rejected";
                                $frequest->delete();
                            }
                        }
                    }
                }
            }
        }

        return redirect('frequests')->with('success', 'Requests has been approved successfully');
    }
}
