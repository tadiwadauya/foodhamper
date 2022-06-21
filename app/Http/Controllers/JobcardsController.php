<?php

namespace App\Http\Controllers;

use App\Imports\JobcardImport;
use App\Models\Jobcard;
use Illuminate\Http\Request;
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
        return view('jobcards.index',compact('jobcards'));
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
        $validator = Validator::make($request->all(),[
            'card_number' => 'required|unique:jobcards',
            'date_opened' => 'required',
            'card_month' => 'required',
            'card_type' => 'required',
            'quantity' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else {
            try {
                if ($request->card_type == "food")
                {
                    $food = Jobcard::where('card_type','=','food')->get();

                    if($food->count() == 0)
                    {
                        $card = Jobcard::create([
                            'card_number' => $request->input('card_number'),
                            'date_opened' => $request->input('date_opened'),
                            'card_month' => $request->input('card_month'),
                            'card_type' => $request->input('card_type'),
                            'quantity' => $request->input('quantity'),
                            'remaining' => $request->input('quantity'),
                        ]);
                        $card->save();

                        return redirect('jobcards')->with('success','Jobcard has been created successfully');

                    } else {
                        $i = 0;
                        foreach ($food as $f)
                        {
                            if ($f->remaining > 0)
                            {
                                $i++;
                            }
                        }

                        if ($i > 0)
                        {
                            return back()->with('error','There is a Food jobcard with remaining units');

                        } else {
                            $card = Jobcard::create([
                                'card_number' => $request->input('card_number'),
                                'date_opened' => $request->input('date_opened'),
                                'card_month' => $request->input('card_month'),
                                'card_type' => $request->input('card_type'),
                                'quantity' => $request->input('quantity'),
                                'remaining' => $request->input('quantity'),
                            ]);
                            $card->save();

                            return redirect('jobcards')->with('success','Job card has been added successfully');
                        }
                    }
                }

                if ($request->card_type == "meat")
                {
                    $meat = Jobcard::where('card_type','=','meat')->get();

                    if($meat->count() == 0)
                    {
                        $card = Jobcard::create([
                            'card_number' => $request->input('card_number'),
                            'date_opened' => $request->input('date_opened'),
                            'card_month' => $request->input('card_month'),
                            'card_type' => $request->input('card_type'),
                            'quantity' => $request->input('quantity'),
                            'remaining' => $request->input('quantity'),
                        ]);
                        $card->save();

                        return redirect('jobcards')->with('success','Job Card has been created successfully');

                    } else {
                        $i = 0;
                        foreach ($meat as $m)
                        {
                            if ($m->remaining > 0)
                            {
                                $i++;
                            }
                        }

                        if ($i > 0)
                        {
                            return back()->with('error','There is a Meat Job Card with remaining units');

                        } else {
                            $card = Jobcard::create([
                                'card_number' => $request->input('card_number'),
                                'date_opened' => $request->input('date_opened'),
                                'card_month' => $request->input('card_month'),
                                'card_type' => $request->input('card_type'),
                                'quantity' => $request->input('quantity'),
                                'remaining' => $request->input('quantity'),
                            ]);
                            $card->save();

                            return redirect('jobcards')->with('success','Job card has been added successfully');
                        }
                    }
                }

            } catch (\Exception $e) {
                echo "Error - ".$e;
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function edit(Jobcard $jobcard)
    {
        return view('jobcards.edit',compact('jobcard'));
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
        $validator = Validator::make($request->all(),[
            'card_number' => 'required',
            'date_opened' => 'required',
            'card_month' => 'required',
            'card_type' => 'required',
            'quantity' => 'required',
            'issued' => 'required',
            'remaining' => 'required',
            'extras_previous' => 'required',

        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();

        } else {

            try {
                // checking the request type
               {

                    $total = $jobcard->issued + $jobcard->extras_previous;



                     {
                        // can edit evertthing on the card
                        $jobcard->card_number = $request->input('card_number');
                        $jobcard->date_opened = $request->input('date_opened');
                        $jobcard->card_month = $request->input('card_month');
                        $jobcard->card_type = $request->input('card_type');
                        $jobcard->quantity = $request->input('quantity');
                        $jobcard->issued = $request->input('issued');
                        $jobcard->remaining = $request->input('remaining');
                        $jobcard->extras_previous = $request->input('extras_previous');
                        $jobcard->save();

                        return redirect('jobcards')->with('success','Jobcard has been updated successfully');
                    }
                }

            } catch (\Exception $e) {
                echo "Error - ".$e;
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
        $total = $jobcard->issued + $jobcard->extras_previous;

        if ($total == 0)
        {
            $jobcard->delete();

            return redirect('jobcards')->with('success','Jobcard has been deleted successfully');
        } else {

            return back()->with('error','Job Card Cannot be deleted.');
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
        $validator = Validator::make($request->all(),[
            'jobcard' => 'required',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Excel::import(new JobcardImport,request()->file('jobcard'));

        return redirect('jobcards')->with('Data has been imported successfully');
    }
}
