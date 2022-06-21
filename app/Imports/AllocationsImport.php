<?php

namespace App\Imports;

use App\Models\Allocation;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AllocationsImport implements ToCollection, WithHeadingRow , WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $user = User::where('paynumber',$row['paynumber'])->first();

            if ($user) {
                $user_allocation = DB::table('users')
                                    ->join('allocations','users.paynumber','=','allocations.paynumber')
                                    ->select('users.*','allocations.*')
                                    ->where('users.paynumber',$user->paynumber)
                                    ->where('allocations.allocation',$row['allocation'])
                                    ->first();

                if (!$user_allocation) {

                    if (!empty($row['paynumber']) && !empty($row['allocation']) && !empty($row['meet_a']) && !empty($row['meet_b']))
                    {
                        $allocation = Allocation::create([
                            'paynumber' => $row['paynumber'],
                            'allocation' => $row['allocation'],
                            'meet_a' => $row['meet_a'],
                            'meet_b' => $row['meet_b'],
                            'meet_allocation' => 1,
                            'food_allocation' => 1,
                        ]);

                        $allocation->save();

                        if ($allocation->save()) {
                            $allocation->user->fcount += 1;
                            $allocation->user->mcount +=1;
                            $allocation->user->save();
                        }
                    }
                }
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
