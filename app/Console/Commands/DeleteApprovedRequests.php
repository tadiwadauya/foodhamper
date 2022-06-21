<?php

namespace App\Console\Commands;

use App\Models\FoodRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteApprovedRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:approved';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to delete approved requests which are not collected on the date';

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
        $requests = FoodRequest::where('status','=','approved')->get();

        $deleted = array();

        foreach($requests as $request)
        {
            try {

                $paynumber = $request->paynumber;
                $month = $request->job->card_month;
                $jobcard_month = $paynumber.$month;

                $request->delete();

                if($request->delete())
                {
                    if($request->allocation == $jobcard_month)
                    {
                        $request->job->issued -= 1;
                        $request->job->remaining += 1;
                        $request->job->save();

                    } else {

                        $request->job->extras_previous -= 1;
                        $request->job->remaining += 1;
                        $request->job->save();
                    }

                    array_push($deleted,$request->request);
                }

            } catch (\Exception $e) {
                echo "Error - ".$e;
            }
        }

        Log::info($deleted);
    }
}
