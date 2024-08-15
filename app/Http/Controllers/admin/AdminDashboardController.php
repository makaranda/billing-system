<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemMenus;
use App\Models\RoutesPermissions;
use App\Models\SystemUsers;
use App\Models\UserPrivileges;

class AdminDashboardController extends Controller
{
    //protected $cdrs;
    public function __construct(){
        //$this->cdrs = new Cdrs();
    }

    public function index()
    {
        //$cdrs = Cdrs::all();
        //return view('pages.dashboard.index', ['cdrs' => $cdrs]);
        $data = session('data');
        $mainMenus = SystemMenus::whereNull('parent_id')->orderBy('order')->get();
        foreach ($mainMenus as $menu) {
            $menu->subMenus = $menu->children()->orderBy('order')->get();
        }

        $getRoutename = request()->route()->getName();
        $routesPermissions = RoutesPermissions::where('route',$getRoutename)->orderBy('id')->get();
        $userPrivileges = UserPrivileges::where('id',Auth::user()->privilege)->first();
        $getAllRoutePermisssions = RoutesPermissions::all();
        foreach ($routesPermissions as $routesPermission) {
            $routesPermission = $routesPermission->orderBy('id')->get();
        }
        $mainRouteName = 'index.dashboard';
        return view('pages.dashboard.dashboard', compact('mainMenus', 'data','routesPermissions','mainRouteName','getAllRoutePermisssions','userPrivileges'));
    }

    public function usersAvailability(){
        $message = '';
        $systemUsers = SystemUsers::where('id', Auth::user()->id)
                          ->first();

        if($systemUsers->id){
            if(($systemUsers->id == Auth::user()->id) && ($systemUsers->status == 0)){
                $message = 'inactive';
                //Auth::guard('admin')->logout();
            }else{
                $message = 'active';
            }
        }else{
            $message = 'error';
        }

        $responseData = [
            'message' => $message,
        ];
        //echo 'test';
        //return $message;
        return response()->json($responseData);
    }


    public function users()
    {
        return view('login.index');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('login.index');
    }
}
