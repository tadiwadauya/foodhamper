<?php

namespace App\Imports;

use App\Models\Beneficiary;
use App\Models\BeneficiaryPassword;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BeneficiaryImport implements ToCollection ,WithHeadingRow,WithBatchInserts
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if(!empty($row['paynumber']) && !empty($row['first_name']) )
            {
                $user = User::where('paynumber',$row['paynumber'])->first();

                if ($user)
                {
                    $beneficiary_exists = Beneficiary::where('id_number',$row['id_number'])->first();

                    if (!$beneficiary_exists)
                    {
                        $beneficiary_u = new Beneficiary();
                        $beneficiary_u->first_name = $row['first_name'];
                        $beneficiary_u->last_name = $row['last_name'];

                        if (empty($row['id_number']))
                        {
                            $create_id_num = $row['paynumber'].$row['last_name'];
                            $beneficiary_u->id_number = $create_id_num;

                        } else {
                            $beneficiary_u->id_number = $row['id_number'];
                        }

                        if (empty($row['mobile_number']))
                        {
                            $beneficiary_u->mobile_number = 000;
                        } else {
                            $beneficiary_u->mobile_number = $row['mobile_number'];
                        }

                        $beneficiary_u->save();

                        if ($beneficiary_u->save())
                        {
                            $assign_benef = DB::table('beneficiary_user')->insert([
                                [
                                    'user_id' => $user->id,
                                    'beneficiary_id' => $beneficiary_u->id
                                ],
                            ]);

                            if ($assign_benef)
                            {
                                // create a password for the user and add password to the beneficiary

                                $user_password = BeneficiaryPassword::create([
                                    'id_number' => $beneficiary_u->id_number,
                                    'pin' => $user->pin,
                                    'paynumber' => $user->paynumber,
                                ]);
                                $user_password->save();

                            }
                        }

                    } else {
                        dd("part is not coded yet");
                    }
                }
            }
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
