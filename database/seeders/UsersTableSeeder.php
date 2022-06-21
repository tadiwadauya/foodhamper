<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = config('roles.models.role')::where('name', '=', 'User')->first();
        $adminRole = config('roles.models.role')::where('name', '=', 'Admin')->first();
        $permissions = config('roles.models.permission')::all();

        /*
         * Add Users
         *
         */

        // admin user
        $pin = 1234;
        $adminiEmail = 'vmarufu@whelson.co.zw';
        $newUser = User::where('email','=', $adminiEmail)->first();
        if($newUser === null){
            $newUser = User::create([
                'name'     => 'vmarufu',
                'paynumber'     => 'APPS244',
                'first_name'     => 'Vincent',
                'last_name'     => 'Marufu',
                'department_id'     => 1,
                'usertype_id'     => 1,
                'email'    => $adminiEmail,
                'password' => bcrypt('password'),
                'activated' => 1,
                'pin' => Hash::make($pin),

            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
            $newUser->save();
        }

        // test user
        $newUser = User::where('email', '=', 'user@user.com')->first();
        if($newUser === null){
            $newUser = User::create([
                'name'     => 'User',
                'paynumber'     => 'APPS214',
                'first_name'     => 'Tats',
                'last_name'     => 'Hover',
                'department_id'     => 2,
                'usertype_id'     => 2,
                'email'    => 'user@user.com',
                'password' => bcrypt('password'),
                'activated' => 1,
                'pin' => Hash::make($pin),
            ]);

            $newUser->attachRole($userRole);
            $newUser->save();
        }

    }
}
