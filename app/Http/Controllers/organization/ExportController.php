<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\DynamicExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportTableData(Request $request)
    {

       // dd($request->all());
        $data = json_decode($request->input('data'), true);
        $headings = json_decode($request->input('headings'), true);
        $filename = $request->input('filename');

        return Excel::download(new DynamicExport($data, $headings), $filename);
    }
}
