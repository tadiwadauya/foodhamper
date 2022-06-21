<?php

namespace App\Console\Commands;

use App\Models\FoodRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteUnattendedRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unattended:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the requests which are unattended. this tasks is to run daily without fail';

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
        $requests = FoodRequest::where('status','=','not approved')->get();

        $deleted = array();

        foreach($requests as $request)
        {
            $request->delete();

            if($request->delete())
            {
                array_push($deleted,$request->request);
            }
        }

        Log::info($deleted);
    }
}
