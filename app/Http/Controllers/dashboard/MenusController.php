<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemMenus;

class MenusController extends Controller
{
    public function index($route)
    {
        // Retrieve data passed from FirstController or SecondController
        //$data = session('data');
        //$data['route'] = $route;
        // Add route specific data
        //return view('menu', compact('data'));

        // $parentMenu = SystemMenus::where('route', $route)->first();
        // $subMenus = $parentMenu ? $parentMenu->children()->orderBy('order')->get() : collect();
        // $parentMenu = SystemMenus::where('route', $route)->first();
        // return view('pages.dashboard.dashboard', compact('subMenus'));

        $route = $route ?? 'home';
        $data = session('data');
        $mainMenus = SystemMenu::whereNull('parent_id')->orderBy('order')->get();
        foreach ($mainMenus as $menu) {
            $menu->subMenus = $menu->children()->orderBy('order')->get();
        }
        return view('pages.dashboard.dashboard', compact('mainMenus', 'data'));


    }
}
