<?php

namespace App\Imports;

use App\Models\MeatAllocation;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MeatAllocationsImport implements ToCollection, WithHeadingRow, WithBatchInserts
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $user = User::where('paynumber', $row['paynumber'])->first();

            if ($user) {

                if (!empty($row['paynumber']) && !empty($row['meatallocation']) && !empty($row['meat_a']) && !empty($row['meat_b'])) {
                    $meatallocation = MeatAllocation::create([
                        'paynumber' => $row['paynumber'],
                        'meatallocation' => $row['meatallocation'],
                        'meat_a' => $row['meat_a'],
                        'meat_b' => $row['meat_b'],
                        'meat_allocation' => 1,
                    ]);

                    $meatallocation->save();
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
