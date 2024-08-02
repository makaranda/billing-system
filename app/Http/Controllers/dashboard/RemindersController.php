<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemMenus;
use App\Models\RoutesPermissions;

class RemindersController extends Controller
{
    public function index($route = null)
    {
        $route = $route ?? 'index.reminders';

        $route = $route ?? 'home';
        $data = session('data');
        $mainMenus = SystemMenus::whereNull('parent_id')->orderBy('order')->get();
        foreach ($mainMenus as $menu) {
            $menu->subMenus = $menu->children()->orderBy('order')->get();
        }
        $getRoutename = request()->route()->getName();
        $routesPermissions = RoutesPermissions::where('route',$getRoutename)->orderBy('id')->get();
        foreach ($routesPermissions as $routesPermission) {
            $routesPermission = $routesPermission->orderBy('id')->get();
        }

        $remindersRoute = '';
        //dd($mainMenus);
        $mainRouteName = 'index.reminders';
        return view('pages.dashboard.reminders.index', compact('mainMenus', 'data','mainRouteName', 'remindersRoute','routesPermissions'));

    }

}
