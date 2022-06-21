<?php

namespace App\Http\Controllers;

use App\Imports\BeneficiaryImport;
use App\Models\Beneficiary;
use App\Models\BeneficiaryPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BeneficiariesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beneficiaries = Beneficiary::all();
        return view('beneficiaries.index',compact('beneficiaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('beneficiaries.create',compact('users'));
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
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required',
            'id_number' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();

        } else {
            try {

                $beneficiary_exist = Beneficiary::where('id_number',$request->id_number)->first();

                if (!$beneficiary_exist)
                {
                        // create or add beneficiaries
                        $beneficiary = new Beneficiary();
                        $beneficiary->first_name = $request->first_name;
                        $beneficiary->last_name = $request->last_name;
                        $beneficiary->mobile_number = $request->mobile_number;
                        $beneficiary->id_number = $request->id_number;
                        $beneficiary->save();

                    return redirect('beneficiaries')->with('success','New beneficiary has been added successfully');

                } else {

                    return back()->with("error","Please not that the beneficary account already exist.. Proceed to asign beneficiary to another user.");
                }

            } catch (\Exception $e) {
                echo "Error - ".$e;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $beneficiary = Beneficiary::findOrFail($id);
        $beneficiary->delete();

        return redirect('beneficiaries')->with('success','Beneficiary has been deleted successfully.');
    }

    public function assignBeneficiary()
    {
        $users = User::all();
        $beneficiaries = Beneficiary::latest()->get();
        return view('beneficiaries.assign-beneficiary',compact('users','beneficiaries'));
    }

    public function getIdNumber($beneficiary)
    {
        $benefit = DB::table('beneficiaries')
                            ->where([['id', '=', $beneficiary]])
                            ->pluck('id_number');

        return response()->json($benefit);
    }

    public function assignBeneficiaryPost(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'paynumber' => 'required',
            'beneficiary' => 'required',
            'id_number' => 'required'
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            try {
                $user = User::findOrFail($request->paynumber);

                $benefici = Beneficiary::findOrFail($request->beneficiary);

                // check if the beneficiary has been assigned to the user
                $users_a = DB::table('beneficiary_user')
                            ->where([
                                ['user_id', '=', $request->paynumber],
                                ['beneficiary_id', '=', $request->beneficiary]])
                            ->first();

                if (!$users_a)
                {
                    $assign_benef = DB::table('beneficiary_user')->insert([
                        [
                            'user_id' => $request->paynumber,
                            'beneficiary_id' => $request->beneficiary
                        ],
                    ]);

                    if ($assign_benef)
                    {
                        // create a password for the user and add password to the beneficiary

                        $user_password = BeneficiaryPassword::create([
                            'id_number' => $benefici->id_number,
                            'pin' => $user->pin,
                            'paynumber' => $user->paynumber,
                        ]);
                        $user_password->save();

                        return back()->with('success','Beneficiary has been assigned successfully.');

                    } else {

                        return back()->with('error','Your request failed.');
                    }

                } else {

                    return redirect()->back()->with('error','Beneficiary has already been assigned to user.')->withInput();
                }

            } catch(\Exception $e) {
                echo "Error - ".$e;
            }

        }
    }

    public function  getImport()
    {
        return view('beneficiaries.import');
    }

    public function postImport(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'beneficiary' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Excel::import(new BeneficiaryImport,request()->file('beneficiary'));

        return redirect('beneficiaries')->with('Data has been imported successfully');
    }

    public function allEmployeeAndBeneficiaries()
    {
        $beneficiaries = DB::table('beneficiary_user')->get();

        return view('beneficiaries.all-employee-beneficiary',compact('beneficiaries'));
    }
}
