<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\BulkExport;
use App\Imports\BulkImport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class ImportExportController extends Controller
{
    /**
    * 
    */

    public function importExportView()
    {
       return view('importexport');
    }
    public function import() 
    {
        Excel::import(['name','email'],request()->file('file'));
           
        return back();
    }
}