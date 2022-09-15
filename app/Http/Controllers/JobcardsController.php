<?php

namespace App\Http\Controllers;

use App\Imports\JobcardImport;
use App\Models\Jobcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class JobcardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobcards = Jobcard::latest()->get();
        return view('jobcards.index', compact('jobcards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jobcards.create');
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
            'card_number' => 'required|unique:jobcards',
            'date_opened' => 'required',
            'card_month' => 'required',
            'card_type' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            try {
                $jobcard = new Jobcard();
                $card_type = $request->input('card_type');

                $non_empty = Jobcard::where([['card_type', $card_type], ['remaining', '>', 0]])->first();

                if ($non_empty) {
                    return redirect()->back()->with('error', 'There is a jobcard with units.');
                } else {
                    if ($card_type == 'food') {
                        $jobcard->card_number = $request->input('card_number');
                        $jobcard->date_opened = $request->input('date_opened');
                        $jobcard->card_month = $request->input('card_month');
                        $jobcard->card_type = $request->input('card_type');
                        $jobcard->quantity = $request->input('quantity');
                        $jobcard->remaining = $request->input('quantity');

                        $jobcard->save();

                        if ($jobcard->save()) {
                            return redirect()->back()->with('success', 'Jobcard has been created successfully');
                        }
                    } else {
                        $jobcard->card_number = $request->input('card_number');
                        $jobcard->date_opened = $request->input('date_opened');
                        $jobcard->card_month = $request->input('card_month');
                        $jobcard->card_type = $request->input('card_type');
                        $jobcard->quantity = $request->input('quantity');
                        $jobcard->remaining = $request->input('quantity');

                        $jobcard->save();

                        if ($jobcard->save()) {
                            return redirect()->back()->with('success', 'Jobcard has been created successfully');
                        }
                    }
                }
            } catch (\Exception $e) {
                echo "Error - " . $e;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function show(Jobcard $jobcard)
    {
        return 'sex';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function edit(Jobcard $jobcard)
    {
        return view('jobcards.edit', compact('jobcard'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jobcard $jobcard)
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'required',
            'date_opened' => 'required',
            'card_month' => 'required',
            'card_type' => 'required',
            'quantity' => 'required',
            'issued' => 'required',
            'remaining' => 'required',
            // 'extras_previous' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            try {
                // checking the request type
                {

                    $total = $jobcard->issued + $jobcard->extras_previous; {
                        // can edit evertthing on the card
                        $jobcard->card_number = $request->input('card_number');
                        $jobcard->date_opened = $request->input('date_opened');
                        $jobcard->card_month = $request->input('card_month');
                        $jobcard->card_type = $request->input('card_type');
                        $jobcard->quantity = $request->input('quantity');
                        $jobcard->issued = $request->input('issued');
                        $jobcard->remaining = $request->input('remaining');
                        // $jobcard->extras_previous = $request->input('extras_previous');
                        $jobcard->save();

                        return redirect('jobcards')->with('success', 'Jobcard has been updated successfully');
                    }
                }
            } catch (\Exception $e) {
                echo "Error - " . $e;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jobcard = Jobcard::findOrFail($id);

        // check if the jobcard has been issued or not
        // $total = $jobcard->issued + $jobcard->extras_previous;
        $total = $jobcard->issued;

        if ($total == 0) {
            $jobcard->delete();

            return redirect('jobcards')->with('success', 'Jobcard has been deleted successfully');
        } else {

            return back()->with('error', 'Job Card Cannot be deleted.');
        }
    }

    public function downloadJobcardForm()
    {
        $myFile = public_path("starter-downloads/jobcards.xlsx");

        return response()->download($myFile);
    }

    public function importJobcards()
    {
        return view('jobcards.import');
    }

    public function uploadJobcards(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jobcard' => 'required',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Excel::import(new JobcardImport, request()->file('jobcard'));

        return redirect('jobcards')->with('Data has been imported successfully');
    }

    public function getAvailableJobCard()
    {
        $card_number = DB::select('Select card_number from jobcards where remaining > 0 and card_type = "food"');

        return $card_number;
    }

    public function getAvailableMeatJobCard()
    {
        $card_number = DB::select('Select card_number from jobcards where remaining > 0 and card_type = "meat"');
        // dd($card_number);
        return $card_number;
    }
}
