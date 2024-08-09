<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cdrs;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CdrsExport;

class DashboardController extends Controller
{
    protected $cdrs;

    public function __construct(){

        $this->cdrs = new Cdrs();

    }
    public function excelExport(Request $request){
        $export_date = $request->export_date;
        $export_month = $request->export_month;
        $export_year = $request->export_year;

        if(!empty($export_date)){
            $cdrs = Cdrs::where('calldate', 'like', '%' . $export_date . '%')->get();
        }elseif(!empty($export_month)){
            $cdrs = Cdrs::where('calldate', 'like', '%' . $export_month . '%')->get();
        }elseif(!empty($export_year)){
            $cdrs = Cdrs::where('calldate', 'like', '%' . $export_year . '%')->get();
        } else {
            $cdrs = Cdrs::all();
        }
        $time = time();

        return Excel::download(new CdrsExport($cdrs), 'cdrs_'.$time.'.xlsx');

    }
}
