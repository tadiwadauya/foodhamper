<?php

namespace Database\Seeders;

use App\Models\Beneficiary;
use App\Models\Department;
use App\Models\Jobcard;
use App\Models\Usertype;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\ConnectRelationshipsSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Department::truncate();
        Usertype::truncate();
        Beneficiary::truncate();
        Jobcard::truncate();

        Model::unguard();
        \App\Models\Department::factory(2)->create();
        \App\Models\Usertype::factory(2)->create();

        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ConnectRelationshipsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(HumberSeeder::class);
         $this->call(JobcardSeeder::class);

        \App\Models\Beneficiary::factory(20)->create();

        Model::reguard();
    }
}
