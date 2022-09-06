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
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            try {
                $frequest = new MeatRequest();
                $frequest->paynumber = $request->input('paynumber');
                $frequest->department = $request->input('department');
                $frequest->name = $request->input('name');

                if ($request->type == "meat") {
                    $frequest->type = $request->type;

                    if ($request->allocation) {
                        $user_alloc = Allocation::where('allocation', $request->allocation)->first();

                        if ($user_alloc->meet_allocation > 0) {
                            $frequest->allocation = $request->input('allocation');
                        } else {
                            $user_name = User::where('paynumber', $request->paynumber)->first();

                            return back()->with('error', " $user_name->full_name has already collected meat humber for $request->allocation .");
                        }
                    } else {

                        return back()->with('error', 'Selected user does not have pending allocations.');
                    }
                } else {
                    $user = User::where('paynumber', $request->paynumber)->first();
                    $department = Department::where('name', '=', 'Executive')->first();

                    if ($user->department_id == $department->id) {
                        $frequest->type = $request->type;
                    } else {

                        return back()->with('error', 'Selected user cannot apply for extra Hamper');
                    }
                }
                $latest = MeatRequest::latest()->first();

                $frequest->done_by = Auth::user()->full_name;
                $frequest->request = 'REQ' . ((int)1000000000 + $latest->id + 1);
                $frequest->save();

                // if ($frequest->save()) {
                //     $users = User::all();

                //     foreach ($users as $user) {

                //         if ($user->hasRole('admin')) {
                //             try {
                //                 $data = [
                //                     'greeting' => 'Good day, ' . $user->full_name,
                //                     'subject' => $frequest->user->full_name . ' has submitted a humber request. ',
                //                     'body' => $frequest->user->full_name . ' has requested a ' . $request->type . ' humber for ' . $frequest->allocation,
                //                     'action' => 'Approve Request',
                //                     'actionUrl' => "http://192.168.1.242:8080/foodhumbers/email-approve/$frequest->id/$user->paynumber",
                //                 ];

                //                 $user->notify(new MeatRequest($data));
                //             } catch (\Exception $e) {

                //                 Log::info("Error" . $e);
                //             }
                //         }
                //     }
                // }

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

                $frequest = MeatRequest::findOrFail($id);

                if ($frequest->status == "collected" || $frequest->status == "approved") {
                    return back()->with("error", " Request has been $frequest->status already.");
                } else {
                    $frequest->reason = $request->input('reason');
                    $frequest->status = "rejected";
                    $frequest->trash = 0;
                    $frequest->save();

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
        $frequest = MeatRequest::findOrFail($id);

        if (($frequest->status == "not approved" && $frequest->issued_on == null) || ($frequest->status == "rejected" && $frequest->issued_on == null)) {
            $frequest->delete();

            if ($user->hasRole('admin')) {
                return redirect('mrequests')->with('success', 'Request has been deleted successfully');
            } else {

                return redirect('/home')->with('success', "Request has been deleted successfully");
            }
        } else {

            if ($frequest->status == "approved") {
                if ($user->hasRole('admin')) {
                    $frequest->delete();
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

        if ($request->type == 'extra') {
            $user = User::where('paynumber', $request->paynumber)->first();

            $jobcard = Jobcard::where('remaining', '>', 0)->where('card_type', '=', 'meat')->first();

            if ($jobcard) {
                $job_month = $request->paynumber . $jobcard->card_month;

                if ($user->activated == 1) {
                    $request->status = "approved";
                    $request->trash = 1;
                    $request->done_by = Auth::user()->name;
                    $request->approver = Auth::user()->paynumber;
                    $request->updated_at = now();
                    $request->jobcard = $jobcard->card_number;
                    $request->save();

                    // if ($request->save())
                    // {
                    //     $jobcard->updated_at = now();
                    //     $jobcard->extras_previous += 1;
                    //     $jobcard->remaining -= 1;
                    //     $jobcard->save();
                    // }

                    return redirect('pending-requests')->with('success', 'Request has been approved successfully');
                } else {
                    return redirect()->back()->with("error", "Selected user is not active.");
                }
            } else {
                return back()->with("error", "There's no job card for approving the request");
            }
        } else {

            $allocation = Allocation::where('allocation', $request->allocation)->first();
            $settings = HumberSetting::where('id', 1)->first();

            if ($allocation) {
                $request_type = $request->type;

                if ($request_type == 'meat') {
                    if ($settings->food_available == 1) {
                        if ($allocation->food_allocation == 1) {
                            // check if there is a request approved for the same allocation
                            $previous = MeatRequest::where('allocation', $request->allocation)
                                ->where('type', '=', 'meat')
                                ->where('status', '=', 'approved')
                                ->where('trash', '=', 1)
                                ->first();

                            if (!$previous) {
                                // check if there is a jobcard with non allocated units
                                $jobcard = Jobcard::where('remaining', '>', 0)->where('card_type', '=', 'meat')->first();

                                if ($jobcard) {
                                    $job_month = $request->paynumber . $jobcard->card_month;
                                    $user_status_activated = $allocation->user->activated;
                                    if ($user_status_activated == 1) {
                                        $request->status = "approved";
                                        $request->trash = 1;
                                        $request->done_by = Auth::user()->name;
                                        $request->approver = Auth::user()->paynumber;
                                        $request->updated_at = now();
                                        $request->jobcard = $jobcard->card_number;
                                        $request->save();

                                        // $jobcard->updated_at = now();

                                        // if ($job_month == $request->allocation)
                                        // {
                                        //     $jobcard->issued += 1;

                                        // } else {

                                        //     $jobcard->extras_previous += 1;
                                        // }
                                        // $jobcard->remaining -= 1;
                                        // $jobcard->save();

                                        return redirect('pending-requests')->with('success', 'Request has been approved successfully');
                                    } else {

                                        return back()->with('error', "Selected User has been De Activated. Please contact admin for user to be activated.");
                                    }
                                    return redirect('pending-requests')->with('success', 'Humber request has been approved successfully');
                                } else {

                                    return back()->with('error', 'There is no jobcard for approving the request. Please contact Admin for more info');
                                }
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

                    if ($settings->meat_available == 1) {
                        if ($allocation->meet_allocation == 1) {
                            // check if there is a request approved for the same allocation
                            $previous = MeatRequest::where('allocation', $request->allocation)
                                ->where('type', '=', 'meat')
                                ->where('status', '=', 'approved')
                                ->where('trash', '=', 1)
                                ->first();

                            if (!$previous) {
                                // check if there is a jobcard with non allocated units
                                $jobcard = Jobcard::where('remaining', '>', 0)->where('card_type', '=', 'meat')->first();

                                if ($jobcard) {
                                    $job_month = $request->paynumber . $jobcard->card_month;
                                    $user_status_activated = $allocation->user->activated;
                                    if ($user_status_activated == 1) {
                                        $request->status = "approved";
                                        $request->trash = 1;
                                        $request->done_by = Auth::user()->name;
                                        $request->approver = Auth::user()->paynumber;
                                        $request->updated_at = now();
                                        $request->jobcard = $jobcard->card_number;
                                        $request->save();

                                        // $jobcard->updated_at = now();

                                        // if ($job_month == $request->allocation)
                                        // {
                                        //     $jobcard->issued += 1;

                                        // } else {

                                        //     $jobcard->extras_previous += 1;
                                        // }
                                        // $jobcard->remaining -= 1;
                                        // $jobcard->save();

                                    } else {

                                        return back()->with('error', "Selected User has been De Activated. Please contact admin for user to be activated.");
                                    }
                                    return redirect('/pending-requests')->with('success', 'Humber request has been approved successfully');
                                } else {

                                    return back()->with('error', 'There is no jobcard for approving the request. Please create a new job card');
                                }
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
                }
            } else {

                return back()->with('info', 'User has no allocation.');
            }
        }
    }

    public function rejectRequest($id)
    {
        $frequest = MeatRequest::findOrFail($id);
        return view('mrequests.reject', compact('frequest'));
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

    public function getAllocation($paynumber)
    {

        $allocation = DB::table('allocations')->where([
            ['paynumber', '=', $paynumber],
            ['food_allocation', '=', 1], ['deleted_at', '=', null]
        ])
            ->orWhere([['meet_allocation', '=', 1], ['paynumber', '=', $paynumber], ['deleted_at', '=', null]])
            ->pluck('allocation');

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
                'reqtype' => $product->type,
            );
        }
        if (count($data))
            return $data;
        else
            return ['paynumber' => '', 'department' => '', 'name' => '', 'allocation' => '', 'created_at' => '', 'done_by' => '', 'reqtype' => ''];
    }

    public function multiInsertPost(Request $request)
    {
        $count = 0;
        for ($count; $count < count($request->paynumber); $count++) {
            if ($request->paynumber) {
                $frequest = MeatRequest::where('paynumber', $request->paynumber[$count])->first();
                $allocation = Allocation::where('paynumber', $frequest->paynumber)->first();

                $settings = HumberSetting::where('id', 1)->first();

                $request_type = $frequest->type;

                if ($request_type == 'meat') {
                    if ($settings->food_available == 1) {
                        if ($allocation->food_allocation == 1) {
                            // check if there is a request approved for the same allocation
                            $previous = MeatRequest::where('allocation', $frequest->allocation)
                                ->where('type', '=', 'meat')
                                ->where('status', '=', 'approved')
                                ->where('trash', '=', 1)
                                ->first();

                            if (!$previous) {
                                $jobcard = Jobcard::where('remaining', '>', 0)->where('card_type', '=', 'meat')->first();

                                if ($jobcard) {
                                    $job_month = $frequest->paynumber . $jobcard->card_month;
                                    $user_status_activated = $allocation->user->activated;

                                    if ($user_status_activated == 1) {
                                        $frequest->status = "approved";
                                        $frequest->trash = 1;
                                        $frequest->done_by = Auth::user()->name;
                                        $frequest->approver = Auth::user()->paynumber;
                                        $frequest->updated_at = now();
                                        $frequest->jobcard = $jobcard->card_number;
                                        $frequest->save();

                                        $jobcard->updated_at = now();
                                        $jobcard->issued += 1;
                                        // if ($job_month == $request->allocation) {
                                        //     $jobcard->issued += 1;
                                        // } else {

                                        //     $jobcard->extras_previous += 1;
                                        // }
                                        $jobcard->remaining -= 1;
                                        $jobcard->save();
                                    }
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

                if ($request_type == 'meat') {
                    if ($settings->meat_available == 1) {
                        if ($allocation->meet_allocation == 1) {
                            // check if there is a request approved for the same allocation
                            $previous = MeatRequest::where('allocation', $frequest->allocation)
                                ->where('type', '=', 'meat')
                                ->where('status', '=', 'approved')
                                ->where('trash', '=', 1)
                                ->first();

                            if (!$previous) {
                                $jobcard = Jobcard::where('remaining', '>', 0)->where('card_type', '=', 'meat')->first();

                                if ($jobcard) {
                                    $job_month = $frequest->paynumber . $jobcard->card_month;
                                    $user_status_activated = $allocation->user->activated;

                                    if ($user_status_activated == 1) {
                                        $frequest->status = "approved";
                                        $frequest->trash = 1;
                                        $frequest->done_by = Auth::user()->name;
                                        $frequest->approver = Auth::user()->paynumber;
                                        $frequest->updated_at = now();
                                        $frequest->jobcard = $jobcard->card_number;
                                        $frequest->save();

                                        $jobcard->updated_at = now();

                                        $jobcard->issued += 1;

                                        // if ($job_month == $request->allocation) {
                                        //     $jobcard->issued += 1;
                                        // } else {

                                        //     $jobcard->extras_previous += 1;
                                        // }
                                        $jobcard->remaining -= 1;
                                        $jobcard->save();
                                    }
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
        }

        return redirect('mrequests')->with('success', 'Requests has been approved successfully');
    }
}
