<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemMenus;
use App\Models\RoutesPermissions;

class RepostsController extends Controller
{
    public function index($route = null)
    {
        $route = $route ?? 'index.reports';
        $route = $route ?? 'home';
        $data = session('data');

        // Fetch the main menu items
        $mainMenus = SystemMenus::whereNull('parent_id')
                                ->orderBy('order')
                                ->get();
        $subsMenus = SystemMenus::where('route',$route)
                                ->orderBy('order')
                                ->get();
        foreach ($subsMenus as $submenu) {
            $submenu->subMenus = $submenu->orderBy('order')->get();
        }

        foreach ($mainMenus as $menu) {
            $menu->subMenus = $menu->children()->orderBy('order')->get();
        }
        $getRoutename = request()->route()->getName();
        $routesPermissions = RoutesPermissions::where('route',$getRoutename)->orderBy('id')->get();
        $getAllRoutePermisssions = RoutesPermissions::all();
        foreach ($routesPermissions as $routesPermission) {
            $routesPermission = $routesPermission->orderBy('id')->get();
        }

        $remindersRoute = request()->route()->getName();
        $parentid = 7;
        $mainRouteName = 'index.reports';
        //dd($mainMenus);
        return view('pages.dashboard.reports.index', compact('mainMenus', 'data','mainRouteName', 'remindersRoute','routesPermissions','getAllRoutePermisssions'));

    }


}
