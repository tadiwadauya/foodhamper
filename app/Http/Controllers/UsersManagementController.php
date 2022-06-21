<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\Department;
use App\Models\Termination;
use App\Models\User;
use App\Models\Usertype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

class UsersManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('usersmanagement.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        $usertypes = Usertype::all();
        $roles = Role::all();
        return view('usersmanagement.create',compact('departments','usertypes','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'paynumber'             => 'required|max:255|unique:users|alpha_dash',
            'first_name'            => 'required',
            'last_name'             => 'required',
            'department_id'         => 'required',
            'mobile'                => 'required',
            'activated'             => 'required',
            'usertype_id'           => 'required',
            'role'                  => 'required',
            'pin'                   => 'required',
            'password'              => 'required|min:6|max:20|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        else {

            try {
                $first = substr($request->first_name,0,1);
                $username = Str::lower($first.$request->last_name);

                $user = User::create([
                    'name' => $username,
                    'paynumber' => $request->input('paynumber'),
                    'first_name' => strip_tags($request->input('first_name')),
                    'last_name' => strip_tags($request->input('last_name')),
                    'mobile' => strip_tags($request->input('mobile')),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'activated' => $request->input('activated'),
                    'pin' => Hash::make($request->input('pin')),
                    'department_id' => $request->input('department_id'),
                    'usertype_id' => $request->input('usertype_id'),
                ]);

                $user->attachRole($request->input('role'));
                $user->save();

                return redirect('users')->with('success','User was created successfully');

            } catch (\Exception $th) {
                return redirect()->back()->with('error','Failed to create new user');
            }
        }

        return redirect()->back()->with('error','System was unable to create user account.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('usersmanagement.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $departments = Department::all();
        $usertypes = Usertype::all();
        $roles = Role::all();

        foreach ($user->roles as $user_role)
        {
            $currentRole = $user_role;
        }
        return view('usersmanagement.edit',compact('departments','usertypes','roles','user','currentRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $emailCheck = ($request->input('email') !== '') && ($request->input('email') !== $user->email);

        $validator = Validator::make($request->all(),[
            'paynumber' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'department' => 'required',
            'usertype' => 'required',
            'activated' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $first = substr($request->first_name,0,1);
        $username = Str::lower($first.$request->last_name);

        $user->name = $username;
        $user->paynumber = strip_tags($request->input('paynumber'));
        $user->first_name = strip_tags($request->input('first_name'));
        $user->last_name = strip_tags($request->input('last_name'));
        $user->department_id = $request->input('department');
        $user->usertype_id = $request->input('usertype');
        $user->mobile = $request->input('mobile');

        if($emailCheck){
            $user->email = $request->input('email');
        }

        if($request->input('password') !== null){
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->input('activated'))
        {
            if ($request->input('activated') == 1)
            {
                $user_status = $user->activated;

                if (!$user_status == 1) {

                    $user->activated = $request->input('activated');

                    $terminated = Termination::where('paynumber',$user->paynumber)->first();
                    $terminated->delete();

                }

            } else {

                $user->activated = $request->input('activated');

                $terminator = Termination::create([
                    'paynumber' => $user->paynumber,
                    'department' => $user->department_id,
                    'reason' => 'Please contact Hr for classified information',
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                ]);
                $terminator->save();

            }

        }

        if ($request->input('role'))
        {
            $userRole = $request->input('role');
            if($userRole !== null){

                foreach (Auth::user()->roles as $user_role)
                {
                    if ($user_role->id !== 1)
                    {
                        return redirect()->back()->with('error','You do not have permission to edit your role');

                    } else {
                        $user->detachAllRoles();
                        $user->attachRole($userRole);
                    }
                }


            }
        }
        $user->save();

        return redirect()->back()->with('success','User has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentUser = Auth::user();
        $user = User::findOrFail($id);

        if ($user->id != $currentUser->id) {
            $user->activated = 0;
            $user->save();
            $user->delete();
            return redirect('users')->with('success','User has been deleted successfully');
        }

        return back()->with('error','You cannot delete your own account.');
    }

    public function deActivateUser($id)
    {
        $user = User::find($id);

        if($user->activated == 1)
        {
            $deactivate = DB::table('users')
                ->where('id', $id)
                ->update(['activated' => 0]);

            if ($deactivate)
            {
                return redirect('users')->with('success','User has been deactivated successfully. Please not that user will not be allocated as from date..');
            }
            else{
                return redirect()->back()->with('error','Failed to deactivate users');
            }
        }


        return redirect('users')->with('info',"The selected user is already deactivated.");

    }

    public function terminateForm()
    {
        $users = User::all();
        return view('usersmanagement.terminate',compact('users'));
    }

    public function terminatePost(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'paynumber' => 'required',
            'department' => 'required',
            'reason' => 'required',
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        } else {

            try {

                $user = User::where('paynumber',$request->paynumber)->first();

                if($user->activated == 1)
                {
                    $deactivate = DB::table('users')
                        ->where('id', $user->id)
                        ->update(['activated' => 0]);

                    if ($deactivate)
                    {
                        $terminator = Termination::create([
                            'paynumber' => $request->input('paynumber'),
                            'department' => $user->department_id,
                            'reason' => $request->input('reason'),
                            'first_name' => $user->first_name,
                            'last_name' => $user->last_name,
                        ]);
                        $terminator->save();

                        return redirect('users')->with('success','User has been deactivated successfully. Please not that user will not be allocated as from date..');
                    }
                    else{
                        return redirect()->back()->with('error','Failed to deactivate users');
                    }
                } else {

                    return back()->with('error','Employee has already been terminated');
                }

            } catch (\Exception $e)
            {
                echo "Error - ".$e;
            }
        }
    }

    public function resetPinForm()
    {
        $users = User::all();
        return view('usersmanagement.pin-reset',compact('users'));
    }

    public function resetPinPost(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'paynumber' => 'required',
            'department' => 'required',
            'pin' => 'required|min:4|max:6',
            'confirm-pin' => 'required|same:pin',
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        } else {
            try {
                $user = User::where('paynumber',$request->paynumber)->first();
                $user->pin = $request->input('pin');
                $user->save();

                if ($user->save())
                {

                    foreach($user->beneficiaries as $beneficiary)
                    {
                        $id_number = $beneficiary->id_number;
                        $paynumber = $user->paynumber;
                        $pin = $user->pin;

                        $affected = DB::table('beneficiary_passwords')
                                    ->where([['id_number','=',$id_number],['paynumber','=',$paynumber]])
                                    ->update(['pin' => $pin]);
                    }

                    return  redirect()->back()->with('success','Password has been updated successfully');
                }

            } catch (\Exception $e) {
                echo "Error - ".$e;
            }
        }
    }

    public function importUsers()
    {
        return view('usersmanagement.import');
    }

    public function downloadUsersForm()
    {
        $myFile = public_path("starter-downloads/usersimport.xlsx");

        return response()->download($myFile);
    }

    public function usersImportSend(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'users' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Excel::import(new UsersImport,request()->file('users'));

        return redirect('users')->with('Data has been imported successfully');
    }
}
