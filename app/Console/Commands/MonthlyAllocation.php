<?php

namespace App\Console\Commands;

use App\Models\Allocation;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MonthlyAllocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'allocation:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Users food humber monthly allocation. This task is to run monthly without fail.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $users = User::where('activated',1)->get();

        foreach ($users as $user)
        {
            // check if the user has been allocated before
            $allocation = Allocation::where('paynumber',$user->paynumber)->orderByDesc('created_at')->first();

            if ($allocation)
            {
                $date = \Carbon\Carbon::now();
                $lastMonth =  $date->subMonth()->format('FY');
                $paynu_all = $user->paynumber.$lastMonth;

                $current_date = \Carbon\Carbon::now()->format('FY');
                $current_alloc = $user->paynumber.$current_date;

                // check if user has been allocated for that month
                $current_month_allocation  = Allocation::where('allocation',$current_alloc)->first();

                if (!$current_month_allocation)
                {
                    $user_allocation_last = Allocation::where('allocation',$paynu_all)->where('paynumber',$user->paynumber)->first();

                    if ($user_allocation_last)
                    {
                        $new_allocation = Allocation::create([
                            'allocation' => $current_alloc,
                            'paynumber' => $user->paynumber,
                            'food_allocation' => 1,
                            'meet_allocation' => 1,
                            'status' => 'not collected',
                            'meet_a' => $user_allocation_last->meet_a,
                            'meet_b' => $user_allocation_last->meet_b,
                        ]);
                        $new_allocation->save();

                        if ($new_allocation->save())
                        {
                            $user->fcount += 1;
                            $user->mcount += 1;
                            $user->save();

                            Log::info("Allocation for $user->full_name has been created.");
                        }
                    } else {

                        $new_allocation = Allocation::create([
                            'allocation' => $current_alloc,
                            'paynumber' => $user->paynumber,
                            'food_allocation' => 1,
                            'meet_allocation' => 1,
                            'status' => 'not collected',
                            'meet_a' => $allocation->meet_a,
                            'meet_b' => $allocation->meet_b,
                        ]);
                        $new_allocation->save();

                        if ($new_allocation->save())
                        {
                            $user->fcount += 1;
                            $user->mcount += 1;
                            $user->save();

                            Log::info("Allocation for $user->full_name has been created.");
                        }
                    }

                } else {
                    Log::info(" $user->full_name has been allocated already.");
                }

            } else {
                Log::info("$user->full_name has no allocation in the system.");
            }

        }
    }
}
