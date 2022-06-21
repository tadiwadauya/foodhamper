<?php

namespace App\Http\Controllers;

use App\Imports\DepartmentImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\MockObject\Stub\ReturnStub;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        return view('departments.index',compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('departments.create',compact('users'));
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
                'name' => 'required|unique:departments',
            ]
        );

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();

        } else {

            try {

                $department = new Department();
                $department->name = strip_tags($request->input('name'));

                if ($request->manager !== null || !empty($request->manager))
                {
                    $dept_manager = Department::where('manager',$request->manager)
                                                ->orWhere('assistant',$request->manager)
                                                ->first();

                    if ($dept_manager)
                    {
                        return back()->with('error','Department can only have one Manager');
                    }else{
                        $department->manager = $request->manager;
                    }
                }

                if ($request->assistant !== null || !empty($request->assistant))
                {
                    $dept_assistant = Department::where('assistant',$request->assistant)
                                                    ->orWhere('manager',$request->assistant)
                                                    ->first();
                    if ($dept_assistant)
                    {
                        return back()->with('error','Department can only have one Assistant Manager');
                    }else {
                        $department->assistant = $request->assistant;
                    }
                }

                $department->save();

                return redirect('departments')->with('success','Department has been created successfully.');


            } catch (\Exception $e) {

                return back()->with('error','Failed to save department.');
            }
        }

        return back()->with('error','Something went wrong');

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
        $users = User::all();
        $department = Department::findOrFail($id);
        return view('departments.edit',compact('users','department'));
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
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:departments,column,except,id',
            ]
        );

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
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
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect('departments')->with('success','Department has been deleted successfully.');
    }

    public function assignManager()
    {
        $users = User::all();
        return view('departments.assign-manager',compact('users'));
    }

    public function assignManagerPost(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            'paynumber' => 'required',
            'department' => 'required',
            'check' => 'required',
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        else {
            try{

                $department = Department::where('manager',$request->paynumber)
                                        ->orWhere('assistant',$request->paynumber)
                                        ->first();
                if ($department)
                {
                    return back()->with('error','Employee is already the department manager');

                }else{
                    $user_department = Department::where('id',$request->department)->first();

                    if ($request->check == 'manager')
                    {
                        $user_department->manager = $request->paynumber;
                    }

                    if ($request->check == 'assistant')
                    {
                        $user_department->assistant = $request->paynumber;
                    }
                    $user_department->save();

                    return redirect('departments')->with('success','Employee has been set as the department manager.');
                }


            }catch (\Exception $e) {
                return back()->with('error','Failed to assign department manager');
            }
        }
    }

    public function getDepartment($paynumber)
    {
        $user = User::where('paynumber',$paynumber)->first();
        $department = Department::where('id',$user->department_id)
                    ->pluck('name','id');

        return response()->json($department);
    }

    public function importDepartments()
    {
        return view('departments.import');
    }

    public function downloadDepartmentForm()
    {
        $myFile = public_path("starter-downloads/departmentsimport.xlsx");

        return response()->download($myFile);
    }

    public function departmentImportSend(Request $request) {

        $validator = Validator::make($request->all(),[
            'department' => 'required',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Excel::import(new DepartmentImport,request()->file('department'));

        return redirect('departments')->with('Data has been imported successfully');
    }
}
