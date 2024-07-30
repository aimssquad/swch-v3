<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelFileManager implements FromCollection, WithHeadings, WithEvents
{
    private $sd;
    private $ed;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($email)
    {

        $this->email = $email;
    }
    public function collection()
    {
        $employee_code=DB::table('users')->where('email',$this->email)->first();
      $empId=$employee_code->employee_id;
      // dd($empId);
      $emp_code=DB::table('employee')->where('emid',$empId)->orWhere('emp_code',$empId)->first();
      $emp_codes=$emp_code->emp_code;

      $file_details = DB::table('file_managers')
      ->select('file_managers.*', 'notes.com_name','note.emp_fname','note.emp_lname')
      ->join('employee as note', 'file_managers.organization_id', '=', 'note.emp_code', 'left')
      ->join('registration as notes', 'note.emid', '=', 'notes.reg', 'left')
      ->where('organization_id', $emp_codes)->orWhere('emp_id',$emp_codes)
      ->orderBy('file_managers.created_at', 'desc')
      ->get();
   
        $h = 1;
        foreach ($file_details as $file) {
            $add = '';
            $add = $file->division;
            if ($file->file_name) {

                $add .= ',' . $file->file_name;
            }
            if ($file->emp_fname) {

                $add .= ',' . $file->emp_fname.' '.$file->emp_lname;
            }
            if ($file->organization_id) {

                $add .= ',' . $file->com_name;
            }
           
           

            $customer_array[] = array(
                'Sl No' => $h,
                'Emp Name' => $file->emp_fname.' '.$file->emp_lname,
                'Division' =>$file->division,
                'File Name' => $file->file_name,
                'Org Name' => $file->com_name,
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
            'Emp Name',
            'Division',
            'File Name',
            'Org Name',
        ];
    }
}
