<?php

namespace App\Imports;

use App\Models\Jobcard;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobcardImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $jobcard_exists = Jobcard::where('card_number',$row['card_number'])->first();

            if (!$jobcard_exists)
            {
                $new = Jobcard::create([
                    'card_number' => $row['card_number'],
                    'card_type' => $row['card_type'],
                    'date_opened' => $row['date_opened'],
                    'card_month' => $row['card_month'],
                    'quantity' => $row['quantity'],
                    'issued' => $row['issued'],
                    'remaining' => $row['remaining'],
                    'extras_previous' => $row['extras_previous'],
                ]);

                $new->save();
            }
        }
    }
}
