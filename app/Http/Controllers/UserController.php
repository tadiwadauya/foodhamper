<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Allocation;
use App\Models\FoodRequest;
use App\Models\HumberSetting;

class UserController extends Controller
{

    public function myAllocations()
    {
        $user = Auth::user();
        $allocations = Allocation::where('paynumber',$user->paynumber)->get();

        return view('pages.user.my-allocations',compact('allocations'));
    }

    public function createRequest()
    {
        $user = Auth::user();
        $settings = HumberSetting::where('id',1)->first();
        $allocations = Allocation::where('paynumber',$user->paynumber)->get();
        return view('pages.user.create-request',compact('settings','allocations'));
    }

    public function myRequets()
    {
        $frequests = FoodRequest::where('paynumber',Auth::user()->paynumber)->get();

        return view('pages.user.all-request',compact('frequests'));
    }


}
