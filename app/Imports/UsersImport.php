<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\User;
use App\Models\Usertype;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UsersImport implements ToCollection , WithHeadingRow ,WithBatchInserts
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $permissions = config('roles.models.permission')::all();

        foreach ($rows as $row)
        {
            $current = User::where('paynumber',$row['paynumber'])->first();
            $userRole = config('roles.models.role')::where('name', '=', 'User')->first();

            if (!$current)
            {
                try{

                    if (!empty($row['first_name']) && !empty($row['department_id']) && !empty($row['last_name']) && !empty($row['paynumber']) && !empty($row['usertype_id']))
                    {
                        $first = substr($row['first_name'],0,1);
                        $username = Str::lower($first.$row['last_name']);

                        $department = Department::where('name',$row['department_id'])->first();
                        $usertype = Usertype::where('type',$row['usertype_id'])->first();

                        $newUser = User::create([
                            'name' => $username,
                            'paynumber' => $row['paynumber'],
                            'first_name' => strip_tags($row['first_name']),
                            'last_name' => strip_tags($row['last_name']),
                            'password' => Hash::make('password'),
                            'activated' => 1,
                            'pin' => Hash::make('1234'),
                            'department_id' => $department->id,
                            'usertype_id' => $usertype->id,
                        ]);

                        $newUser->attachRole($userRole);
                        $newUser->save();
                    }

                } catch (\Exception $e){
                    Log::info($e);
                }
            }
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
