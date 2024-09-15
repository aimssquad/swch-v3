<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Session;
use DB;


class PDFController extends Controller
{
    public function exportPDF(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

        $companyDetails = [
            'name' => $Roledata->com_name,
            'address' => $Roledata->address,
            'phone' => $Roledata->p_no,
            'email' => $Roledata->email,
            'address2' => $Roledata->address2,
            'city' => $Roledata->city,
            'zip' => $Roledata->zip
        ];

        $tableData = json_decode($request->data, true);
        $tableHeadings = json_decode($request->headings, true);

        $pdf = PDF::loadView('employeer.pdf.tableExport', compact('companyDetails', 'tableData', 'tableHeadings'));
        return $pdf->setPaper('a4', 'landscape')->download($request->filename . '.pdf');
        } else {
            return redirect('/');
        }
    }
}