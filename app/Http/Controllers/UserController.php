<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Allocation;
use App\Models\MeatAllocation;
use App\Models\FoodRequest;
use App\Models\MeatRequest;
use App\Models\HumberSetting;

class UserController extends Controller
{

    public function myAllocations()
    {
        $user = Auth::user();
        $allocations = Allocation::where('paynumber', $user->paynumber)->latest()->get();

        return view('pages.user.my-allocations', compact('allocations'));
    }

    public function mymeatAllocations()
    {
        $user = Auth::user();
        $meatallocations = MeatAllocation::where('paynumber', $user->paynumber)->latest()->get();

        return view('pages.user.my-meatallocations', compact('meatallocations'));
    }

    public function createRequest()
    {
        $user = Auth::user();
        $settings = HumberSetting::where('id', 1)->first();
        $allocations = Allocation::where([
            ['paynumber', $user->paynumber],
            ['status', '=', 'not collected']
        ])->get();
        return view('pages.user.create-request', compact('settings', 'allocations'));
    }


    public function createMRequest()
    {
        $user = Auth::user();
        $settings = HumberSetting::where('id', 1)->first();
        $meatallocations = MeatAllocation::where([
            ['paynumber', $user->paynumber],
            ['status', '=', 'not collected']
        ])->get();
        return view('pages.user.create-mrequest', compact('settings', 'meatallocations'));
    }

    public function myRequets()
    {
        $frequests = FoodRequest::where('paynumber', Auth::user()->paynumber)->get();

        return view('pages.user.all-request', compact('frequests'));
    }
    public function mymeatRequets()
    {
        $mrequests = MeatRequest::where('paynumber', Auth::user()->paynumber)->get();

        return view('pages.user.all-mrequest', compact('mrequests'));
    }
}
