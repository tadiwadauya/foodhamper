<?php

namespace App\Http\Controllers;

use App\Models\FoodCollection;
use App\Models\Jobcard;
use App\Models\MeatCollection;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportsController extends Controller
{
    public function getUserCollection(){
        $users = User::all();

        return view('reports.user-collection',compact('users'));
    }

    public function postUserCollection(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'collection_type' => 'required',
            'paynumber' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            try {
                $users = User::all();
                $user = User::where('paynumber',$request->paynumber)->first();

                if ($request->collection_type == "food")
                {
                    $ctype = $request->collection_type;
                    $user_collections = FoodCollection::where('paynumber',$user->paynumber)->get();
                }

                if ($request->collection_type == "meat")
                {
                    $ctype = $request->collection_type;
                    $user_collections = MeatCollection::where('paynumber',$user->paynumber)->get();
                }

                return view('reports.user-collection',compact('user_collections','users','user','ctype'));

            } catch (\Exception $e) {
                echo "error - ".$e;
            }
        }

    }

    public function getMonthReport()
    {
        $months = DB::table('jobcards')->select('card_month')->distinct()->get();
        $jobcards = Jobcard::latest()->get();

        return view('reports.month',compact('months','jobcards'));
    }

    public function postMonthReport(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'type' => 'required',
            'card_number' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();

        } else {

            try {

                $jobcards = Jobcard::latest()->get();

                $type = $request->type;

                if ($type == "food")
                {
                    $collections = FoodCollection::where('jobcard',$request->card_number)->get();
                    
                    return view('reports.month',compact('collections','jobcards'));
                }

                if ($type == "meat")
                {
                    $collections = MeatCollection::where('jobcard',$request->card_number)->get();

                    return view('reports.month',compact('collections','jobcards'));
                }

            } catch (\Exception $e)
            {
                echo "error".$e;
            }
        }
    }
}
