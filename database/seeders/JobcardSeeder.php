<?php

namespace Database\Seeders;

use App\Models\Jobcard;
use Illuminate\Database\Seeder;

class JobcardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = now();

        $card1 = Jobcard::create([
            'card_number' => '124569',
            'date_opened' => $date,
            'card_month' => 'September2021',
            'card_type' => 'food',
            'quantity' => 10,
            'remaining' => 10,
        ]);
        $card1->save();

        $card2 = Jobcard::create([
            'card_number' => '127769',
            'date_opened' => $date,
            'card_month' => 'September2021',
            'card_type' => 'meat',
            'quantity' => 10,
            'remaining' => 10,
        ]);
        $card2->save();
    }
}
