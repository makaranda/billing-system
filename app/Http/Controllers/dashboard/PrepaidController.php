<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemMenus;
use App\Models\RoutesPermissions;

class PrepaidController extends Controller
{
    public function index()
    {

        //return view('pages.dashboard.prepaid.customers');
        $route = $route ?? 'home';
        $data = session('data');
        $mainMenus = SystemMenus::whereNull('parent_id')->orderBy('order')->get();
        foreach ($mainMenus as $menu) {
            $menu->subMenus = $menu->children()->orderBy('order')->get();
        }

        $getRoutename = request()->route()->getName();
        $routesPermissions = RoutesPermissions::where('route',$getRoutename)->orderBy('id')->get();
        $getAllRoutePermisssions = RoutesPermissions::all();
        foreach ($routesPermissions as $routesPermission) {
            $routesPermission = $routesPermission->orderBy('id')->get();
        }

        $mainRouteName = 'index.prepaid';
        return view('pages.dashboard.prepaid.index', compact('mainMenus', 'data','mainRouteName','routesPermissions','getAllRoutePermisssions'));
    }

}
