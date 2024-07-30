<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Payroll\PfOpeningBalance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PfOpeningBalanceImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        // dd($row);

        if ($row['emp_financial_year'] != '') {
            $data = PfOpeningBalance::where('emp_financial_year', '=', $row['emp_financial_year'])->where('emp_code', '=', $row['emp_code'])->first();
            if (empty($data)) {
                return new PfOpeningBalance([
                    'emp_code' => $row['emp_code'],
                    'emp_name' => $row['emp_name'],
                    'member_balance' => $row['member_balance'],
                    'company_balance' => $row['company_balance'],
                    'total_balance' => $row['total_balance'],
                    'emp_financial_year' => $row['emp_financial_year'],
                ]);
            }

        }
        return;
    }
}
