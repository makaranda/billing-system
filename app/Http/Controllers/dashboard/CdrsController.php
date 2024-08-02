<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cdrs;

class CdrsController extends Controller
{
    protected $cdrs;
    public function __construct(){
        $this->cdrs = new Cdrs();
    }

    public function index(){
        $cdrs = Cdrs::all();
        return view('pages.dashboard.index', ['cdrs' => $cdrs]);
    }
}
