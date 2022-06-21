<?php

namespace App\Http\Controllers;

use App\Models\FoodRequest;
use App\Models\HumberSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HumberSettingsController extends Controller
{

    public function getSettings(){
        $humber = HumberSetting::findOrFail(1);
        return view('hsettings.hsettings',compact('humber'));
    }

    public function updateSettings(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'food_available' => 'required',
            'meat_available' => 'required',
            'last_agent' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else {
            try {

                $hsetting = HumberSetting::findOrFail($id);
                $hsetting->food_available = $request->food_available;
                $hsetting->meat_available = $request->meat_available;
                $hsetting->last_agent = $request->last_agent;
                $hsetting->save();

                return redirect('home')->with('success','System settings has been updated successfully');

            } catch (\Exception $e) {
                echo "Error - ".$e;
            }
        }
    }

    public function deleteRequests(){

        $requests = FoodRequest::where('status','=','approved')->get();

        $deleted = array();

        foreach($requests as $request)
        {
            try {

                // $paynumber = $request->paynumber;
                // $month = $request->job->card_month;
                // $jobcard_month = $paynumber.$month;

                $request->delete();

                if($request->delete())
                {
                    // if($request->allocation == $jobcard_month)
                    // {
                    //     $request->job->issued -= 1;
                    //     $request->job->remaining += 1;
                    //     $request->job->save();

                    // } else {

                    //     $request->job->extras_previous -= 1;
                    //     $request->job->remaining += 1;
                    //     $request->job->save();
                    // }

                    array_push($deleted,$request->request);

                    $request->forceDelete();
                }

            } catch (\Exception $e) {
                echo "Error - ".$e;
            }
        }


        Log::info($deleted);

        if (empty($deleted))
        {
            return redirect()->back()->with('success','No requests were found.');
        } else {

            return redirect()->back()->with('success','Approved requests has been deleted');

        }
    }

    public function deleteRequestsPending()
    {
        $requests = FoodRequest::where('status','=','not approved')->get();

        $deleted = array();

        foreach($requests as $request)
        {
            try {

                $request->delete();

                if($request->delete())
                {
                    array_push($deleted,$request->request);

                    $request->forceDelete();
                }

            } catch (\Exception $e) {
                echo "Error - ".$e;
            }
        }


        Log::info($deleted);

        if (empty($deleted))
        {
            return redirect()->back()->with('success','No requests were found.');
        } else {

            return redirect()->back()->with('success','Approved requests has been deleted');

        }
    }
}
