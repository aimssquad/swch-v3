<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeeExcelReport implements FromCollection, WithHeadings, WithEvents
{
    private $sd;
    private $ed;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($reg)
    {

        $this->reg = $reg;
    }
    public function collection()
    {
        $employeedata = DB::table('employee')               
        ->where('emid','=',$this->reg) 
        ->get();
        $h = 1;
        foreach ($employeedata as $file) {
           
           
            $customer_array[] = array(
                'Sl No' => $h,
                'Emo Code' =>$file->emp_code,
                'Emp Name' => $file->emp_fname.' '.$file->emp_lname,
                'Father Name' =>$file->emp_father_name,
                'Caste'=>$file->emp_caste,
                'Religion'=>$file->emp_religion,
                'Department'=>$file->emp_department,
                'Designation'=>$file->emp_designation,
                'Reporting Auth'=>$file->emp_reporting_auth,
                'Lv Sanc Auth'=>$file->emp_lv_sanc_auth,
                'emp_eligible_promotion'=>$file->emp_eligible_promotion,
                'Date of birth'=>$file->emp_dob,
                'Date of join'=>$file->emp_doj,
                'Retirement Date'=>$file->emp_retirement_date,
                'Increament Date'=>$file->emp_next_increament_date,
                'Emp Status'=>$file->emp_status,
                'Street No'=>$file->emp_pr_street_no,
                'City'=>$file->emp_pr_city,
                'State'=>$file->emp_pr_state,
                'Country'=>$file->emp_pr_country,
                'Pincode'=>$file->emp_pr_pincode,
                'Mobile'=>$file->emp_pr_mobile,
                'Post Office'=>$file->emp_per_post_office,
                'Village'=>$file->emp_per_village,
                'Dist'=>$file->emp_per_dist,
                'Police Station'=>$file->emp_per_policestation,
                'Street No'=>$file->emp_ps_street_no,
                'emp_ps_city'=>$file->emp_ps_city,
                'emp_ps_state'=>$file->emp_ps_state,
                'emp_ps_country'=>$file->emp_ps_country,
                'emp_ps_pincode'=>$file->emp_ps_pincode,
                'emp_ps_phone'=>$file->emp_ps_phone,
                'emp_ps_email'=>$file->emp_ps_email,
                
            );
            $h++;
        }
        return collect($customer_array);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:L1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FFA500');
            },

        ];
    }    
    public function headings(): array
    {
        return [
                'Sl No',
                'Emo Code',
                'Emp Name',
                'Father Name',
                'Caste',
                'Religion',
                'Department',
                'Designation',
                'Reporting Auth',
                'Lv Sanc Auth',
                'emp_eligible_promotion',
                'Date of birth',
                'Date of join',
                'Retirement Date',
                'Increament Date',
                'Emp Status',
                'Street No',
                'City',
                'State',
                'Country',
                'Pincode',
                'Mobile',
                'Post Office',
                'Village',
                'Dist',
                'Police Station',
                'Street No',
                'emp_ps_city',
                'emp_ps_state',
                'emp_ps_country',
                'emp_ps_pincode',
                'emp_ps_phone',
                'emp_ps_email',
        ];
    }
}
